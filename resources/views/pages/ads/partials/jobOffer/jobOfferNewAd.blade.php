<div id="job_offer_ad_form" class="form-container">
	<form-wizard
			title=""
			subtitle=""
			step-size="xs"
			@on-complete="$emit('form-complete')"
			@on-change="nextStep"
			color="#3498db"
			ref="formWizard">
		<tab-content title="Localisation" icon="ti-location-arrow">
			<section class="container">
				<div class="columns">
					<div class="column"></div>
					<div class="column is-half">
						@include('pages.ads.partials.inputs.zip_code', ['uri'=>'cities', 'label'=>"Code postal de l'offre"])
					</div>
					<div class="column"></div>
				</div>
			</section>
		</tab-content>

		<tab-content title="Description" icon="ti-location-arrow">
			<section class="container">
				<div class="columns">
					<div class="column"></div>
					<div class="column is-half">
						<div class="field">
							{!! Form::label('job_offer[offer_types][]', "Type d'offre", ['class' => 'label']); !!}

							@include('pages.ads.partials.inputs.jobOfferTypes', ["name" => "job_offer[offer_types][]"])
						</div>

						<div class="field">
							{!! Form::label('job_offer[is_activity_transmission]', "S'agit-il d'une transmission ou d'une possibilité de transmission de l'activité agricole ?", [
								'class' => 'label'
							]) !!}
							{!! Form::radio('job_offer[is_activity_transmission]', 1, old('is_activity_transmission') , [
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
							oui
							{!! Form::radio('job_offer[is_activity_transmission]', 0, old('is_activity_transmission') , [
                                ':disabled' => 'isInputDisabled'
                            ]) !!}
							non
						</div>

						<div class="field">
							<label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
								   for="about_content">
								Description du poste proposé*
							</label>

							<text-area-counter
									name="job_offer[job_description]"
									:max-length="1000"
									:disabled="isInputDisabled"
									ref="jobDescription"
									v-model="formInput.jobDescription"
									:vuelidate="$v.formInput.jobDescription">
							</text-area-counter>
						</div>

					</div>
					<div class="column"></div>
				</div>
			</section>
		</tab-content>

		<tab-content title="Profil recherché" icon="ti-location-arrow">
			<section class="container">
				<div class="columns">
					<div class="column"></div>
					<div class="column is-half">

						<div class="field">
							<label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
								   for="about_content">
								Expérience souhaitée dans le milieu agricole
							</label>

							<text-area-counter
									name="job_offer[experience_farming]"
									:max-length="1000"
									:disabled="isInputDisabled"
									ref="experienceFarming"
									v-model="formInput.experienceFarming"
									:vuelidate="$v.formInput.experienceFarming">
							</text-area-counter>
						</div>



						<div class="field">
							{!! Form::label('land_offer[education_levels][]', 'Niveau de formation souhaité', ['class' => 'label']); !!}

{{--							<multi-select--}}
{{--									:options="{{json_encode($educationLevels)}}"--}}
{{--									name="job_offer[education_levels][]"--}}
{{--									v-model="formInput.educationLevels"--}}
{{--									placeholder="Sélectionnez un ou plusieurs niveaux"--}}
{{--									ref="educationLevels">--}}
{{--							</multi-select>--}}

							<div class="columns">
								@foreach($educationLevels as $i => $educationlevel)
									<div class="column">
										<custom-checkbox
												name="job_offer[education_levels][]"
												input-value="{{$educationlevel["id"]}}"
												v-model="formInput.educationLevels"
												:disabled="isInputDisabled"
												ref="educationLevels">

{{--											<i class="fa {{$educationlevel["icon"]}}"--}}
{{--											   style="font-size: 30px;"></i><br><br>--}}
											<span style="font-size:16px">
													{{ $educationlevel["name"] }}
												</span>
										</custom-checkbox>

									</div>
									@if($i % 2)
									</div>
									<div class="columns">
									@endif
								@endforeach
							</div>
						</div>
					</div>
					<div class="column"></div>
				</div>
			</section>
		</tab-content>

		<tab-content title="La ferme et vous" icon="ti-location-arrow">
			<section class="container">
				<div class="columns">
					<div class="column"></div>
					<div class="column is-half">

						<?php
							$aboutFarmLabel = "Et si vous nous en disiez un peu plus sur la ferme ?";
							$aboutFarmTooltip = "Quelles sont les principales activités de la ferme ? Ses spécificités ?
													Les possibilités de logement sur place ?
													Ex : ferme de 50 ha avec production de céréales ; l'objectif est de diversifier les activités par un atelier de porc plein air.
													Ex : la ferme est en agriculture biologique depuis 2015. Un magasin de vente directe est implanté sur la ferme. ";
						?>
						@include('pages.ads.partials.inputs.about_project_content', ['title' => $aboutFarmLabel, 'tooltip' => $aboutFarmTooltip])

						<?php
							$aboutTooltip = "Vous travaillez sur la ferme ?
							Dites-en un peu plus sur vous (votre parcours, vos motivations...) et/ou vos associés.
							Vous êtes une personne morale dans le cadre d’un appel à candidatures ?
							Présentez votre structure et vos missions principales en quelques lignes.";
						?>
						@include('pages.ads.partials.inputs.about_content', ['tooltip' => $aboutTooltip])
					</div>
					<div class="column"></div>
				</div>
			</section>
		</tab-content>

		<tab-content title="C'est presque fini !" icon="ti-share">
			<section class="container">
				<div class="columns">
					<div class="column"></div>
					<div class="column is-half">
						<?php
							$titleTooltip = "Un titre clair et bien formulé augmente vos chances de contacts.
											ex : Urgent recherche salarié(e) pour ferme caprine dans le Jura";
						?>
						@include('pages.ads.partials.inputs.title', ["tooltip"=>$titleTooltip])

						@include('pages.ads.partials.inputs.documents')

                        @include('pages.ads.partials.inputs.accept-share-contact-infos')

						<article class="message is-warning" v-if="$v.$error">
							<div class="message-header">
								<p>Veuillez revoir votre formulaire</p>
							</div>
							<div class="message-body">
								Des erreurs empêchent la publication de votre annonce. Avez-vous tout vérifié ?
							</div>
						</article>
					</div>
					<div class="column"></div>
				</div>
			</section>
		</tab-content>

		@include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"job_offer"])
	</form-wizard>
</div>
