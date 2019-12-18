<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    @yield('head-script')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
@include('layouts.header')

@yield('main-content')


@include('layouts.footer')

@yield('script')
</body>
</html>
