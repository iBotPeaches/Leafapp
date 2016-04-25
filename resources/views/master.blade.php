<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    @if (isset($description))
        <meta name="description" content="{{ $description }}">
    @endif
    <title>{{ $title or 'Leaf - Halo 5 Leaderboards' }}</title>
    <!--[if lte IE 8]><script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ elixir("js/app.js") }}"></script>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />
    @yield('inline-css')
</head>
<body>
    @include('includes.navigation')
    @yield('content')
    @yield('inline-js')
    @include('includes.analytics')
</body>
</html>