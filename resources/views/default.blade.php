<!DOCTYPE html>
<html lang="fr">
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
	<script src="https://kit.fontawesome.com/c97506cdaa.js" crossorigin="anonymous"></script>
</head>
<body lang="fr-FR">

<header>
	<div>
		@include('layouts.header.top-bar')

		<a href="{{route('home')}}" class="main-nav__logo logo">
			<img src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png" alt="logo-terre-de-liens"/>
		</a>
		<input type="checkbox" id="main-nav__toggler"/>
		<div id="main-nav__hamburger">
			<div id="main-nav__hamburger__line" class="button__icon"></div>
		</div>
		<div id="main-nav__splash__wrap">
			<div id="main-nav__splash__transform-container" class="bg-trame_champs_dark">
				<div id="main-nav__splash__container">
					<div class="main-nav__content">
						<div id="vue-header">

							@include('layouts.header.search-mobile')

							<div class="top-bar">
								<section class="fw-section top-bar__1">

									@include('layouts.header.banner-desktop')

									@include('layouts.header.banner-mobile')

								</section>

								@include("layouts.header.main-menu")

							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@yield('header')
	</div>
</header>

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
