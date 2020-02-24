@extends ('default')

@section ('title', 'Consulter la liste de vos messages')

@section('main-content')

	<div class="section">
		<div class="container ">
			<h1 class="title has-text-link">Bienvenue sur votre messagerie</h1>
			@if(count($threads)===0)
				<div class="content">
					<p class="subtitle has-text-centered">Vous n'avez pas encore reçu de messages ! </p>
				</div>
				@if(auth()->user()->role >= 1 )
					<div id="vue-messages">
						<vue-threads inline-template>
							<div>
								<div class="columns is-centered is-mobile">
									<div class="column is-2">
										<button id="test" class="open-modal-new-message button is-link" type="button">
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
							v-bind:is-display-in-thread-page=true
							v-bind:is-user-ad-owner=false
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
											:threads="{{json_encode($threads)}}"
											:number-of-unread-messages="{{$numberOfUnreadMessages}}"
											v-model="messages"
											@on-thread-click="onThreadClick"
											@on-new-thread-click="onNewThreadClick"
											v-bind:is-display="isDisplay"
											v-bind:is-user-moderator="isUserModerator"
											v-bind:is-user-logged-ad-owner="isUserAdOwner"
											:user-id="{{auth()->id()}}"
									>
									</list-threads>

								</div>
								<div class="column box">
									<header-message
											v-bind:is-display="isDisplay"
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
											@message-reply-success="onMessageReplySuccess"
									>
									</form-message-reply>
								</div>
							</div>
							@include('pages.messages.partials.newMessageModal')
						</div>
					</vue-threads>
				</div>
			@endif
		</div>
	</div>

@endsection

@section('script')
	<script>
        const vueThreads = new Vue({
            el: '#vue-messages',
            name: 'content'
        });

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

        let deleteButton = document.querySelector('.close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';

        })
	</script>
@endsection
