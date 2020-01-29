@extends('default')

@section('main-content')
	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<h1 class="title is-2 has-text-centered has-text-link">Inscription </h1>
					<h2 class="subtitle has-text-centered">Créez votre compte pour profiter des services d'Objectif
						Terres </h2>

					{!! Form::open(['route'=>'register']) !!}
					@csrf

					<div class="field">
						<label class="label">Votre nom</label>
						<div class="control">
							<input id="name" name="name" class="input @error('name')is-danger @enderror" type="text"
								   value="{{ old('name') }}" required autocomplete="name" autofocus
								   placeholder="Votre nom...">
						</div>
						@error('name')
						<article class="message is-danger" role="alert">
							<div class="message-body">
								{{ $message }}
							</div>
						</article>
						@enderror
					</div>

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
							<input name="password" class="input @error('password') is-danger @enderror " type="password"
								   required
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
						<label class="label">Confirmation mot de passe</label>
						<p class="control has-icons-left">
							<input name="password_confirm" name="password_confirmation"
								   class="input" type="password"
								   autocomplete="new-password"
								   required
								   placeholder="Ressaisissez mot de passe...">
							<span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
						</p>
					</div>

					<div class="field is-grouped">
						<div class="control">
							<button type="submit" class="button is-link">Valider</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="column"></div>
		</div>
	</div>
	@include('components.support_terre_liens')

@endsection
