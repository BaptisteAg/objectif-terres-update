<template>
    <div v-if="!isThreadBlocked">
        <div v-if="activeThreadId" class="content">
            <div v-if="isThreadRelatedToUser">
                <form @submit="formSubmit"><label id="reply-input-label" for="reply-input"
                                                  class=" label has-text-black"> Répondre</label>
                    <div class="field ">
                        <div v-bind:class="[isLoading ?'control is-expanded  has-icons-left is-loading ' : 'control is-expanded  has-icons-left']">
                            <input type="hidden" name="thread_id" :value="activeThreadId">
                            <vue-editor
                                    :disabled="isLoading"
                                    id="reply-input"
                                    v-model="content"
                                    name="content"
                                    type="text"
                                    placeholder="Votre message..."
                                    :editorToolbar='[["bold", "underline"],[{ list: "ordered" }, { list: "bullet" }],["link", "image"]]'/>
                        </div>
                        <br>
                        <div class="field is-grouped"><a class=""><p
                                class="control is-expanded text_primary has-text-underline"
                                v-on:click="openDocumentUpload = !openDocumentUpload" style="cursor: pointer"><span
                                class="icon"> <i class="fas fa-paperclip"></i> </span> <span>Envoyer un fichier</span>
                        </p></a></div>
                        <div v-if="openDocumentUpload">
                            <documents-upload name="documents"
                                              type="message"
                                              url="/documents/upload"
                                              :extra-data="{thread_id: this.activeThreadId }"
                                              v-model="documents"
                                              ref="documents">

                            </documents-upload>
                            <div><p class="help is-danger"
                                    v-show="$v.documents?.$error && !$v.documents.notCurrentlyUploading"> Vous devez
                                attendre la fin du téléversement de vos documents pour envoyer votre message. </p></div>
                        </div>
                        <div v-if='showResponseTemplates === false ' class="control ">
                            <button class="button basic primary form-button button-send-message"><span
                                    class="icon is-small"> <i class="fas fa-paper-plane"></i> </span>
                                <span>Envoyer</span></button>
                        </div>
                    </div>
                    <div v-if="showResponseTemplates"><label class="label">Envoyer un message type</label>
                        <div class="field is-grouped">
                            <p class="control is-expanded"><span
                                    v-bind:class="[isLoading ?'select is-fullwidth is-loading ' : 'select is-fullwidth']">
                                <select :disabled="isLoading" v-model.trim="content">
                                    <option disabled selected="selected">Choisissez votre message type...</option>
                                    <option v-for="responseTemplate in responseTemplates" v-bind:value="responseTemplate.content">{{responseTemplate.title}}
                                    </option>
                                </select>
                            </span>
                            </p>
                        </div>

                        <div v-if="showLinkNewResponseTemplate" class="field is-grouped">
                            <p class="control is-expanded">
                                <a href="/gestion-reponse-types">
                                    <span class="icon">
                                        <i class="fas fa-plus"></i>
                                    </span>
                                    <span>Créer un nouveau message type</span>
                                </a>
                            </p>
                        </div>
                        <br>
                        <p class="control  content-send-message-button ">
                            <button class="button basic form-button primary button-send-message" :disabled="isLoading">
                                <span class="icon is-small"> <i class="fas fa-paper-plane "></i> </span>
                                <span>Envoyer</span></button>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';
    import DocumentsUpload from "../../../components/DocumentsUpload";
    import { VueEditor } from "vue2-editor";

    export default {
        components: {DocumentsUpload},
        props: {
            value: {},
            responseTemplates: '',
            userRole: '',
            activeThreadId: '',
            userId: "",
            isThreadRelatedToUser: Boolean,
            isThreadBlocked: Boolean,
        },
        data() {
            return {
                content: '',
                isLoading: false,
                documents: [],
                openDocumentUpload: false,
                showResponseTemplates: this.userRole >= 1,
                showLinkNewResponseTemplate: this.userRole >= 3,
            }
        },
        mounted() {
        },
        methods: {
            formSubmit(e) {
                e.preventDefault();
                if (this.documents.length > 0 || this.content) {
                    this.isLoading = true;
                    if (this.documents.length > 0) {
                        axios.post('/mon-espace/messagerie/upload', {
                            files: this.documents,
                            thread_id: this.activeThreadId,
                        }).then(response => {
                            this.documents = [];
                            this.openDocumentUpload = false;
                            this.$emit('on-upload-success', this.activeThreadId)
                            this.isLoading = false;
                        }).catch(error => {
                            console.log(error)
                        })
                    }
                    if (this.content) {
                        axios.post('/mon-espace/messagerie/envoi', {
                            content: this.content,
                            thread_id: this.activeThreadId,
                        }).then(response => {
                            const message = response.data;
                            this.$emit('message-reply-success', message)
                            this.content = '';
                            this.documents = [];
                            this.isLoading = false;
                        }).catch(error => {
                            console.log(error)
                        })
                    }
                }
            }, setUploading(bool) {
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
    } </script>

