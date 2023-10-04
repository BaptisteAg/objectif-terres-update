@auth
    @if( $ad->user_pp_id !== auth()->user()->id)
        @if(sizeof($threads) == 0)
            @if(auth()->user()->role < 1)

                <p class="has-text-centered is-size-4">Vous souhaitez répondre à cette
                    annonce
                    ?</p>
                <button id="open-modal-message-bottom-page"
                        class="button is-link  is-large open-modal-message" type="button">
                                                <span class="icon is-small">
                                                    <i class="fas fa-reply"></i>
                                                </span>
                    <span> Répondre à l'annonce</span>
                </button>

            @endif
        @else
            <div id="vue-messages">
                @if(auth()->user()->role >= 1)
                    <div id="messages-display" class="content">
                        <h3 class="title is-3 has-text-link has-text-centered"> Fils de discussion </h3>
                    </div>
                    <div>
                        <vue-threads
                                inline-template
                                :is-display-in-thread-page=false
                                :is-user-ad-owner=false
                                init-thread='{{ $threads[0]->id }}'
                                :user-id="{{auth()->id()}}"
                                :user-role="{{auth()->user()->role}}"
                        >
                            <div>
                                <div class="columns is-vcentered " v-if="initialLoading === true">
                                    <div class="column is-7 ">
                                        <div id="loading" class="is-pulled-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="columns" v-else-if="initialLoading === false">
                                    <list-threads
                                            v-model="messages"
                                            :threads="{{json_encode($threads)}}"
                                            :number-of-unread-messages="0"
                                            :threads-with-unread-messages="{{$threadsWithUnreadMessages}}"
                                            :user-role="userRole"
                                            :is-display="isDisplay"
                                            :is-user-logged-ad-owner="isUserAdOwner"
                                            :user-id="{{auth()->id()}}"
                                            :active-thread="activeThreadId"
                                            @on-thread-click="onThreadClick"
                                    >
                                    </list-threads>
                                    <div class="column box ">
                                        <display-message-content
                                                v-model="messages"
                                                :user-id="{{auth()->id()}}"
                                        ></display-message-content>

                                        <form-message-reply
                                                v-model="messages"
                                                :user-id="{{auth()->id()}}"
                                                :user-role="userRole"
                                                :active-thread-id="activeThreadId"
                                                :is-thread-related-to-user="isThreadRelatedToUser"
                                                :is-thread-blocked="isThreadBlocked"
                                                :show-response-type="true"
                                                :response-templates="{{json_encode($responseTemplates)}}"
                                                @message-reply-success="onMessageReplySuccess"
                                                @on-upload-success="onThreadClick"
                                        >
                                        </form-message-reply>
                                    </div>
                                </div>
                            </div>
                        </vue-threads>
                    </div>

                @else
                    <div id="messages-display" class="content">
                        <h3 class=" title is-3 has-text-link has-text-centered">Votre fil de discusion </h3>
                    </div>
                    <div>
                        <vue-threads
                                inline-template
                                :is-display-in-thread-page=false
                                :is-user-ad-owner=false
                                init-thread='{{ $threads[0]->id }}'
                                :user-id="{{auth()->id()}}"
                                :user-role="{{auth()->user()->role}}"
                        >
                            <div>
                                <div class="columns is-vcentered " v-if="initialLoading === true">
                                    <div class="column is-7">
                                        <div id="loading" class="is-pulled-right">
                                        </div>
                                    </div>
                                </div>
                                <div class="columns" v-else-if="initialLoading === false">
                                    <div v-if="isUserAdOwner">
                                        <list-threads
                                                :threads="{{json_encode($threads)}}"
                                                :number-of-unread-messages="0"
                                                v-model="messages"
                                                :is-display="isDisplay"
                                                :is-user-logged-ad-owner="isUserAdOwner"
                                                :user-id="{{auth()->id()}}"
                                                :active-thread="activeThreadId"
                                                @on-thread-click="onThreadClick"

                                        >
                                        </list-threads>
                                    </div>
                                    <div class="column box ">
                                        <header-message
                                                :is-display="isDisplay"
                                                v-model="messages"
                                                :user-id="{{auth()->id()}}"
                                                :active-thread-id="activeThreadId"
                                                :active-thread="activeThread"
                                        ></header-message>
                                        <display-message-content
                                                v-model="messages"
                                                :user-id="{{auth()->id()}}"
                                        ></display-message-content>
                                        <form-message-reply
                                                v-model="messages"
                                                :user-id="{{auth()->id()}}"
                                                @message-reply-success="onMessageReplySuccess"
                                                @on-upload-success="onThreadClick"
                                                :user-role="userRole"
                                                :active-thread-id="activeThreadId"
                                                :show-response-type="false"
                                                :response-templates="{{json_encode($responseTemplates)}}"
                                                :is-thread-related-to-user="isThreadRelatedToUser"
                                                :is-thread-blocked="isThreadBlocked"
                                        >
                                        </form-message-reply>
                                    </div>
                                </div>
                            </div>

                        </vue-threads>
                    </div>
            </div>
        @endif
    @endif
