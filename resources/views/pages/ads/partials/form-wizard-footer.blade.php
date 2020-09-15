<template slot="footer" slot-scope="props">
    <div class="affix-wizard-footer" data-move-to-ref="{{$moveToRef}}">
        <div class="wizard-footer-left">
            <span @click="props.prevTab" @keyup.enter="props.prevTab" v-if="props.activeTabIndex > 0"
                  role="button" tabindex="0">
              <wizard-button class="button is-light"
                             style="background-color: #eee;border-color: #eee;color: #555;"
                             :disabled="props.loading">
                Précédent
              </wizard-button>
            </span>
            <button tabindex="-1"
                    type="button"
                    class="wizard-btn button is-light"
                    onclick="location.href = '/';"
                    style="background-color: rgb(230, 230, 230); border-color: rgb(230, 230, 230); color: rgb(85, 85, 85);">
                Annuler
            </button>
        </div>

        <div class="wizard-footer-right">
            <button class="button is-light" @mousedown="onSaveButtonClick" @click="onSaveButtonSubmit">
                Sauvegarder
            </button>
            <span @mousedown="onPublishButtonClick" @click="props.nextTab" @keyup.enter="props.nextTab" v-if="props.isLastStep" role="button"
                  tabindex="0">
                <wizard-button
                        class="button is-primary"
                        :style="props.fillButtonStyle">
                    @if(!empty($isSupportRequest))
                        @if(!empty($old["id"]))
                            Mettre à jour la demande
                        @else
                            Soumettre la demande
                        @endif
                    @else
                        Demander la publication
                    @endif
                </wizard-button>
            </span>
            <span @click="props.nextTab" @keyup.enter="props.nextTab" role="button" tabindex="0" v-else>
                <wizard-button class="button is-primary"
                               :style="props.fillButtonStyle"
                               :disabled="props.loading">
                    Suivant
                </wizard-button>
            </span>
        </div>
    </div>
</template>