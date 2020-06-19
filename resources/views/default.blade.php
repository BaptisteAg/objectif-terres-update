<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		@yield('title')
		| Objectif Terres
	</title>
	@yield('head-script')
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
	<link href="https://fonts.googleapis.com/css?family=Bebas+Neue|Kalam:700|Source+Sans+Pro&display=swap"
		  rel="stylesheet">
	<link rel="icon" type="image/png" href="/images/favicon/favicon-32x32.png"/>
	<link rel="icon" href="/images/favicon/favicon.ico"/>
	<script src="https://kit.fontawesome.com/c97506cdaa.js" crossorigin="anonymous"></script>
</head>
<body lang="fr-FR">

@include('layouts.header')

@if(!$errors->isEmpty() or Session::has('success') or Session::has('warning') or Session::has('info') )
	<div class="columns" style="margin:5px">
		<div class="column is-one-fifth"></div>
		<div class="column is-three-fifths">
			@foreach($errors->all() as $message)
				<article class="message is-danger" data-type="main-message">
					<div class="message-header">
						<p>Erreur !</p>
						<button class=" delete close-notification" aria-label="delete"
								data-type="close-main-message"></button>
					</div>
					<div class="message-body">
						{{ $message }}
					</div>
				</article>
			@endforeach
			@if ($message = Session::get('success'))
				<article class="message is-success main-message" data-type="main-message">
					<div class="message-header">
						<p>Succès !</p>
						<button class="delete close-notification" aria-label="delete"
								data-type="close-main-message"></button>
					</div>
					<div class="message-body">
						{!! $message !!}
					</div>
				</article>
				<?php session()->forget('success') ?>
			@endif

			@if($message = Session::get('warning'))
				<article class="message is-warning main-message" data-type="main-message">
					<div class="message-header">
						<p>Attention ! </p>
						<button class="delete close-notification" aria-label="delete"
								data-type="close-main-message"></button>
					</div>
					<div class="message-body">
						{{ $message }}
					</div>
				</article>
				<?php session()->forget('warning') ?>
			@endif

			@if($message = Session::get('info'))
				<article class="message is-info main-message" data-type="main-message">
					<div class="message-header">
						<p>Information</p>
						<button class="delete close-notification" aria-label="delete"
								data-type="close-main-message"></button>
					</div>
					<div class="message-body">
						{{ $message }}
					</div>
				</article>
				<?php session()->forget('info') ?>
			@endif
		</div>
	</div>
@endif

<div id="app">
	@yield('main-content')
</div>

@include('layouts.footer')
<script>
    window.csrf_token = "{{ csrf_token() }}"
</script>
<script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    const vueHeader = new Vue({
        el: '#vue-header',
        name: 'header-search',
		mounted() {
			initDropdowns()
		}
    });
</script>
<script>
    let closeNotification = document.querySelector('button[data-type=close-main-message]');
    closeNotification && closeNotification.addEventListener('click', function (e) {
        let message = document.querySelector('article[data-type=main-message ]');
        message.style.display = 'none';
    })

    let div = document.getElementById('main-nav__splash__transform-container');
    function extendHeaderMobileContainer() {
        if(div.style.height.length === 0) {
            div.style.height = '400vh';
            div.style.width = '320vh';
            div.style.marginTop = "60px";
        } else {
            div.style.height = '';
            div.style.width = '';
            div.style.marginTop = '';
        }
    }
</script>

<script data-jsd-embedded data-key="6cc7e1b1-ff31-49eb-93bf-0016d2cab165" data-base-url="https://jsd-widget.atlassian.com" src="https://jsd-widget.atlassian.com/assets/embed.js"></script>

@yield('script')

</body>
</html>
