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
					<div class="column is-four-fifths">
						<p class="is-size-4">Remplissez les différents champs afin de créer un nouveau compte pour un
							porteur de projet. </p>
						<p class="is-size-7">Les champs marqués d'un astérisque <strong>(*)</strong> sont obligatoires.
						</p>
						<br>
						{!! Form::open(['route'=>'register']) !!}
						@csrf
						<div class="columns">
							<div class="column is-two-fifths">
								<div class="field">
									<label class="label">Nom du PP*</label>
									<div class="control has-icons-left">
										<input id="name" name="name" class="input @error('name')is-danger @enderror"
											   type="text"
											   value="{{ old('name') }}" required autocomplete="name" autofocus
											   placeholder="Nom...">
										<span class="icon is-small is-left">
                                     <i class="fas fa-user"></i>
                                    </span>
									</div>
									@error('name')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
							<div class="column is-two-fifths">
								<div class="field">
									<label class="label">Prénom du PP*</label>
									<div class="control has-icons-left">
										<input id="first_name" name="first_name"
											   class="input @error('first_name')is-danger @enderror" type="text"
											   value="{{ old('first_name') }}" required autocomplete="first_name"
											   autofocus
											   placeholder="Prénom...">
										<span class="icon is-small is-left">
                                     <i class="fas fa-user"></i>
                                    </span>
									</div>
									@error('first_name')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
							<div class="column is-one-fifths">
								<div class="field">
									<label class="label">Civilité du PP*</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="civility" name="civility"
													class="input @error('civility') is-danger @enderror "
													required>
												<option value="" disabled="disabled" selected></option>
												<option value="1" {{old('civility') == 1 ? 'selected' : ''}}>Madame
												</option>
												<option value="2" {{old('civility') == 2 ? 'selected' : ''}}>Monsieur
												</option>
												<option value="3" {{old('civility') == 3 ?'selected' : ''}}>Autre
												</option>
											</select>
										</div>
										<div class="icon is-small is-left">
											<i class="fas fa-user"></i>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="columns">
							<div class="column is-half">
								<div class="field">
									<label class="label">Numéro de téléphone </label>
									<p class="control has-icons-left has-icons-right">
										<input id="phone" class="input @error('phone') is-danger @enderror" type="text"
											   name="phone" value="{{ old('phone') }}" autocomplete="phone" autofocus
											   placeholder="Numéro de téléphone ...">
										<span class="icon is-small is-left">
                           <i class="fas fa-phone"></i>
                            </span>
									</p>
									@error('phone')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
							<div class="column ">
								<div class="field">
									<label class="label">Adresse email du PP*</label>
									<p class="control has-icons-left has-icons-right">
										<input id="email"
											   class="input @error('email') is-danger @enderror"
											   type="email"
											   name="email"
											   value="{{ old('email') }}"
											   required
											   autocomplete="email"
											   autofocus
											   placeholder="Adresse email...">
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
							</div>
						</div>
						<div class="columns">
							<div class="column ">
								<div class="field">
									<label for="profile" class="label">Situation du PP*</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="profile"
													name="profile"
													v-model="optionProfileSelected"
													class="input @error('profile') is-danger @enderror ">
												<option disabled="disabled" selected>Le PP est...</option>
												@foreach(\App\Models\User::$profiles as $id => $prof)
													<option
															value="{{$id}}"
															{{old('profile') == $id ? 'selected' : ''}} >
														{{$prof}}
													</option>
												@endforeach
											</select>
										</div>
										<div class="icon is-small is-left">
											<i class="fas fa-user"></i>
										</div>
									</div>
									@error('profile')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
							<div v-if="optionProfileSelected === '8'" class="column is-half">
								<div class="field">
									<label class="label">Situation autre </label>
									<p class="control has-icons-left has-icons-right">
										<input id="other_profile"
											   class="input @error('other_profile') is-danger @enderror"
											   type="text"
											   name="other_profile" value="{{ old('other_profile') }}" required
											   autocomplete="other_profile"
											   placeholder="Veuillez préciser ...">
										<span class="icon is-small is-left">
                                       <i class="fas fa-pen"></i>
                                    </span>
									</p>
									@error('other_profile')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
						</div>
						<div class="columns">
							<div class="column is-7">
								<div class="field">
									<label class="label">Adresse du PP* </label>
									<p class="control has-icons-left">
										<input id="street" class="input @error('street') is-danger @enderror"
											   type="text"
											   name="street" value="{{ old('street') }}" required
											   autocomplete="street"
											   autofocus
											   placeholder="Adresse ...">
										<span class="icon is-small is-left">
									<i class="fas fa-map-marker-alt"></i>
								</span>
									</p>
									@error('street')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
							<div class="column is-5">
								<div class="field">
									<label class="label">Commune et Code postal*</label>
									<autocomplete
											name="citySelect"
											id="citySelect"
											class="@error('city_id') is-danger @enderror"
											placeholder="Saisissez les premiers caractères"
											ref='citySelect'
											src="/locations/cities"
											v-model="citySelect">

										<input type="hidden" name="city_id" :value="zone.value.id"
											   v-for="(zone,i) in citySelect">

										<div class="tag autocomplete-input-tag is-info"
											 v-for="(zone,i) in citySelect"
											 @click="_ => citySelect.splice(i,1)">
											@{{ zone.label }}
											&nbsp;&nbsp
											<i class="fa fa-trash" style="cursor:pointer"></i>
										</div>
										<input type="hidden" name="country_id" value="75">
									</autocomplete>
									@error('city_id')
									<article class="message is-danger" role="alert">
										<div class="message-body">
											{{ $message }}
										</div>
									</article>
									@enderror
								</div>
							</div>
						</div>
						<div class="field">
							<label class="label">Mot de passe*</label>
							<p class="control has-icons-left">
								<input id="password"
									   name="password"
									   class="input @error('password') is-danger @enderror "
									   type="password"
									   required
									   autocomplete="new-password"
									   placeholder="Mot de passe..."
									   value="{{ old('password') }}"
									   minlength="5">
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
							<label class="label">Confirmation mot de passe*</label>
							<p class="control has-icons-left">
								<input id="password-confirm"
									   name="password_confirmation"
									   class="input"
									   type="password"
									   value="{{ old('password_confirmation') }}"
									   autocomplete="new-password"
									   required
									   placeholder="Ressaisissez mot de passe...">
								<span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
							</p>
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
							de ce compte. </p>
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
