@extends ('default')

@section ('title', 'Consulter la liste de vos messages')

@section('main-content')
    @auth
        @if(auth()->user()->role >=3)
            @include('components.supervisor-tabs')
        @elseif(auth()->user()->role ===2)
            @include('components.advisor-tabs')
        @elseif(auth()->user()->role === 1)
            @include('components.moderator-tabs')
        @endif
    @endauth
    <div class="container mt-5">
        <h1 class="title is-4">Bienvenue sur votre messagerie</h1>
        @if(count($threads)===0)
            <div class="content">
                <p class="page__subtitle has-text-centered">Vous n'avez pas encore reçu de message !</p>
            </div>
            @if(auth()->user()->role >= 1 )
                <div id="vue-messages">
                    <vue-threads inline-template>
                        <div>
                            <div class="columns is-centered is-mobile">
                                <div class="column is-2">
                                    <button class="open-modal-new-message button basic primary" type="button">
                                            <span class="icon is-small">
                                                <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                            </span>
                                        <span> Envoyer un message</span>
                                    </button>
                                </div>
                            </div>
                            @include('pages.messages.partials.newMessageModal')
                        </div>
                    </vue-threads>
                </div>
            @endif
        @else
            <div id="vue-messages">
                <vue-threads
                        inline-template
                        init-thread='{{ $threads[0]->id }}'
                        :user-role="{{auth()->user()->role}}"
                        :is-display-in-thread-page=true
                        :is-user-ad-owner=false
                        :user-id="{{auth()->id()}}"
                >
                    <div>
                        <div class="columns is-vcentered " v-if="initialLoading === true">
                            <div class="column is-7 ">
                                <div id="loading" class="is-pulled-right">
                                </div>
                            </div>
                        </div>
                        <div class="columns" v-if="initialLoading === false">
                            <div class="column is-one-quarter">
                                <list-threads
                                        v-model="messages"
                                        :threads="{{json_encode((object)$threads)}}"
                                        :number-of-threads-with-unread-messages="{{$threadsWithUnreadMessages->count()}}"
                                        :threads-with-unread-messages="{{$threadsWithUnreadMessages}}"
                                        :is-display="isDisplay"
                                        :user-role="userRole"
                                        :user-id="{{auth()->id()}}"
                                        :active-thread="activeThreadId"
                                        @on-thread-click="onThreadClick"
                                        @on-new-thread-click="onNewThreadClick"
                                >
                                </list-threads>
                            </div>
                            <div class="column  box-thread-display">
                                <div class="box">
                                    <header-message
                                            :active-thread-id="activeThreadId"
                                            :active-thread="activeThread"
                                            :is-display="isDisplay"
                                            v-model="messages"
                                            :user-id="{{auth()->id()}}"
                                    ></header-message>
                                    <display-message-content
                                            v-model="messages"
                                            :user-id="{{auth()->id()}}"
                                    ></display-message-content>
                                    <form-message-reply
                                            v-model="messages"
                                            :user-id="{{auth()->id()}}"
                                            :response-templates="{{json_encode($responseTemplates)}}"
                                            :user-role="userRole"
                                            :active-thread-id="activeThreadId"
                                            :is-thread-related-to-user="isThreadRelatedToUser"
                                            :is-thread-blocked="isThreadBlocked"
                                            @message-reply-success="onMessageReplySuccess"
                                            @on-upload-success="onThreadClick"
                                    >
                                    </form-message-reply>
                                </div>
                            </div>
                        </div>
                        @include('pages.messages.partials.newMessageModal')
                    </div>
                </vue-threads>
            </div>
        @endif
    </div>

@endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/@editorjs/editorjs@latest"></script>
    <script>
        let buttons = document.querySelectorAll('.open-modal-new-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('.modal');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');
            });
        });
        let modal = document.querySelector('.modal');
        let html = document.querySelector('html');
        modal.querySelector('.modal-background').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });
        modal.querySelector('#close-modal').addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('is-active');
            html.classList.remove('is-clipped');
        });

    </script>
@endsection
