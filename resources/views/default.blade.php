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
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Get all "navbar-burger" elements
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            // Check if there are any navbar burgers
            if ($navbarBurgers.length > 0) {

                // Add a click event on each of them
                $navbarBurgers.forEach( el => {
                    el.addEventListener('click', () => {

                        // Get the target from the "data-target" attribute
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);

                        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');

                    });
                });
            }
        });
    </script>


@yield('script')

</body>
</html>
