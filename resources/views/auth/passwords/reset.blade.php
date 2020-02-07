@extends('default')
@section ('title', 'Réinitialisation mot de passe')

@section('main-content')

	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="is-half">
					<h1 class="title is-2 has-text-centered has-text-link">Réinitialisation de votre mot de passe </h1>
					<h2 class="subtitle has-text-centered">Renseignez votre adresse email et votre nouveau mot de
						passe </h2>

					{!! Form::open(['route'=> 'password.update']) !!}
					@csrf
					<input type="hidden" name="token" value="{{ $token }}">
					<div class="field">
						<label class="label">Adresse email</label>
						<p class="control has-icons-left has-icons-right">
							<input id="email" class="input @error('email') is-danger @enderror" type="email"
								   name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"
								   autofocus
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
						<label class="label">Votre mot de passe</label>
						<p class="control has-icons-left has-icons-right">
							<input id="password" class="input @error('password') is-danger @enderror" type="password"
								   name="password" required autocomplete="new-password" autofocus
								   placeholder="Votre nouveau mot de passe...">
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
						<p class="control has-icons-left has-icons-right">
							<input id="password-confirm" class="input"
								   type="password"
								   name="password_confirmation" required autocomplete="new-password" autofocus
								   placeholder="Saississez à nouveau votre mot de passe...">
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
		</div>
	</div>
@endsection
