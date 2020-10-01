<div v-if="responseTemplateToDelete === {{$response->id}}" class="modal" v-bind:class="{'is-active': showModal}">
    <div class="modal-background custom-modal-background" v-on:click="closeValidationModal()"></div>
    <div class="modal-content-validation">
        <div class="card">
            <div class="card-content">
                <div class="content">
                    <p class="title is-3 has-text-centered has-text-link">Êtes-vous sûr·e de votre choix ?</p>
                    <p class="has-text-centered">Ce message sera supprimé pour tous les utilisateurs. </p>
                </div>
            </div>
            <footer class="card-footer">
                <div class="buttons card-footer-item">
                    <button type="submit" class="button is-link">
                        <span>Valider</span>
                    </button>
                    <a class="button is-link is-light" v-on:click="closeValidationModal()">
                        <span>Annuler</span>
                    </a>
                </div>
                <a id="close-modal" class="modal-close is-large" aria-label="close"
                   v-on:click="closeValidationModal()"></a>
            </footer>
        </div>
    </div>
</div>
