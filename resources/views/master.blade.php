<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if (isset($description))
        <meta name="description" content="{{ $description }}">
    @endif
    <title>{{ $title or 'LeafApp' }}</title>
    <!--[if lte IE 8]><script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script><![endif]-->
    <script src="{{ asset("js/jquery.min.js") }}"></script>
    <script src="{{ elixir("js/app.js") }}"></script>
    <link rel="stylesheet" href="{{ elixir('css/app.css') }}" />
    @yield('inline-css')
</head>
<body>
    <div class="ui container">
        @yield('content')
    </div>
    @yield('inline-js')
    @include('includes.analytics')
</body>
</html>