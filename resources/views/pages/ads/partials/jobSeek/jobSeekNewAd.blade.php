<div id="job_ad_form">
    <form-wizard
            title=""
            subtitle=""
            step-size="xs"
            @on-complete="$emit('form-complete')"
            color="#3498db"
            ref="formWizard">

        <tab-content title="Localisation" icon="ti-location-arrow">
            @include('pages.ads.partials.inputs.locations', ['label' => 'Où souhaitez-vous travailler ?'])
        </tab-content>

        <tab-content title="Description" icon="ti-location-arrow">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">
                        <div class="field">
                            {!! Form::label('job_seek[offer_types][]', "Quel type d'opportunité professionnelle recherchez-vous ?", ['class' => 'label']); !!}

                            <?php
                            $offerTypesFaIcons = ["fa-user", "fa-user-friends", "fa-users"]
                            ?>

                            <div class="columns">
                                @foreach($jobOfferTypes as $i => $offerType)
                                    <div class="column">
                                        <custom-checkbox
                                                name="job_seek[offer_types][]"
                                                input-value="{{$offerType["id"]}}"
                                                v-model="formInput.offerTypes"
                                                :disabled="isInputDisabled"
                                                ref="offerTypes">

                                            <i class="fa {{ $offerTypesFaIcons[$i] }}"
                                               style="font-size: 30px;"></i><br><br>
                                            <span style="font-size:16px">
                                                {{ $offerType["name"] }}
                                            </span>
                                        </custom-checkbox>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Votre profil" icon="ti-location-arrow">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        <div class="field">
                            <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
                                   data-tooltip="Vous avez déjà travaillé ou été en stage sur une ferme ?
                                   Réalisé du wwoofing ? Combien de temps ?
                                   Racontez-ici votre expérience du milieu agricole."
                                   for="about_content">
                                Expérience dans le milieu agricole
                                <i class="fas fa-info-circle has-text-info"></i>
                            </label>

                            <text-area-counter
                                    name="job_seek[experience_farming]"
                                    :max-length="1000"
                                    :disabled="isInputDisabled"
                                    ref="experienceFarming"
                                    v-model="formInput.experienceFarming"
                                    :vuelidate="$v.formInput.experienceFarming">
                            </text-area-counter>
                        </div>



                        <div class="field">
                            {!! Form::label('land_offer[education_levels][]', 'Niveau de formation', ['class' => 'label']); !!}

                            <multi-select
                                    :options="{{json_encode($educationLevels)}}"
                                    name="job_seek[education_levels][]"
                                    v-model="formInput.educationLevels"
                                    placeholder="Sélectionnez un ou plusieurs niveaux"
                                    ref="educationLevels">
                            </multi-select>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
            </section>
        </tab-content>

        <tab-content title="Expérience" icon="ti-location-arrow">
            <section class="container">
                <div class="columns">
                    <div class="column"></div>
                    <div class="column is-half">

                        <?php
                            $aboutFarmLabel = "Et si vous nous en disiez un peu plus sur votre projet et vos attentes ?";
                            $aboutFarmTooltip = "Que recherchez-vous plus précisement ? Cette recherche s'inscrit-elle dans une volonté d'installation à plus long terme ?";
                        ?>
                        @include('pages.ads.partials.inputs.about_project_content', ['title' => $aboutFarmLabel, 'tooltip' => $aboutFarmTooltip])

                        <?php
                            $aboutTitle = "Et si vous nous en disiez un peu plus sur vous ?";
                            $aboutTooltip = "Présentez-vous en quelques lignes pour faciliter la mise en relation : valeurs, compétences spécifiques, mobilité, etc. ";
                        ?>
                        @include('pages.ads.partials.inputs.about_content', ['title' => $aboutTitle, 'tooltip' => $aboutTooltip])
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
                        $titleTooltip = "Un titre clair et bien formulé augmentera vos chances de contacts!
                                        ex : Jeune diplômé recherche emploi en maraîchage bio diversifié";
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

        @include('pages.ads.partials.form-wizard-footer', ["moveToRef"=>"job_seek"])
    </form-wizard>
</div>
