<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="15mo maximum par document. Un seul PDF est autorisé. Formats acceptés : .pdf, .doc, .docx, .jpg, .png">
        Documents
        <i class="fas fa-info-circle has-text-info"></i><br>
        <span style="font-weight:normal">
            Ajoutez des photos ou un document PDF pour donner envie de consulter votre annonce.<br>
        </span>
    </label>

    <vue-dropzone
        ref="documents"
        id="dropzone"
        :options="{
            url: '/documents/upload',
            thumbnailWidth: 150,
            maxFiles: 15,
            maxFilesize: 15,
            addRemoveLinks: true,
            uploadMultiple: true,
            acceptedFiles: 'image/*, application/pdf, application/msword',
            dictFileTooBig: 'Fichier trop volumineux: @{{filesize}}Mo. Maximum  @{{maxFilesize}}Mo',
            dictInvalidFileType: 'Type de fichier invalide. Acceptés : image, pdf, word',
            dictResponseError: 'Erreur interne. Essayez plus tard.',
            dictCancelUpload : 'Annuler',
            dictUploadCanceled : 'Annulé',
            dictCancelUploadConfirmation : 'Êtes-vous sûr ?',
            dictRemoveFile: 'Supprimer',
            dictRemoveFileConfirmation: 'Êtes-vous sûr ?',
            dictMaxFilesExceeded: 'Vous avez dépassé la limite de @{{maxFiles}} fichiers.'
        }"
        :duplicate-check="true"
        :use-custom-slot="true"
        @vdropzone-sending-multiple="onBeforeDocumentsUpload"
        @vdropzone-success-multiple="onSuccessDocumentsUpload"
        @vdropzone-removed-file="onRemoveUploadedDocument">

        <div class="dropzone-custom-content">
            <div class="subtitle">Cliquez ici pour déposer des fichiers</div>
            <h3 class="dropzone-custom-title">Vous pouvez également glisser-déposer</h3>
        </div>
    </vue-dropzone>
    <input type="hidden" name="documents_ids" :value="document.id" v-for="document in formInput.documents">
    <input type="hidden" name="documents" :value="JSON.stringify(formInput.documents)">

    <div>
        <p class="help is-danger" v-show="!$v.formInput.documents.onePdf">
            Vous ne pouvez déposer qu'un seul fichier PDF. Veuillez supprimer ceux que vous ne souhaitez pas conserver.
        </p>
        <p class="help is-danger" v-show="$v.formInput.documents.$error && !$v.formInput.documents.notCurrentlyUploading">
            Vous devez attendre la fin du téléversement de vos documents pour publier.
        </p>
    </div>
</div>
