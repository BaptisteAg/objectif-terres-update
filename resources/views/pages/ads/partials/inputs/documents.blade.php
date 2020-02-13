<div class="field">
    <span>Une photo de vous ? Une synthèse de votre projet ? Les photos sont importantes pour donner envie de consulter votre annonce.</span>

    <vue-dropzone
            ref="documents"
            id="dropzone"
            :options="{
                        url: '/documents/upload',
                        thumbnailWidth: 150,
                        maxFiles: 5,
                        maxFilesize: 1,
                        addRemoveLinks: true,
                        uploadMultiple: true,
                        acceptedFiles: 'image/*, application/pdf, text/*, application/msword, application/vnd.ms-excel, application/zip'
                    }"
            :duplicate-check="true"
            :use-custom-slot="true"
            @vdropzone-sending-multiple="onBeforeDocumentsUpload"
            @vdropzone-success-multiple="onSuccessDocumentsUpload">

        <div class="dropzone-custom-content">
            <div class="subtitle">Cliquez ici pour déposer des fichiers</div>
            <h3 class="dropzone-custom-title">Vous pouvez également glisser-déposer</h3>
        </div>
    </vue-dropzone>
    <input type="hidden" name="documents" :value="id" v-for="id in formInput.documents">
</div>