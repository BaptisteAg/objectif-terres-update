<template>
    <div>
        <div v-if="activeThreadId" class="content">
            <form @submit="formSubmit">
                <label id="reply-input-label" for="reply-input" class=" label has-text-black"> Répondre</label>
                <div class="field ">
                    <div v-bind:class="[isLoading ?'control is-expanded  has-icons-left is-loading ' : 'control is-expanded  has-icons-left']">
                        <input type="hidden" name="thread_id" :value="activeThreadId">
                        <textarea :disabled="isLoading" id="reply-input" v-model="content"
                                  class=" textarea has-fixed-size" name="content" type="text"
                                  placeholder="Votre message..."/>
                    </div>
                    <br>
                    <div class="field is-grouped">
                        <a class="">
                            <p class="control is-expanded text_primary has-text-underline"
                               v-on:click="openDocumentUpload = !openDocumentUpload" style="cursor: pointer">
										<span class="icon">
										<i class="fas fa-paperclip"></i>
									</span>
                                <span>Envoyer un fichier</span>
                            </p>
                        </a>

                    </div>
                    <div v-if="openDocumentUpload">
                        <documents-upload
                                name="documents"
                                type="message"
                                url="/mon-espace/messagerie/upload" :extra-data="{thread_id: this.activeThreadId }"
                                v-model="documents"
                                @uploading="setUploading"
                                ref="documents">
                        </documents-upload>
                        <div>
                            <p class="help is-danger"
                               v-show="$v.documents.$error && !$v.documents.notCurrentlyUploading">
                                Vous devez attendre la fin du téléversement de vos documents pour envoyer votre message.
                            </p>
                        </div>
                    </div>
                    <div v-if='showResponseType === false ' class="control ">
                        <button class="button basic primary form-button button-send-message">
						 <span class="icon is-small">
						  <i class="fas fa-paper-plane"></i>
						</span>
                            <span>Envoyer</span>
                        </button>
                    </div>
                </div>
                <div v-if="showResponseType">
                    <label class="label">Envoyer une réponse type</label>
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                        <span v-bind:class="[isLoading ?'select is-fullwidth is-loading ' : 'select is-fullwidth']">
                        <select :disabled="isLoading" v-model.trim="content">
                            <option disabled selected="selected">Choisissez votre réponse type...</option>
                            <option v-for="responseTemplate in responseTemplates">{{responseTemplate.content}}
                            </option>
                        </select>
                        </span>
                        </p>
                    </div>
                    <div class="field is-grouped">
                        <p class="control is-expanded">
                            <a href="/gestion-reponse-types">
										<span class="icon">
										<i class="fas fa-plus"></i>
									</span>
                                <span>Créer une nouvelle réponse type</span>
                            </a>
                        </p>
                    </div>
                    <br>
                    <p class="control ">
                        <button class="button basic form-button primary button-send-message" :disabled="isLoading">
						 <span class="icon is-small">
						  <i class="fas fa-paper-plane "></i>
						</span>
                            <span>Envoyer</span>
                        </button>
                    </p>
                </div>
            </form>
        </div>
    </div>

</template>

<script>
    import axios from 'axios';
    import DocumentsUpload from "../../../components/DocumentsUpload";

    export default {
        components: {
            DocumentsUpload
        },
        props: {
            responseTemplates: '',
            showResponseType: Boolean,
            activeThreadId: ''
        },
        data() {
            return {
                content: '',
                isLoading: false,
                documents: [],
                openDocumentUpload: false,
            }
        },
        watch: {
            documents: function () {
                if (this.documents.length > 0) {
                    setTimeout(() => {
                        this.$emit('on-upload-success', this.activeThreadId)
                        this.openDocumentUpload = false;
                        this.documents = [];
                    }, 1500)
                }
            }
        },
        methods: {
            formSubmit(e) {
                this.isLoading = true;
                e.preventDefault();
                axios.post('/mon-espace/messagerie/envoi', {
                    content: this.content,
                    thread_id: this.activeThreadId,
                })
                    .then(response => {
                        const message = response.data;
                        this.$emit('message-reply-success', message)
                        this.isLoading = false;
                        this.content = '';
                    })
                    .catch(error => {
                        console.log(error)
                    })
            },
            setUploading(bool) {
                this.isLoading = bool;
            },
        },
        validations() {
            return {
                documents: {
                    notCurrentlyUploading() {
                        return !this.isLoading;
                    }
                }
            }
        },
    }
</script>
