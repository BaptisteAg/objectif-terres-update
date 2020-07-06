<template>
    <vue-dropzone
            :id="'dropzone' + _uid"
            ref="dropzone"
            :options="{
                url: this.url,
                thumbnailWidth: 150,
                maxFiles: 15,
                maxFilesize: 15,
                addRemoveLinks: true,
                uploadMultiple: true,
                acceptedFiles: 'image/*, .pdf, .doc, .docx',
                dictFileTooBig: 'Fichier trop volumineux: {{filesize}}Mo. Maximum  {{maxFilesize}}Mo',
                dictInvalidFileType: 'Type de fichier invalide. Acceptés : image, pdf, word',
                dictResponseError: 'Erreur interne. Essayez plus tard.',
                dictCancelUpload : 'Annuler',
                dictUploadCanceled : 'Annulé',
                dictCancelUploadConfirmation : 'Êtes-vous sûr·e ?',
                dictRemoveFile: 'Supprimer',
                dictRemoveFileConfirmation: 'Êtes-vous sûr·e ?',
                dictMaxFilesExceeded: 'Vous avez dépassé la limite de {{maxFiles}} fichiers.'
            }"
            :duplicate-check="true"
            :use-custom-slot="true"
            @vdropzone-sending-multiple="onBeforeDocumentsUpload"
            @vdropzone-success-multiple="onSuccessDocumentsUpload"
            @vdropzone-removed-file="onRemoveUploadedDocument">

        <div class="dropzone-custom-content">
            <div class="text_primary"><i class='fas fa-cloud'></i> Cliquez ici pour déposer des fichiers</div>
            <h3 class="dropzone-custom-title">Vous pouvez également glisser-déposer</h3>
        </div>
    </vue-dropzone>
</template>


<script>
    import vue2Dropzone from 'vue2-dropzone'
    import 'vue2-dropzone/dist/vue2Dropzone.min.css'

    export default {
        components: {
            vueDropzone: vue2Dropzone
        },
        props: {
            value: {
                type: Array,
                required: true
            },
            name: {
                type: String,
                required: true
            },
            url: String,
            type : String,
            extraData: {
                type: Object,
                default: _ => {}
            }
        },
        data() {
            return {}
        },
        mounted() {
            // Initiate correctly existing documents
            if (Array.isArray(this.value) && this.value.length) {
                const dropzone = this.getDropzone();

                // Dropzone requirements for file object properties are the same as DB document object definition
                this.value.forEach(document => {
                    dropzone.emit("addedfile", document);
                    if(document.type.indexOf("image") === 0) {
                        dropzone.emit("thumbnail", document, '/'+document.path);
                    }
                    dropzone.emit("complete", document);
                })
            }
        },
        methods: {
            getDropzone() {
                return this.$refs.dropzone.$refs.dropzoneElement.dropzone
            },
            /**
             * Handler for dropzone event, before documents are uploaded
             */
            onBeforeDocumentsUpload(files, xhr, formData) {
                formData.append('_token', window.csrf_token);
                formData.append('type', this.type);

                if(this.extraData) {
                    _.forEach(this.extraData, (value, key) => {
                        formData.append(key, value);
                    })
                }

                this.$emit('uploading', true);
            },
            /**
             * Set inputs border color ( red or initial ) based on error status
             */
            onSuccessDocumentsUpload(files, documents) {
                if (documents.length) {
                    this.$emit('input', this.value.concat(documents));

                }
                this.$emit('uploading', false);
            },
            /**
             *  Removes the file from the list of documents.
             *  Be careful, those are not the same object types.
             *  Thats why we have to compare both name and size instead of id.
             *
             * @param {File} removedFile
             */
            onRemoveUploadedDocument(removedFile) {
                this.$emit('input', this.value.filter(document =>
                    document.name !== removedFile.name && document.name !== removedFile.size
                ));
            }
        }
    }
</script>