@extends('default')
@section('title', 'Création d\'un PP')

@section('header')
	@include('components.advisor-tabs')
@endsection

@section('main-content')


	<div id="vue-register-form" class="section">
		<h1 class="title is-2 has-text-link">Création d'un nouveau compte porteur de projet</h1>
		<user-form id="register-form"
				   inline-template
				   :old-values="{{json_encode(count(old()) ? old() : new stdClass)}}">
			<div class=" ">
				<div class="columns is-mobile is-centered">
					<div class="column is-two-thirds">
						<p class="is-size-4">Remplissez les différents champs afin de créer un nouveau compte pour un
							porteur de projet. </p>
						<p class="is-size-7">Les champs marqués d'un astérisque <strong>(*)</strong> sont obligatoires.
						</p>
						<br>
						{!! Form::open(['route'=>'advisor.registerNewPp']) !!}
						@csrf

						<div class="columns">
							<div class="column is-one-fifths">
								@include('auth.partials.inputs.civility')
							</div>
							<div class="column is-two-fifths">
								@include('auth.partials.inputs.lastname')

							</div>
							<div class="column is-two-fifths">
								@include('auth.partials.inputs.firstname')
							</div>
						</div>

						<div class="columns">
							<div class="column is-half">
								@include('auth.partials.inputs.phone')
							</div>
							<div class="column ">
								@include('auth.partials.inputs.email')
							</div>
						</div>
						<div class="columns">
							@include('auth.partials.inputs.profile')
						</div>
						<div class="columns">
							<div class="column is-7">
								@include('auth.partials.inputs.address')
							</div>
							<div class="column is-5">
								@include('auth.partials.inputs.zipcode')
							</div>
						</div>
						{{--						<div class="field">--}}
						{{--							<label class="checkbox">--}}
						{{--								<input type="checkbox" required>--}}
						{{--								J'ai pris connaissance de <a>la charte d'utilisation de la plateforme d'annonces du--}}
						{{--									site--}}
						{{--									web de--}}
						{{--									Terre de Liens</a> .*--}}
						{{--							</label>--}}
						{{--						</div>--}}
						{{--						<div class="field">--}}
						{{--							<label class="checkbox">--}}
						{{--								<input type="checkbox" name="accept_communication" id="accept_communication"--}}
						{{--									   value="1">--}}
						{{--								J'accepte de recevoir les communications de Terre de Liens--}}
						{{--							</label>--}}
						{{--						</div>--}}

						<p>En appuyant sur valider, le porteur de projet va recevoir un email pour confirmer la création
							de ce compte. Un mot de passe aléatoire lui sera attribué et communiqué. </p>
						<br>
						<div class="field is-grouped is-grouped-centered">
							<div class="control ">
								<button type="submit" class="form-button button basic primary is-size-3">Valider</button>
							</div>
							<div class="control ">
								<a href="{{url()->previous()}}" class="button basic secondary is-size-3">Retour</a>
							</div>
						</div>
						{!! Form::close() !!}
					</div>
				</div>
				<div class="column"></div>
			</div>
		</user-form>
	</div>
@endsection
@section('script')
	<script>
        const vueRegisterForm = new Vue({
            el: '#vue-register-form',
            name: 'content'
        });
	</script>
@endsection
