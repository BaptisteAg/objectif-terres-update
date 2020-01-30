<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @yield('head-script')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link ref="stylesheet" src="./node_modules/vue-slider-component/theme/default.css">
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
<script>
    window.csrf_token = "{{ csrf_token() }}"
</script>

@yield('script')

</body>
</html>
