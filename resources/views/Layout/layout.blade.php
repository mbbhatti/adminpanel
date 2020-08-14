<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="none" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="admin login">
        <title>Hungry - @yield('title')</title>

        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

        <!-- Favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/logo-icon.png') }}" type="image/png">

        <!-- Styles -->
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css">
        <style type="text/css">
            .voyager .side-menu .navbar-header {
                background: #22A7F0;
                border-color: #22A7F0;
            }
            .widget .btn-primary{
                border-color: #22A7F0;
            }
            .widget .btn-primary:focus, .widget .btn-primary:hover, .widget .btn-primary:active, .widget .btn-primary.active, .widget .btn-primary:active:focus{
                background: #22A7F0;
            }
            .voyager .breadcrumb a{
                color:#22A7F0;
            }
        </style>
        @yield('css')
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
        @yield('head')
    </head>
    <body class="voyager @if(isset($dataType) && isset($dataType->slug)){{ $dataType->slug }}@endif">
        {{--<div id="voyager-loader">
            <img src="{{ asset('assets/images/logo-icon.png') }}" alt="Voyager Loader">
        </div>--}}
        <div class="app-container">
            <div class="fadetoblack visible-xs"></div>
            <div class="row content-container">
                @include('Admin.Partial.navbar')
                @include('Admin.Partial.sidebar')
                <script>
                    (function(){
                        var appContainer = document.querySelector('.app-container'),
                            sidebar = appContainer.querySelector('.side-menu'),
                            navbar = appContainer.querySelector('nav.navbar.navbar-top'),
                            loader = document.getElementById('voyager-loader'),
                            hamburgerMenu = document.querySelector('.hamburger'),
                            sidebarTransition = sidebar.style.transition,
                            navbarTransition = navbar.style.transition,
                            containerTransition = appContainer.style.transition;

                        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition =
                            appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition =
                                navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = 'none';

                        if (window.innerWidth > 768 && window.localStorage && window.localStorage['voyager.stickySidebar'] == 'true') {
                            appContainer.className += ' expanded no-animation';
                            loader.style.left = (sidebar.clientWidth/2)+'px';
                            hamburgerMenu.className += ' is-active no-animation';
                        }

                        navbar.style.WebkitTransition = navbar.style.MozTransition = navbar.style.transition = navbarTransition;
                        sidebar.style.WebkitTransition = sidebar.style.MozTransition = sidebar.style.transition = sidebarTransition;
                        appContainer.style.WebkitTransition = appContainer.style.MozTransition = appContainer.style.transition = containerTransition;
                    })();
                </script>
                <!-- Main Content -->
                <div class="container-fluid">
                    <div class="side-body padding-top">
                        @yield('page_header')
                        <div id="voyager-notifications"></div>
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
        @yield('javascript')
     </body>
</html>
