@extends('default')
@section('title', 'Inscription')

@section('main-content')
	<div id="vue-register-form" class="section">
		<register-form id="register-form" inline-template>
			<div class="container">
				<div class="columns is-mobile is-centered">
					<div class="column is-two-thirds">
						<h1 class="title is-2 has-text-centered has-text-link">Inscription </h1>
						<h2 class="subtitle has-text-centered">Créez votre compte pour profiter des services d'Objectif
							Terres </h2>
						{!! Form::open(['route'=>'register']) !!}
						@csrf
						<div class="columns">
							<div class="column is-one-third">
								<div class="field">
									<label class="label">Votre nom</label>
									<div class="control has-icons-left">
										<input id="name" name="name" class="input @error('name')is-danger @enderror"
											   type="text"
											   value="{{ old('name') }}" required autocomplete="name" autofocus
											   placeholder="Votre nom...">
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
							<div class="column">
								<div class="field">
									<label class="label">Votre prénom</label>
									<div class="control has-icons-left">
										<input id="first_name" name="first_name"
											   class="input @error('first_name')is-danger @enderror" type="text"
											   value="{{ old('first_name') }}" required autocomplete="first_name"
											   autofocus
											   placeholder="Votre prénom...">
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
							<div class="column ">
								<div class="field">
									<label class="label">Civilité</label>
									<div class="control has-icons-left">
										<div class="select">

											<select id="civility" name="civility"
													class="input @error('civility') is-danger @enderror "
													required>
												<option disabled="disabled" selected >Veuillez préciser...</option>
												<option value="1" {{old('civility') == 1 ? 'selected' : ''}}>Madame</option>
												<option value="2" {{old('civility') == 2 ? 'selected' : ''}}>Monsieur</option>
												<option value="3" {{old('civility') == 3 ?'selected' : ''}}>Autre</option>
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
											   placeholder="Votre numéro de téléphone ...">
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
									<label class="label">Adresse email</label>
									<p class="control has-icons-left has-icons-right">
										<input id="email" class="input @error('email') is-danger @enderror" type="email"
											   name="email" value="{{ old('email') }}" required autocomplete="email"
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
							</div>
						</div>
						<div class="field">
							<label class="checkbox">
								<input value="1" {{old('accept_share_contact_infos') == 1 ? 'checked' : ''}} name="accept_share_contact_infos" type="checkbox">
								J'accepte de faire apparaître publiquement mes informations de contact
							</label>
						</div>

						<div class="columns">
							<div class="column is-two-thirds">
								<div class="field">
									<label class="label">Votre situation</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="profile" name="profile"
													class="input @error('profile') is-danger @enderror "
													required
													@on-change="optionProfileSelected"
													placeholder="Veuillez choisir">
												<option disabled="disabled" selected>Vous êtes...</option>
												<option value="1" {{old('profile') == 1 ? 'selected' : ''}} >un candidat à l’installation agricole</option>
												<option value="2" {{old('profile') == 2 ? 'selected' : ''}}>une personne en recherche de travail ou d’expérience
													professionnelle dans le
													domaine agricole
												</option>
												<option value="3" {{old('profile') == 3 ? 'selected' : ''}}>un agriculteur qui souhaite consolider sa ferme
												</option>
												<option value="4" {{old('profile') == 4 ? 'selected' : ''}}>un agriculteur qui souhaite transmettre sa ferme
												</option>
												<option value="5" {{old('profile') == 5 ? 'selected' : ''}}>un propriétaire foncier qui souhaite vendre ou louer
													sa
													terre
												</option>
												<option value="6" {{old('profile') == 6 ? 'selected' : ''}}>Autre</option>
											</select>
										</div>
										<div class="icon is-small is-left">
											<i class="fas fa-user"></i>
										</div>
									</div>
								</div>
							</div>
							<div v-if="optionProfileSelected === '6'" class="column">
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

						<div class="field">
							<label class="label">Adresse </label>
							<p class="control has-icons-left has-icons-right">
								<input id="address" class="input @error('address') is-danger @enderror" type="text"
									   name="address" value="{{ old('address') }}" required autocomplete="address"
									   autofocus
									   placeholder="Votre adresse ...">
								<span class="icon is-small is-left">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
							</p>
							@error('address')
							<article class="message is-danger" role="alert">
								<div class="message-body">
									{{ $message }}
								</div>
							</article>
							@enderror
						</div>
						<div class="columns">
							<div class="column is-one-third">
								<div class="field">
									<label class="label">Code postal</label>
									<div>
										<div class="control">
											<autocomplete
													name="citySelect"
													id="citySelect"
													class="input"
													placeholder="Saisissez les premiers caractères"
													ref='citySelect'
													:disabled="false"
													src="/json/cities"
													v-model="citySelect"
													aria-describedby='citySelectError'
													value="citySelect">
											</autocomplete>
											<input type="hidden" name="city_id" :value="zone.value.id"
												   v-for="(zone,i) in citySelect">
											<div>
											<span class="tag is-info"
												  v-for="(zone,i) in citySelect"
												  @click="_ => citySelect.splice(i,1)">
												Code postal sélectionné :&nbsp;&nbsp;
												<b>@{{ zone.label }}</b>
												&nbsp;&nbsp;
												<i class="fa fa-trash" style="cursor:pointer"></i>
											</span>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="column">
								<div class="field">
									<label class="label">Ville</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="city" name="city"
													class="input @error('city') is-danger @enderror "
													autocomplete="city">
												<option value=""></option>
											</select>
										</div>
										<div class="icon is-small is-left">
											<i class="fas fa-city"></i>
										</div>
									</div>
								</div>
							</div>
							<div class="column">
								<div class="field">
									<label class="label">Pays</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="country_id" name="country_id"
													class="input @error('country_id') is-danger @enderror "
													required>
												<option disabled="disabled" selected>Choississez votre pays...</option>
												@foreach($countries as $country)
													<option value="{{$country->id}}" {{old('country_id') == $country->id ? 'selected' : ''}}>{{$country->name_fr_fr}}</option>
												@endforeach
											</select>
										</div>
										<div class="icon is-small is-left">
											<i class="fas fa-globe"></i>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="field">
							<label class="label">Mot de passe</label>
							<p class="control has-icons-left">
								<input id="password" name="password"
									   class="input @error('password') is-danger @enderror "
									   type="password"
									   required
									   autocomplete="new-password" placeholder="Votre mot de passe...">
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
								<input id="password-confirm" name="password_confirmation"
									   class="input" type="password"
									   autocomplete="new-password"
									   required
									   placeholder="Ressaisissez mot de passe...">
								<span class="icon is-small is-left">
                              <i class="fas fa-lock"></i>
                            </span>
							</p>
						</div>
						<div class="field">
							<label class="checkbox">
								<input type="checkbox" required>
								"J'ai pris connaissance de <a>la charte d'utilisation de la plateforme d'annonces du
									site
									web de
									Terre de Liens</a> ."
							</label>
						</div>
						<div class="field">
							<label class="checkbox">
								<input type="checkbox" name="accept_communication" id="accept_communication"
									   value="1">
								J'accepte de recevoir les communications de Terre de Liens
							</label>
						</div>
						<div class="field is-grouped is-centered">
							<div class="control">
								<p>En appuyant sur valider, vous consentez <a>à l'utilisation de vos données
										personnelles</a> par Objectif Terres </p>
								<button type="submit" class="button is-link">Valider</button>
							</div>
						</div>
						{!! Form::close() !!}
						<div class="section">
							<h4 class="title is-4 has-text-centered">Vous avez déjà un compte ?</h4>
							<p class="has-text-centered"><a href="{{route('signIn')}}">Se connecter</a></p>
						</div>
					</div>
				</div>
				<div class="column"></div>
			</div>
		</register-form>
	</div>
	@include('components.supportTerreLiens')

@endsection

@section('script')
	<script>
        const vueRegisterForm = new Vue({
            el: '#vue-register-form',
            name: 'content'
        });
	</script>
@endsection
