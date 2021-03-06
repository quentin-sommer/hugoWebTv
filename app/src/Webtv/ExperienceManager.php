<?php

namespace Webtv;

use Carbon\Carbon;
use Illuminate\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Models\ExpLevel;
use Models\User;

class ExperienceManager
{
    /**
     * Normal behavior
     */
    const OK = 0;
    /**
     * De-synced by network or something else
     * Need to startWatching()
     */
    const NEED_RESYNC = 1;
    /**
     * Data is invalid, can't process
     * Need to startWatching()
     */
    const INVALID = 2;
    /**
     * @var int Minimum time in minutes to wait before a new xp request is valid
     */
    protected $mnBetweenReq;
    /**
     * @var int Authorized latency for a xp request
     */
    protected $allowedLatency;
    /**
     * @var int xp points given per requests
     */
    protected $xpPerRequest;
    /**
     * @var int maximum available level
     */
    protected $maxLevel;
    /**
     * @var Guard auth user
     */
    protected $user;

    public function __construct()
    {
        $this->mnBetweenReq = env('EXP_REQUEST_INTERVAL');
        $this->allowedLatency = env('EXP_REQUEST_ALLOWED_LATENCY');
        $this->xpPerRequest = env('EXP_AMOUNT_PER_REQUEST');
        $this->maxLevel = env('MAX_LEVEL');

        $this->user = Auth::user();
    }

    /**
     * @param $data
     * @return array|null
     */
    public function processExpRequest($data)
    {
        switch ($this->requestIsValid($data)) {
            case(self::OK) :

                // Update user experience, send new token and user info
                return $this->updateExperience();
                break;
            case(self::NEED_RESYNC) :

                // Tell user to resync
                return self::NEED_RESYNC;
                break;
            case(self::INVALID) :

                // Tell user to resync
                return self::NEED_RESYNC;
                break;
        }
    }

    /**
     * @param array $data
     * @return int
     */
    private function requestIsValid(Array $data)
    {

        if ($data['token'] !== $this->user->experience_token) {
            return self::INVALID;
        }

        $lastSeen = Carbon::createFromFormat('Y-m-d H:i:s', $this->user->last_seen_watching);
        if ($lastSeen !== false) {
            $now = Carbon::now()->second(0);
            $lastSeen->second(0);

            $maxDelay = $this->mnBetweenReq + $this->allowedLatency;

            if ($now->diffInMinutes($lastSeen) >= $maxDelay) {
                // timed out, need to resync
                return self::NEED_RESYNC;
            }
            if ($now->diffInMinutes($lastSeen) < $this->mnBetweenReq) {
                // too early
                return self::NEED_RESYNC;
            }

            // in time
            return self::OK;
        }

        // no valid date time stored
        return self::INVALID;
    }

    /**
     * @return array
     */
    private function updateExperience()
    {
        $oldExp = $this->user->experience;
        $oldLevel = $this->user->level;
        $expForOldLevel = ExpLevel::where('level', $oldLevel)->first()->experience;
        $sumExp = $oldExp + $this->xpPerRequest;
        $levelUp = ($expForOldLevel - $sumExp < 0) ? true : false;

        if ($levelUp) {
            $newLevel = $this->user->level + 1;

            if ($newLevel <= $this->maxLevel) {
                // Attribute new level and reset xp progression
                $newExp = $sumExp - $oldExp;
                $this->user->level = $newLevel;
            }
            else {
                // CASE MAX LEVEL
                $newExp = ExpLevel::where('level', $this->maxLevel)
                    ->first()->experience;
            }
        }
        else {
            $newExp = $sumExp;
        }
        $this->user->experience = $newExp;

        return $this->startWatching($levelUp);
    }

    /**
     * @param null $levelUp set by updateExperience()
     * @return array
     */
    public function startWatching($levelUp = null)
    {
        $token = str_random(40);
        $level = $this->user->level;
        $lastSeenWatching = Carbon::now();

        $expForLevel = ExpLevel::where('level', $level)->first()->experience;
        $experience = $this->user->experience;

        $progression = round($experience * 100 / $expForLevel, 1);

        $this->user->last_seen_watching = $lastSeenWatching->toDateTimeString();
        $this->user->experience_token = $token;

        $this->user->save();

        return [
            'token'         => $token,
            'nextXpRequest' => $this->mnBetweenReq,
            'level'         => $level,
            'exp'           => $experience,
            'progression'   => $progression,
            'levelUp'       => ($levelUp ? true : false)
        ];
    }

    public static function getExpInfo($user)
    {
        $expForLevel = ExpLevel::where('level', $user->level)->first()->experience;
        $experience = $user->experience;

        $progression = round($experience * 100 / $expForLevel, 1);

        return [
            'level'       => $user->level,
            'progression' => $progression,
        ];
    }

    /**
     * @return array ready to insert data
     */
    public function generateExperienceSystem()
    {
        $xpFirstLevel = 100;
        $xpLastLevel = $xpFirstLevel * $this->maxLevel * 1000;

        $B = log((double)$xpLastLevel / (double)$xpFirstLevel) / ($this->maxLevel - 1);
        $A = (double)$xpFirstLevel / (exp($B) - 1.0);

        $data = [];
        for ($level = 1; $level <= $this->maxLevel; $level++) {
            $oldXp = round($A * exp($B * ($level - 1)));
            $newXp = round($A * exp($B * $level));
            $data[] = [
                'level'      => $level,
                'experience' => ($newXp - $oldXp)
            ];
        }

        return $data;
    }
}