@extends('default')
@section('title', 'Mot de passe oublié')

@section('main-content')
	<div class="section">
		<div class="container">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<h1 class="title is-2 has-text-centered has-text-link">Mot de passe oublié ? </h1>
					<h2 class="subtitle has-text-centered text_charcoal">Renseignez votre adresse email pour générer un nouveau mot de passe </h2>
					@if(session('status'))
					<article class="message is-succes" role="alert">
						<div class="message-body">
							{{ session('status') }}
						</div>
					</article>
					@endif
					{!! Form::open(['route'=>'password.email']) !!}
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

					<div class="field is-grouped is-pulled-right">
						<div class="control">
							<button type="submit" class="button is-link">Réinitialiser mon mot de passe</button>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
			</div>
			<div class="column"></div>
		</div>
	</div>

	@include('components.support-terre-liens')
@endsection
