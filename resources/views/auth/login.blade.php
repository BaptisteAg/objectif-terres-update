@extends('default')
@section('title', 'Connexion')

@section('main-content')

	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<h1 class="title is-2 has-text-centered has-text-link">Connexion </h1>
					<h2 class="subtitle has-text-centered">Identifiez-vous pour accéder à votre compte Objectif
						Terres </h2>

					{!! Form::open(['route'=>'login']) !!}
					@csrf
					<div class="field">
						<label class="label">Adresse email</label>
						<p class="control has-icons-left has-icons-right">
							<input id="email" class="input @error('email') is-danger @enderror" type="email"
								   name="email" value="{{ old('email') }}" required autocomplete="email" autofocus
								   placeholder="Votre adresse email...">
							<span class="icon is-small is-left">
                              <i class="fas fa-envelope"></i>
                            </span>
						</p>
						@error('email')
						<article class="message is-danger" role="alert">
							<div class="message-body">
								{{ $message }}
							</div>
						</article>
						@enderror
					</div>
					<div class="field">
						<label class="label">Mot de passe</label>
						<p class="control has-icons-left">
							<input name="password" class="input @error('password') is-danger @enderror " type="password" required
								   autocomplete="current-password" placeholder="Votre mot de passe...">
							<span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
						</p>
						@error('password')
						<article class="message is-danger" role="alert">
							<div class="message-body">
								{{ $message }}
							</div>
						</article>
						@enderror
					</div>

					<div class="field">
						<div class="control">
							<label class="checkbox">
								<input type="checkbox" name="remember"
									   id="remember" {{ old('remember') ? 'checked' : '' }}>
								Se souvenir des mes identifiants
							</label>
						</div>
					</div>

					<div class="field is-grouped">
						<div class="control">
							<button type="submit" class="button is-link">Valider</button>
						</div>
						@if (Route::has('password.request'))
							<div class="control">
								<a href="{{ route('password.request') }}" class="button is-link is-light">Mon de passe oublié ?</a>
							</div>
						@endif
					</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="column"></div>
		</div>
	</div>
	@include('components.supportTerreLiens')
@endsection


