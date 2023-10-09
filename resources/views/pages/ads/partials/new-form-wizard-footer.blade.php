<template slot="footer" slot-scope="props">
    <div class="wizard-footer-left">
        <wizard-button>
            <b-button size="is-medium" rounded type="is-warning" @mousedown="onSaveButtonClick"
                      @click="onSaveButtonSubmit">Enregistrer l’annonce en tant que brouillon
            </b-button>
        </wizard-button>
    </div>
    <div class="wizard-footer-right">

        <wizard-button v-if="props.activeTabIndex > 0">
            <b-button @click.native="props.prevTab()"
                      size="is-medium"
                      rounded>Etape précédente
            </b-button>
        </wizard-button>
        <wizard-button v-if="!props.isLastStep" @click.native="props.nextTab()">
            <b-button @keyup.enter="props.nextTab"
                      size="is-medium"
                      class="ml-2" rounded type="is-danger">Etape suivante
            </b-button>
        </wizard-button>
        <wizard-button v-else>
            <b-button @click="props.nextTab"
                      size="is-medium"
                      class="ml-2" rounded type="is-danger">
                @if(!empty($isSupportRequest))
                    @if(!empty($old["id"]))
                        Mettre à jour la demande
                    @else
                        Soumettre la demande
                    @endif
                @else
                    Demander la publication
                @endif
            </b-button>
        </wizard-button>
    </div>
</template>