@else
    @if(sizeof($threads) <= 0)
        <div class="content">
            <div class="columns is-mobile is-centered">
                <div class="column is-half">
                    <div class="box has-background-white-ter ">
                        <article class="media">
                            <div class="media-content">
                                <div class="content has-text-centered ">
                                    <p class="has-text-centered is-size-4">Vous n'avez pas encore reçu de
                                        messages</p>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div id="vue-messages">
            <div id="messages-display" class="content">
                <h3 class="title is-3 has-text-link has-text-centered">Vos messages reçus </h3>
            </div>
            <div>
                <vue-threads
                        inline-template
                        :is-display-in-thread-page=false
                        :is-user-ad-owner=true
                        init-thread='{{ $threads[0]->id }}'
                        :user-id="{{auth()->id()}}"
                >
                    <div>
                        <div class="columns is-vcentered " v-if="initialLoading === true">
                            <div class="column is-7 ">
                                <div id="loading" class="is-pulled-right">
                                </div>
                            </div>
                        </div>
                        <div class="columns" v-else-if="initialLoading === false">
                            <div v-if="isUserAdOwner">
                                <list-threads
                                        :threads="{{json_encode($threads)}}"
                                        :number-of-unread-messages="0"
                                        :threads-with-unread-messages="{{$threadsWithUnreadMessages}}"
                                        v-model="messages"
                                        :is-display="isDisplay"
                                        :is-user-logged-ad-owner="isUserAdOwner"
                                        :user-id="{{auth()->id()}}"
                                        :active-thread="activeThreadId"
                                        @on-thread-click="onThreadClick"
                                >
                                </list-threads>
                            </div>
                            <div class="column box ">
                                <header-message
                                        :is-display="isDisplay"
                                        v-model="messages"
                                        :user-id="{{auth()->id()}}"
                                        :active-thread-id="activeThreadId"
                                        :active-thread="activeThread"
                                ></header-message>
                                <display-message-content
                                        v-model="messages"
                                        :user-id="{{auth()->id()}}"
                                ></display-message-content>
                                <form-message-reply
                                        v-model="messages"
                                        :user-id="{{auth()->id()}}"
                                        @on-upload-success="onMessageReplySuccess"
                                        @on-thread-click="onThreadClick"
                                        :active-thread-id="activeThreadId"
                                        :is-thread-related-to-user="isThreadRelatedToUser"
                                        :is-thread-blocked="isThreadBlocked"
                                >
                                </form-message-reply>
                            </div>
                        </div>
                    </div>
                </vue-threads>
            </div>
        </div>
    @endif
@endif
@else
    <div id="messages-display" class="content">
        <p class="has-text-centered is-size-4">Vous souhaitez répondre à cette
            annonce
            ?</p>
        <button id="open-modal-message-bottom-page"
                class="button is-link  is-large open-modal-message">
                                    <span class="icon is-small">
                                        <i class="fas fa-reply"></i>
                                    </span>
            <span> Répondre à l'annonce</span>
        </button>
    </div>
@endauth

