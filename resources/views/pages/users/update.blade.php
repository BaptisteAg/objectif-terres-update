@extends('default')
@section('title', 'Mon compte | Objectif Terres')

@section('main-content')


	<div id="vue-update-user-form" class="section">
		<user-form id="update-form"
					   inline-template
					   :old-values="{{json_encode(count(old()) ? old() : json_encode($user->zipCode))}}">
			<div class="container">
					<nav class="level">
						<div class="level-left">
							<div>
								<h1 class="title">Vos informations personnelles</h1>
								<h2 class="subtitle"> Modifier si besoin les informations liées à votre compte</h2>
							</div>
						</div>
					</nav>
						{!! Form::open(['route'=>'user.update']) !!}
						@csrf
						<div class="columns">
							<div class="column is-two-fifths">
								<div class="field">
									<label class="label">Nom</label>
									<div class="control has-icons-left">
										<input id="name" name="name" class="input @error('name')is-danger @enderror"
											   type="text"
											   value="{{ old('name') ? old('name') : $user->name }}"  autocomplete="name" autofocus
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
							<div class="column is-two-fifths">
								<div class="field">
									<label class="label">Prénom</label>
									<div class="control has-icons-left">
										<input id="first_name" name="first_name"
											   class="input @error('first_name')is-danger @enderror" type="text"
											   value="{{ old('first_name') ? old('first_name') : $user->first_name }}"  autocomplete="first_name"
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
							<div class="column is-one-fifths">
								<div class="field">
									<label class="label">Civilité</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="civility" name="civility"
													class="input @error('civility') is-danger @enderror ">
												<option value="" disabled="disabled" selected> </option>
												<option value="1" {{old('civility') == 1 || $user->civility == 1 ? 'selected' : ''}}>Madame</option>
												<option value="2" {{old('civility') == 2 || $user->civility == 2 ? 'selected' : ''}}>Monsieur</option>
												<option value="3" {{old('civility') == 3 || $user->civility == 3 ?'selected' : ''}}>Autre</option>
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
											   name="phone" value="{{ old('phone') ? old('phone') : $user->phone }}" autocomplete="phone" autofocus
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
										<input id="email"
											   class="input @error('email') is-danger @enderror"
											   type="email"
											   name="email"
											   value="{{old('email') ? old('email') : $user->email }}"
											   required
											   autocomplete="email"
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

						<div class="columns">
							<div class="column is-two-thirds">
								<div class="field">
									<label for="profile" class="label">Votre situation</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="profile"
													name="profile"
													v-model="optionProfileSelected"
													class="input @error('profile') is-danger @enderror ">
												<option disabled="disabled" selected>Vous êtes...</option>
												<option value="1" {{old('profile') == 1 || $user->profile == 1 ? 'selected' : ''}} >un candidat à l’installation agricole</option>
												<option value="2" {{old('profile') == 2 || $user->profile == 2 ? 'selected' : ''}}>une personne en recherche de travail ou d’expérience
													professionnelle dans le
													domaine agricole
												</option>
												<option value="3" {{old('profile') == 3 || $user->profile == 3 ? 'selected' : ''}}>un agriculteur qui souhaite consolider sa ferme
												</option>
												<option value="4" {{old('profile') == 4 || $user->profile == 4 ? 'selected' : ''}}>un agriculteur qui souhaite transmettre sa ferme
												</option>
												<option value="5" {{old('profile') == 5 || $user->profile == 5 ? 'selected' : ''}}>un propriétaire foncier qui souhaite vendre ou louer
													sa
													terre
												</option>
												<option value="6" {{old('profile') == 6 || $user->profile == 6 ? 'selected' : ''}}>Autre</option>
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
							<div v-if="optionProfileSelected === '6'" class="column">
								<div class="field">
									<label class="label">Situation autre </label>
									<p class="control has-icons-left has-icons-right">
										<input id="other_profile"
											   class="input @error('other_profile') is-danger @enderror"
											   type="text"
											   name="other_profile" value="{{ old('other_profile')? old('other_profile') : $user->other_profile }}" required
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
							<label class="label">Adresse</label>
							<p class="control has-icons-left">
								<input id="address" class="input @error('address') is-danger @enderror" type="text"
									   name="address" value="{{ old('address')? old('address') : $user->address }}" required autocomplete="address"
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
							<div class="column is-two-third">
								<div class="field">
									<label class="label">Commune et Code postal</label>
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
											&nbsp;&nbsp;
											<i class="fa fa-trash" style="cursor:pointer"></i>
										</div>
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
							<div class="column is-one-third">
								<div class="field">
									<label class="label">Pays*</label>
									<div class="control has-icons-left">
										<div class="select">
											<select id="country_id" name="country_id"
													class="input @error('country_id') is-danger @enderror "
													required>
												<option disabled="disabled" selected>Choississez votre pays...</option>
												@foreach($countries as $country)
													<option value="{{$country->id}}" {{old('country_id') == $country->id || $user->country_id == $country->id ? 'selected' : ''}}>{{$country->name_fr_fr}}</option>
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
							<label class="label">Mot de passe*</label>
							<p class="control has-icons-left">
								<input id="password"
									   name="password"
									   class="input @error('password') is-danger @enderror "
									   type="password"
									   required
									   autocomplete="new-password"
									   placeholder="Votre mot de passe..."
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
						<div class="field is-grouped is-grouped-centered">
							<div class="control is-pulled-right">
								<button type="submit" class="button is-link ">Enregistrer</button>
							</div>
						</div>
						{!! Form::close() !!}
				</div>
		</user-form>
	</div>
@endsection

@section('script')
	<script>
        const vueUpdateForm = new Vue({
            el: '#vue-update-user-form',
            name: 'content'
        });
	</script>
@endsection