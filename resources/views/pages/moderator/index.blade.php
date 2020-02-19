@extends ('default')

@section ('title', 'Mon esapce modérateur')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace modérateur <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>
		<div class="tabs">
			<ul>
				<li class="is-active"><a>Vos annonces attribuées</a></li>
				<li><a>Messagerie</a></li>
				<li><a>Aide</a></li>
			</ul>
		</div>
		<div class="notification is-info is-light ">
			<button class="delete"></button>
			<p><i class="far fa-bell"></i> Vous avez <strong>5 nouvelles annonces</strong> à modérer !</p>
			<p><i class="fas fa-envelope"></i> Vous avez <strong>2 nouveaux messages !</strong></p>
		</div>

		<div id="vue-form-moderator">
			<research-form-moderator inline-template>
				<div>
					<div class="columns">
						<div class="column is-four-fifths">
							<div class="columns">
								<div class="column">
									<button class="button is-info is-light is-fullwidth">Offre foncière</button>
								</div>
								<div class="column">
									<button class="button is-link is-light is-fullwidth">Proposition foncière</button>
								</div>
								<div class="column">
									<button class="button is-light is-fullwidth">Offre d'emplois</button>
								</div>
								<div class="column">
									<button class="button is-grey-lighter is-fullwidth">Recherche d'emplois</button>
								</div>
							</div>
						</div>

						<div class="column">
							<div class="field">
								<div class="control has-icons-left">
									<div class="select">
										<select>
											<option selected>Plages de date</option>
										</select>
									</div>
									<div class="icon is-small is-left">
										<i class="fas fa-calendar-alt"></i>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="columns">
						<div class="column is-one-third">
							<div class="columns">
								<div class="column is-half">
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
														src="/locations/cities"
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
										<p class="label">Dans un rayon de </p>
										<vue-slider
												name="radius_research"
												:data="{
													0: '0km',
													5: '5km',
													10: '10km',
													20: '20km',
													50: '50km'
												}"
										></vue-slider>
									</div>
								</div>
							</div>
						</div>
						<div class="column is-one-third">
							<label class="label">Départements</label>
							<multi-select
									:options="{{ json_encode($departments) }}"
									:multiple="true"
									name="departments_location_researches[]"
									selected-count-text="département(s) sélectionné(s)"
									placeholder="Choississez un/des département(s)">
							</multi-select>
						</div>
						<div class="column is-one-third">
							<label class="label">Régions</label>
							<multi-select
									:options="{{ json_encode($regions) }}"
									:multiple="true"
									name="departments_location_researches[]"
									selected-count-text="département(s) sélectionné(s)"
									placeholder="Choississez un/des département(s)">
							</multi-select>
						</div>

					</div>
				</div>
			</research-form-moderator>

		</div>
	</div>

@endsection

@section('script')

	<script>
        const vueThreads = new Vue({
            el: '#vue-form-moderator',
            name: 'content'
        });

	</script>

@endsection
