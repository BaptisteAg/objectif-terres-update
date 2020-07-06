<div class="field">
    <label class="label is-inline-block has-tooltip-multiline has-tooltip-left"
           data-tooltip="15Mo maximum par document. {{ $isSupportRequest ? '' : 'Un seul document de type PDF, DOC ou DOCX est autorisé' }}">
        Documents
        <i class="fas fa-info-circle has-text-info"></i><br>
        <span style="font-weight:normal">
            @if(!$isSupportRequest)
                Ajoutez des photos ou un document PDF ou DOC pour donner envie de consulter votre annonce.<br>
            @else
                Ajoutez des photos ou un document PDF ou DOC qui nous aideraient à comprendre votre projet.<br>
            @endif
        </span>
    </label>

    <documents-upload
            name="documents"
            type="ads"
            url='/documents/upload'
            v-model="formInput.documents"
            @uploading="setUploading"
            ref="documents">
    </documents-upload>

    <input type="hidden" :disabled="isInputDisabled" name="documents_ids[]" :value="document.id" v-for="document in formInput.documents">
    <input type="hidden" :disabled="isInputDisabled" name="documents" :value="JSON.stringify(formInput.documents)">

    <div>
        <p class="help is-danger" v-show="!$v.formInput.documents.oneDocument">
            Vous ne pouvez déposer qu'un seul fichier PDF ou Word. Veuillez supprimer ceux que vous ne souhaitez pas conserver.
        </p>
        <p class="help is-danger" v-show="$v.formInput.documents.$error && !$v.formInput.documents.notCurrentlyUploading">
            Vous devez attendre la fin du téléversement de vos documents pour publier.
        </p>
    </div>
</div>