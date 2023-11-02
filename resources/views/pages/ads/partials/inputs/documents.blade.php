@php
    $tooltip = "Les annonces avec photos sont en moyenne 3 fois plus consultées ! Nous vous recommandons fortement d'ajouter au moins 3 photos. 15Mo maximum par document"
@endphp
<b-tooltip class="w-100"
           label="{{$tooltip}}.">
    <label class="label is-inline-block"
           for="documents">
        Photos
        <i class="fas fa-info-circle has-text-info"></i><br>
        <span style="font-weight:normal">
            @if(!$isSupportRequest)
                La première image importée (JPG, GIF, PNG, ... ) sera l'image principale de votre annonce, les autres
                défileront en entête de votre annonce
                <br>Les fichier PDF et DOC seront affichés en pièces jointes.<br>
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
</b-tooltip>

<input type="hidden" :disabled="isInputDisabled" name="documents_ids[]" :value="document.id"
       v-for="document in formInput.documents">
<input type="hidden" :disabled="isInputDisabled" name="documents" :value="JSON.stringify(formInput.documents)">

<div>
    <p class="help is-danger" v-show="!$v.formInput.documents.oneDocument">
        Vous ne pouvez déposer qu'un seul fichier PDF ou Word. Veuillez supprimer ceux que vous ne souhaitez pas
        conserver.
    </p>
    <p class="help is-danger" v-show="$v.formInput.documents.$error && !$v.formInput.documents.notCurrentlyUploading">
        Vous devez attendre la fin du téléversement de vos documents pour publier.
    </p>
</div>
