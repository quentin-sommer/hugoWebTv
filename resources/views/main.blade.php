@extends('single')
@section('title','Accueil')
@section('head')
    @parent
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css')}}"/>
    <link rel="stylesheet" href="{{ url('assets/css/reset.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/css/plugins.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}"/>
@stop
@section('content')
    <!--Loader-->
    <div class="loader-holder">
        <div class="loader">
            <div id="movingBallG">
                <div class="movingBallLineG"></div>
                <div id="movingBallG_1" class="movingBallG"></div>
            </div>
        </div>
    </div>
    <!--Loader end -->
    <!--================= main start ================-->
    <div id="main">
        <div id="fall-holder"></div>
        <!--================= menu ================-->
        <div class="nav-button">
            <span class="nos"></span>
            <span class="ncs"></span>
            <span class="nbs"></span>
        </div>
        <div id="nav" class="vis elem">
            <div id="menu" class="elem-anim">
                @if(Auth::check())
                    <a href="{{ route('logout') }}">Se déconnecter</a>
                @else
                    <a href="{{ route('getLogin') }}">Se connecter</a>
                @endif
                <a>À propos<span class="transition"></span></a>
                <a data-page="0" class="active">Accueil<span class="transition"></span></a>
                @foreach($streamingUsers as $streamingUser)
                    <a data-page="1">
                        {{$streamingUser->login}}
                        <span class="transition"></span>
                    </a>
                @endforeach
                <a data-page="3">Contact<span class="transition"></span></a>
            </div>
        </div>
        <!--Navigation end-->
        <!--================= Subscribe  ================-->
        <div class="subcribe-form-holder elem">
            <div class="subcribe-form elem-anim">
                <form id="subscribe">
                    <input class="enteremail" name="email" id="subscribe-email" placeholder="Email" spellcheck="false"
                           type="text">
                    <button type="submit" id="subscribe-button" class="subscribe-button">Subscribe</button>
                    <label for="subscribe-email" class="subscribe-message"></label>
                </form>
            </div>
        </div>
        <!--Subscribe end-->
        <!--================= Social links  ================-->
        <div class="social-links elem">
            <ul class="elem-anim">
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-facebook"></i>
                        <span class="tooltip">Facebook</span>
                    </a>
                </li>
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-dribbble"></i>
                        <span class="tooltip">Dribbble</span>
                    </a>
                </li>
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-twitter"></i>
                        <span class="tooltip">Twitter</span>
                    </a>
                </li>
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-tumblr"></i>
                        <span class="tooltip">Tumblr</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--Social links  end-->
        <!--================= Wrapper start  ================-->
        <div class="wrapper transition">
            <!--================= arrow  navigation ================-->
            <a href="#" class="arrow-right transition2"><i class="fa fa-angle-right"></i></a>
            <a href="#" class="arrow-left transition2"><i class="fa fa-angle-left"></i></a>
            <!--start content-->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!--============= about section =============-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <section>
                                <div class="content-inner">
                                    <div class="section-decor"></div>
                                    <div class="content-holder">
                                        <div class="about">
                                            <h3>A Propos</h3>
                                            <h4> Ut enim ad minim veniam, quis nostrud exercitation ullamco sit
                                                voluptatem.</h4>

                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                                                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim
                                                veniam,
                                                quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                                consequat. Duis aute irure dolor in reprehenderit in voluptate velit
                                                esse
                                                cillum dolore eu fugiat. Ultricies nisi voluptatem, illo inventore
                                                veritatis
                                                et quasi architecto beatae vitae dicta sunt explicabo nemo enim ipsam
                                                voluptatem. Sed ut perspiciatis unde omnis iste natus error sit
                                                voluptatem
                                                accusantium doloremque laudantium, totam rem aperiam.</p>

                                            <div class="btn go-contact">Our contacts</div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!--about end-->
                    <!--================= Home section ================-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="media-container">
                            <!-- Youtube  bg-->
                            <div class="video-holder">
                                <div id="player"></div>
                            </div>
                        </div>
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <div id="canvas-holder">
                                <canvas id="demo-canvas"></canvas>
                            </div>
                            <div class="logo">
                                <img src="{{url('assets/images/logo2.png')}}" alt="">
                            </div>
                            <div class="counter-content">
                                <ul class="countdown">
                                    <li>
                                        <span class="days rot">00</span>

                                        <p>days</p>
                                    </li>
                                    <li>
                                        <span class="hours rot">00</span>

                                        <p>hours </p>
                                    </li>
                                    <li>
                                        <span class="minutes rot2">00</span>

                                        <p>minutes </p>
                                    </li>
                                    <li>
                                        <span class="seconds rot2">00</span>

                                        <p>seconds</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="hero-text">
                                <h2>Our website is coming soon </h2>
                            </div>
                        </div>
                    </div>
                    <!--home end-->
                    <!-- Stream Section -->
                    <div class="swiper-slide slide-bg">
                        <div class="container">
                            <section>
                                <div class="content-inner">

                                    <div style="background-color: red">
                                        <iframe frameborder="0"
                                                scrolling="no"
                                                src="http://www.twitch.tv/imaqtpie/embed"
                                                height="380px"
                                                width="620px">
                                        </iframe>
                                    </div>
                                    <!--<div style="z-index: 20;">
                                    <object bgcolor="#000000"
                                            data="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"
                                            height="378"
                                            type="application/x-shockwave-flash"
                                            width="615">
                                        <param name="allowFullScreen" value="true" />
                                        <param name="allowScriptAccess" value="always" />
                                        <param name="allowNetworking" value="all" />
                                        <param name="movie" value="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf" />
                                        <param name="flashvars" value="hostname=www.twitch.tv&channel=fureurwebtv&auto_play=false&start_volume=25" />
                                    </object>
                                    </div>
                                    <div style="height: 800px; width: 800px">
                                        <object bgcolor="#000000"
                                                data="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"
                                                height="100%"
                                                type="application/x-shockwave-flash"
                                                width="100%"
                                                >
                                            <param name="allowFullScreen"
                                                   value="true"/>
                                            <param name="allowNetworking"
                                                   value="all"/>
                                            <param name="allowScriptAccess"
                                                   value="always"/>
                                            <param name="movie"
                                                   value="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"/>
                                            <param name="flashvars"
                                                   value="channel=riotgames&auto_play=false&start_volume=25"/>
                                        </object>
                                    </div>-->
                                </div>
                            </section>

                        </div>
                    </div>
                    <!-- Stream end -->
                    <!--============= Contact section =============-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <section>
                                <div class="content-inner">
                                    <div class="section-decor"></div>
                                    <div class="content-holder">
                                        <div class="contact">
                                            <div class="hide-con-info transition">
                                                <h3>Contacts</h3>

                                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
                                                    eiusmod
                                                    tempor incididunt ut labore et dolore magna aliqua.</p>

                                                <div class="contact-info-holder">
                                                    <ul class="contact-info">
                                                        <li>
                                                            <a href="#" target="_blank"><i class="fa fa-phone"></i> +1
                                                                (000)
                                                                123456</a>
                                                        </li>
                                                        <li>
                                                            <a href="#" target="_blank"><i class="fa fa-envelope-o"></i>
                                                                yourmail@yuormail.com </a>
                                                        </li>
                                                        <li>
                                                            <a href="#" target="_blank"><i class="fa fa-globe"></i>
                                                                Heritage
                                                                Park Minneapolis </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="btn show-form">Write us</div>
                                            </div>
                                            <div class="contact-form-holder transition">
                                                <h3>Get in Touch</h3>

                                                <div class="close-form"><span class="rcd"></span><span
                                                            class="lcd"></span>
                                                </div>
                                                <div id="contact-form">
                                                    <div id="message"></div>
                                                    <form method="post" action="php/contact.php" name="contactform"
                                                          id="contactform">
                                                        <input name="name" type="text" id="name" onClick="this.select()"
                                                               value="Name">
                                                        <input name="email" type="text" id="email"
                                                               onClick="this.select()"
                                                               value="E-mail">
                                                        <textarea name="comments" id="comments" onClick="this.select()">Message</textarea>
                                                        <button type="submit" id="submit"><i
                                                                    class="fa fa-envelope-o   button__icon"></i><span>Send Message</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!--Contact  end-->
                </div>
            </div>
        </div>
        <!--Wrapper  end -->
    </div>
    <!--Main  end -->
@stop
@section('footer')
@stop
@section('endBody')
    <script type="text/javascript" src="{{url('assets/js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/scripts.js')}}"></script>
    <script type="text/javascript">
        var tag = document.createElement('script');
        tag.src = "//www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        // var vstring = '5qbNOkXIioM'; // YouTube Video ID here
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
                playerVars: {'autoplay': 1, 'loop': 1, 'playlist': vstring, 'controls': 0, 'showinfo': 0},

                videoId: vstring,
                events: {
                    'onReady': onPlayerReady
                }
            });
        }
        function onPlayerReady(event) {
            event.target.setVolume(0);
            event.target.mute();
            event.target.playVideo();
            event.target.setPlaybackQuality('hd720');
        }
    </script>
@stop