@extends ('default')

@section ('title', 'Mon espace modérateur')

@section('main-content')

	<div class="section">
		<h1 class="title is-2 has-text-link">Bienvenue sur votre espace modérateur <span
					class="is-italic">{{ Auth::user()->first_name }} {{ Auth::user()->name }}</span></h1>

		@include('components.moderatorTabs')

		<div class="notification has-background-info">
			<button class="delete"></button>
			@if($numberOfAdsToModerate >1)
				<p class="has-text-white-ter"><i class="far fa-bell has-text-white-ter"></i> Vous avez
					<strong>{{$numberOfAdsToModerate}} annonces</strong> à modérer !</p>
			@else
				<p class="has-text-white-ter"><i class="far fa-bell has-text-white-ter"></i> Vous avez
					<strong>{{$numberOfAdsToModerate}} annonce</strong> à modérer !</p>
			@endif

			@if($numberOfUnreadMessages > 1 )
				<a style="text-decoration: none" href="{{route('threads.index')}}"><p class="has-text-white"><i
								class="fas fa-envelope "></i> Vous
						avez <strong>{{$numberOfUnreadMessages}}
							nouveaux messages
							!</strong></p></a>

			@else
				<a style="text-decoration: none" href="{{route('threads.index')}}">
					<p class="has-text-white"><i class="fas fa-envelope"></i> Vous avez
						<strong>{{$numberOfUnreadMessages}} nouveau message !</strong>
					</p>
				</a>
			@endif
		</div>
		{{Form::open(['route'=>'moderator.show', 'method'=>'get'])}}
		<div id="vue-form-moderator">
			<research-form-moderator inline-template>
				<div>
					<div class="columns">
						<div class="column is-four-fifths">
							<div class="columns">
								<?php
								$adTypes = [
									['name' => 'Offre foncière', 'value' => 'landOfferAd'],
									['name' => 'Recherche foncière', 'value' => 'landSeekAd'],
									['name' => 'Offre d\'emploi', 'value' => 'jobOfferAd'],
									['name' => 'Recherche d\'emploi', 'value' => 'jobSeekAd'],
								];
								$adTypesFaIcons = ["fa-home", "fa-home", "fa-universal-access", "fa-universal-access"]
								?>
								@foreach($adTypes as $i => $adType)
									<div class="column">
										<custom-checkbox
												name="ad_type[]"
												input-value="{{$adType['value']}}"
												v-model="adTypeSelected"
												ref="typeSelected"
												:is-radio="false">
											<i class="fa {{ $adTypesFaIcons[$i] }}"
											   style="font-size: 30px;"></i><br><br>
											<span style="font-size:16px">
                                              {{$adType['name']}}
                                            </span>
										</custom-checkbox>
									</div>
								@endforeach
							</div>
							{{--							<div class="columns">--}}
							{{--								<div class="column">--}}
							{{--									<div @click="adTypeSelected('landOfferAd')"--}}
							{{--										 class="button is-link is-fullwidth form-research-buttons">--}}
							{{--											<span class="icon is-small  ">--}}
							{{--												  <i class="fas fa-check"></i>--}}
							{{--										</span>--}}
							{{--										<span>Offre foncière</span>--}}
							{{--									</div>--}}
							{{--								</div>--}}
							{{--								<div class="column">--}}
							{{--									<div @click="adTypeSelected('landSeekAd')"--}}
							{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
							{{--											<span class="icon is-small is-hidden ">--}}
							{{--												  <i class="fas fa-check"></i>--}}
							{{--										</span>--}}
							{{--										<span>Recherche foncière</span>--}}
							{{--									</div>--}}
							{{--								</div>--}}
							{{--								<div class="column">--}}
							{{--									<div @click="adTypeSelected('jobOfferAd')"--}}
							{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
							{{--											<span class="icon is-small is-hidden ">--}}
							{{--												  <i class="fas fa-check"></i>--}}
							{{--										</span>--}}
							{{--										<span>Offre d'emploi</span>--}}
							{{--									</div>--}}
							{{--								</div>--}}
							{{--								<div class="column">--}}
							{{--									<div @click="adTypeSelected('jobSeekAd')"--}}
							{{--										 class="button is-link is-light is-fullwidth form-research-buttons">--}}
							{{--											<span class="icon is-small is-hidden ">--}}
							{{--												  <i class="fas fa-check"></i>--}}
							{{--										</span>--}}
							{{--										<span>Recherche d'emploi</span>--}}
							{{--									</div>--}}
							{{--								</div>--}}
							{{--							</div>--}}
						</div>
						{{--						<input type="hidden" v-bind:value="typeSelected" name="ad_type">--}}
						<div class="column">
							<div class="control has-icons-right ">
								<label class="label"> Annonces soumises depuis le </label>
								<date-picker></date-picker>
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
												<input type="hidden" name="city_location_researches[]"
													   :value="zone.value.id"
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
									v-model="departmentsSelected"
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
									v-model="regionsSelected"
									name="regions_location_researches[]"
									selected-count-text="département(s) sélectionné(s)"
									placeholder="Choississez un/des département(s)">
							</multi-select>
						</div>
					</div>
					<hr class="navbar-divider">

					<div class="columns">
						<div class="column is-half">
							<p class="label has-text-centered">Status de l'annonce</p>
							<div class="columns is-mobile is-multiline is-centered">
								@foreach($adStatuses as $adStatus)
									<div class="column is-narrow has-text-centered">
										<label class="checkbox">
											<input name="ad_statuses[]" value="{{(int)$adStatus->id}}" type="checkbox">
											{{$adStatus->name}}
										</label>
									</div>
								@endforeach
							</div>
						</div>
						<div class="column is-half">
							<p class="label has-text-centered">Status du projet</p>
							<div class="columns  is-mobile is-multiline is-centered">
								@foreach($projectStatuses as $projectStatus)
									<div class="column is-narrow has-text-centered">
										<label class="checkbox">
											<input name="project_statuses[]" value="{{(int)$projectStatus->id}}"
												   type="checkbox">
											{{$projectStatus->name}}
										</label>
									</div>
								@endforeach

							</div>
						</div>
					</div>
					<hr class="navbar-divider">

					<div class="columns">
						<div class=" column is-one-third ">
							<label class="label">Recherche par titre de l'annonce</label>
							<input name="ad_title" class="input" type="text" placeholder="Votre recherche...">
						</div>

						{{--						<div v-if="adType === 'land'" class=" column is-3">--}}
						{{--							<label class="label">Système de production</label>--}}
						{{--							<div class="select">--}}
						{{--								<select name="production_genres">--}}
						{{--									@foreach($productionGenres as $productionGenre)--}}
						{{--										<option value="{{$productionGenre->id}}">{{$productionGenre->name}} </option>--}}
						{{--									@endforeach--}}
						{{--								</select>--}}
						{{--							</div>--}}
						{{--						</div>--}}
						{{--						<div v-if="adType === 'land'" class="column is-4">--}}
						{{--							<div class="field">--}}
						{{--								<p class="label">Surface(en ha) </p>--}}
						{{--								<vue-slider-range--}}
						{{--										name-min="land_seek[surface_range_min]"--}}
						{{--										name-max="land_seek[surface_range_max]"--}}
						{{--										:data="{--}}
						{{--													0: '0 ha',--}}
						{{--													5: '5 ha',--}}
						{{--													10: '10 ha',--}}
						{{--													20: '20 ha',--}}
						{{--													50: '50 ha'--}}
						{{--												}"--}}
						{{--										:value="0"--}}
						{{--								></vue-slider-range>--}}
						{{--							</div>--}}
						{{--						</div>--}}
						{{--						<div v-if="adType === 'job'" class="column is-4 has-text-center">--}}
						{{--							<label class="label">Statut de l'emploi</label>--}}
						{{--							<div class="select">--}}
						{{--								<select name="projectStatus">--}}
						{{--									@foreach($jobOfferTypes as $jobOfferType)--}}
						{{--										<option value="{{$jobOfferType->id}}">{{$jobOfferType->name}} </option>--}}
						{{--									@endforeach--}}
						{{--								</select>--}}
						{{--							</div>--}}
						{{--						</div>--}}
						<div class="column  ">
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

			@if (count($attributionAds) ==0)
				<p class="has-text-centered">Vous n'avez pas d'annonce à modérer</p>
			@else
				<div class="table-container">
					<table class="table is-striped is-hoverable is-fullwidth ">
						<thead>
						<tr>
							<th>Date de soumission</th>
							<th>Titre de l'annonce</th>
							<th>Type d'annonce</th>
							<th>Nom du porteur de projet</th>
							<th>Adresse mail</th>
							<th>Localisation(s)</th>
							<th>Statut de l'annonce</th>
							<th>Statut du projet</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
						@foreach($attributionAds as $attributionAd)
							<tr>
								<td>{{$attributionAd->ad->submitDate}}</td>
								<td>
									<a href="{{route('ads.show', $attributionAd->ad->id)}}">{{$attributionAd->ad->title}}</a>
								</td>
								<td>{{$attributionAd->ad->ad_type_full_name}}</td>
								<td>
									<a href="{{route('user.show', $attributionAd->ad->userPp->id)}}">{{$attributionAd->ad->userPp->first_name}} {{$attributionAd->ad->userPp->name}}</a>
								</td>
								<td>{{$attributionAd->ad->userPp->email}}</td>
								<td>
									@if(! is_null($attributionAd->ad->regionsList))
										<p>Region(s) : {{$attributionAd->ad->regionsList}}</p>
									@endif
									@if(! is_null($attributionAd->ad->departmentList))
										<p>Département(s) : {{$attributionAd->ad->departmentsList}}</p>
									@endif
									@if(! is_null($attributionAd->ad->citiesList))
										<p>Communes(s) : {{$attributionAd->ad->citiesList}}</p>
									@endif
								</td>
								<td>
									@if($attributionAd->adStatus->name === "Validé")
										<span class="tag is-success">{{$attributionAd->adStatus->name}}</span>
									@elseif($attributionAd->adStatus->name ==="A modifier")
										<span class="tag is-warning is-light">{{$attributionAd->adStatus->name}}</span>
									@elseif($attributionAd->adStatus->name === "Refuser")
										<span class="tag is-danger">{{$attributionAd->adStatus->name}}</span>

									@elseif($attributionAd->adStatus->name === "A modérer")
										<span class="tag is-warning">{{$attributionAd->adStatus->name}}</span>
									@elseif($attributionAd->adStatus->name === "A assigner")
										<span class="tag is-primary">{{$attributionAd->adStatus->name}}</span>
									@else
										<span class="tag is-info">{{$attributionAd->adStatus->name}}</span>
									@endif
								</td>
								<td>
									@if(is_null($attributionAd->ad->project))
										<span class="tag is-light">L'annonce n'a pas le status de projet</span>
									@else
										@if($attributionAd->ad->project->projectStatus->name === "Accompagné")
											<span class="tag is-success is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@elseif($attributionAd->ad->project->projectStatus->name ==="Installé")
											<span class="tag is-success is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@elseif($attributionAd->ad->project->projectStatus->name === "A rappeler")
											<span class="tag is-danger is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>

										@elseif($attributionAd->ad->project->projectStatus->name === "Non accompagné")
											<span class="tag is-warning is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@else
											<span class="tag is-info is-light">{{$attributionAd->ad->project->projectStatus->name}}</span>
										@endif
									@endif

								</td>
								<td><a href="{{route('ads.show', $attributionAd->ad->id)}}"><span><i
													class="fas fa-search"></i></span> <span>Voir le détail</span></a>
								</td>
							</tr>

						@endforeach
						</tbody>
					</table>
				</div>
			@endif
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
