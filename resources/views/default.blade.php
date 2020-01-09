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

@foreach($errors->all() as $message)
    <article class="message is-danger">
        <div class="message-header">
            <p>Erreur !</p>
            <button class="delete" aria-label="delete"></button>
        </div>
        <div class="message-body">
            {{ $message }}
        </div>
    </article>
@endforeach

<div id="app">
    @yield('main-content')
</div>

@include('layouts.footer')
    <script src="{{ asset('js/app.js') }}"></script>
@yield('script')

</body>
</html>
