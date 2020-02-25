@extends ('default')

@section ('title', 'Mon espace modérateur')

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
		<div class="notification is-light is-info">
			<button class="delete"></button>
			<p><i class="far fa-bell"></i> Vous avez <strong>5 nouvelles annonces</strong> à modérer !</p>
			<p><i class="fas fa-envelope"></i> Vous avez <strong>2 nouveaux messages !</strong></p>
		</div>
		{{Form::open(['route'=>'moderator.index'])}}
		<div id="vue-form-moderator">
			<research-form-moderator inline-template>
				<div>
					<div class="columns">
						<div class="column is-four-fifths">
								<div class="columns">
									<div class="column">
										<div @click="adTypeSelected('landOffer')"
											 class="button is-info is-light is-fullwidth form-research-buttons">
											<span class="icon is-small is-hidden ">
												  <i class="fas fa-check"></i>
										</span>
											<span>Offre foncière</span>
										</div>
									</div>
									<div class="column">
										<div @click="adTypeSelected('landSeek')"
											 class="button is-link is-light is-fullwidth form-research-buttons">
											<span class="icon is-small is-hidden ">
												  <i class="fas fa-check"></i>
										</span>
											<span>Recherche foncière</span>
										</div>
									</div>
									<div class="column">
										<div @click="adTypeSelected('jobOffer')"
											 class="button is-info is-light is-fullwidth form-research-buttons">
											<span class="icon is-small is-hidden ">
												  <i class="fas fa-check"></i>
										</span>
											<span>Offre d'emploi</span>
										</div>
									</div>
									<div class="column">
										<div @click="adTypeSelected('jobSeek')"
											 class="button is-link is-light is-fullwidth form-research-buttons">
											<span class="icon is-small is-hidden ">
												  <i class="fas fa-check"></i>
										</span>
											<span>Recherche d'emploi</span>
										</div>
									</div>
								</div>
						</div>
						<input type="hidden" v-bind:value="typeSelected" name="adTypeSelected">
						<div class="column">
							<div class="control has-icons-right ">
								<date-picker></date-picker>
								<span class="icon is-small is-right">
									<i class=" fa fa-calendar"></i>
							 	 </span>
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
						<div class="is-divider-vertical" data-content="OU"></div>
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
						<div class="is-divider-vertical" data-content="OU"></div>
						<div class="column ">
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
					<hr class="navbar-divider">

					<div class="columns is-centred">
						@foreach($projectStatuses as $projectStatus)
							<div class="column has-text-centered">
								<label class="checkbox">
									<input value="{{$projectStatus->id}}" type="checkbox">
									{{$projectStatus->name}}
								</label>
							</div>
						@endforeach

					</div>
					<hr class="navbar-divider">

					<div class="columns">
						<div class=" column is-3">
							<label class="label">Recherche par mots clés</label>
							<input class="input" type="text" placeholder="Votre recherche...">
						</div>

						<div v-show="adType === 'land'" class=" column is-3">
							<label class="label">Système de production</label>
							<div class="select">
								<select>
									@foreach($productionGenres as $productionGenre)
										<option value="{{$productionGenre->id}}">{{$productionGenre->name}} </option>
									@endforeach
								</select>
							</div>
						</div>
						<div v-show="adType === 'land'" class="column is-4">
							<div class="field">
								<p class="label">Surface(en ha) </p>
								<vue-slider-range
										name-min="land_seek[surface_range_min]"
										name-max="land_seek[surface_range_max]"
										:data="{
													0: '0 ha',
													5: '5 ha',
													10: '10 ha',
													20: '20 ha',
													50: '50 ha'
												}"
										:value="0"
								></vue-slider-range>
							</div>
						</div>
						<div v-show="adType === 'job'" class="column is-4 has-text-center">
							<label class="label">Statut de l'emploi</label>
							<div class="select">
								<select>
									@foreach($jobOfferTypes as $jobOfferType)
										<option value="{{$jobOfferType->id}}">{{$jobOfferType->name}} </option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="column">
							<button type="submit" class="button is-link is-large is-pulled-right">
								<span>Filtrer</span>
							</button>
						</div>
					</div>
				</div>
			</research-form-moderator>
		</div>
		{{Form::close()}}

		<div class="section">
			<h1 class="title is-1 has-text-centered">Liste des annonces à modérer</h1>

			<div class="table-container">
				<table class="table is-striped is-hoverable is-fullwidth ">
					<thead>
					<tr>
						<th>Date de soumission</th>
						<th>Nom de l'annonce</th>
						<th>Type d'annonce</th>
						<th>Nom du porteur de projet</th>
						<th>Adresse mail</th>
						<th>Localisation(s)</th>
						<th>Status de l'annonce</th>
						<th>Status du projet</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					@foreach($ads as $ad)
						<tr>
							<td>{{$ad->ad->updated_at}}</td>
							<td>
								<a target="_blank" href="{{route('ads.show', $ad->ad->id)}}">{{$ad->ad->title}}</a>
							</td>
							<td>{{$ad->ad->ad_type_full_name}}</td>
							<td>{{$ad->ad->userPp->first_name}} {{$ad->ad->userPp->name}}</td>
							<td>{{$ad->ad->userPp->email}}</td>
							<td>
								@if(! is_null($ad->ad->regionsList))
									<p>Region(s) : {{$ad->ad->regionsList}}</p>
								@endif
								@if(! is_null($ad->ad->departmentList))
									<p>Département(s) : {{$ad->ad->departmentsList}}</p>
								@endif
								@if(! is_null($ad->ad->citiesList))
									<p>Communes(s) : {{$ad->ad->citiesList}}</p>
								@endif
							</td>
							<td>
								@if($ad->adStatus->name === "Validé")
									<span class="tag is-success">{{$ad->adStatus->name}}</span>
								@elseif($ad->adStatus->name ==="A modifier")
									<span class="tag is-warning is-light">{{$ad->adStatus->name}}</span>
								@elseif($ad->adStatus->name === "Refuser")
									<span class="tag is-danger">{{$ad->adStatus->name}}</span>

								@elseif($ad->adStatus->name === "A modérer")
									<span class="tag is-warning">{{$ad->adStatus->name}}</span>
								@elseif($ad->adStatus->name === "A assigner")
									<span class="tag is-primary">{{$ad->adStatus->name}}</span>
								@else
									<span class="tag is-info">{{$ad->adStatus->name}}</span>
								@endif
							</td>
							<td>

								@if($ad->ad->project->projectStatus->name === "Accompagné")
									<span class="tag is-success is-light">{{$ad->ad->project->projectStatus->name}}</span>
								@elseif($ad->ad->project->projectStatus->name ==="Installé")
									<span class="tag is-success is-light">{{$ad->ad->project->projectStatus->name}}</span>
								@elseif($ad->ad->project->projectStatus->name === "A rappeler")
									<span class="tag is-danger is-light">{{$ad->ad->project->projectStatus->name}}</span>

								@elseif($ad->ad->project->projectStatus->name === "Non accompagné")
									<span class="tag is-warning is-light">{{$ad->ad->project->projectStatus->name}}</span>
								@else
									<span class="tag is-info is-light">{{$ad->ad->project->projectStatus->name}}</span>
								@endif

							</td>
							<td><a target="_blank" href="{{route('ads.show', $ad->ad->id)}}"><span><i
												class="fas fa-search"></i></span> <span>Voir le détails</span></a>
							</td>
						</tr>

					@endforeach
					</tbody>
				</table>
			</div>
		</div>


	</div>

@endsection

@section('script')

	<script>
        const vueThreads = new Vue({
            el: '#vue-form-moderator',
            name: 'content'
        });

        let buttons = document.querySelectorAll('.form-research-buttons');
        let icons = document.querySelectorAll('.form-research-buttons-icons')

        buttons.forEach(function (btn) {
            btn.addEventListener('click', () => {
                buttons.forEach(function (b) {
                    b.classList.add('is-light');
                    b.firstElementChild.classList.add('is-hidden')
                });
                btn.classList.remove('is-light');
                btn.firstElementChild.classList.remove('is-hidden')
            });

        });
	</script>

@endsection
