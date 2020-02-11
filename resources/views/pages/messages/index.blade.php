@extends ('default')

@section ('title', 'Consulter la liste de vos messages')

@section('main-content')

	<div class="section">
		<div class="container ">
			<h1 class="title has-text-link">Bienvenue sur votre messagerie</h1>
			<div id="vue-messages">
				<vue-threads
						inline-template>
					<div class="columns">
						<div class="column is-one-quarter">
								<list-threads :values="{{json_encode($interlocutors)}}"></list-threads>
						</div>
						<div class="column box">
							<header-message></header-message>
							<display-message-content></display-message-content>
							<form-message-reply></form-message-reply>
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
