<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="robots" content="none" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="admin login">
        <title>Hungry - @yield('title')</title>

        <!-- Styles -->
        <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/login.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">

        <!-- Scripts -->
        <script src="{{ asset('assets/js/app.js') }}"></script>
    </head>
    <body class="login">
        @yield('content')
    </body>
</html>
