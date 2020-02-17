<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="15mo maximum par document. Un seul PDF est autorisé. Formats acceptés : .pdf, .doc, .docx, .jpg, .png">
        Documents
        <i class="fas fa-info-circle has-text-info"></i><br>
        <span style="font-weight:normal">
            Ajoutez des photos ou un document PDF pour donner envie de consulter votre annonce.<br>
        </span>
    </label>

    <documents-upload
            name="documents"
            v-model="formInput.documents"
            @uploading="setUploading"
            ref="documents">
    </documents-upload>

    <input type="hidden" name="documents_ids[]" :value="document.id" v-for="document in formInput.documents">
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