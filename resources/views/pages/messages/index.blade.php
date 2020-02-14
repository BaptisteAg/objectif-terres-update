@extends ('default')

@section ('title', 'Consulter la liste de vos messages')

@section('main-content')

	<div class="section">
		<div class="container ">
			<h1 class="title has-text-link">Bienvenue sur votre messagerie</h1>
			<div id="vue-messages">
				<vue-threads
						inline-template
						init-thread='{{ $threads[0]->id }}'
						user-logged-id="{{auth()->id()}}"
				>
					<div class="columns">
						<div class="column is-one-quarter">



							<list-threads
									:threads="{{json_encode($threads)}}"
									:number-of-unread-messages ="{{$numberOfUnreadMessages}}"
									v-model="messages"
									@on-thread-click="onThreadClick"
							>
							</list-threads>
						</div>
						<div class="column box">
							<header-message
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
				</vue-threads>
			</div>
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
