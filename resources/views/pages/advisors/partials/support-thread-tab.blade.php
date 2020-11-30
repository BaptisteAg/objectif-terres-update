<div class="card-content pt-0">
    <div v-if="activeThreadId !== null" class="content">
        <div v-if="! userAdvisorInCharge">
            <div class="notification is-info is-light mb-30">
                Vous consultez le fil de discussion entre le porteur de projet et son primo-accueillant en charge de la demande d'accompagnement !
            </div>
        </div>
        <div class="columns is-vcentered " v-if="initialLoading === true">
            <div class="column is-7">
                <div id="loading" class="is-pulled-right">
                </div>
            </div>
        </div>
        <div class="columns" v-else-if="initialLoading === false">
            <div class="column">
                <display-message-content
                        v-model="messages"
                        :user-id="{{auth()->id()}}"
                ></display-message-content>
                @if(! $ad->userPp->trashed())
                    <form-message-reply
                            v-model="messages"
                            :active-thread-id="activeThreadId"
                            :user-id="{{auth()->id()}}"
                            @message-reply-success="onMessageReplySuccess"
                            @on-upload-success="refreshThread"
                            :user-role="{{auth()->user()->role}}"
                            :response-templates="{{json_encode($responseTemplates)}}"
                            :is-thread-related-to-user="isThreadRelatedToUser"
                    >
                    </form-message-reply>
                @endif
            </div>
        </div>
    </div>
    <div v-else>
        <p class="has-text-centered">Aucun message n'a été encore envoyé entre le porteur de projet et son
            primo-accueillant.</p>
    </div>
</div>
