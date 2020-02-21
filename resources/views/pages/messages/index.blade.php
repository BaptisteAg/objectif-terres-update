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
			@else
				<div id="vue-messages">
					<vue-threads
							inline-template
							init-thread='{{ $threads[0]->id }}'
							:user-logged-id="{{auth()->id()}}"
							v-bind:is-display-in-thread-page=true
							v-bind:is-user-ad-owner=false
					>
						<div>
							<div class="columns is-vcentered " v-if="initialLoading === true">
								<div  class="column is-7 ">
									<div id="loading" class="is-pulled-right">
									</div>
								</div>
							</div>
							<div class="columns" v-if="initialLoading === false">
								<div  class="column is-one-quarter">
									<list-threads
											:threads="{{json_encode($threads)}}"
											:number-of-unread-messages="{{$numberOfUnreadMessages}}"
											v-model="messages"
											@on-thread-click="onThreadClick"
											v-bind:is-display="isDisplay"
											v-bind:is-user-logged-ad-owner="isUserAdOwner"
											:user-id="{{auth()->id()}}"
									>
									</list-threads>
								</div>
								<div class="column box ">
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

	</script>
@endsection
