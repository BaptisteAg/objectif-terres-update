<div class="card-content">
	<div class="content">
		<div class="columns is-vcentered " v-if="initialLoading === true">
			<div class="column is-7">
				<div id="loading" class="is-pulled-right">
				</div>
			</div>
		</div>
		<div class="columns" v-else-if="initialLoading === false">
			<div class="column  ">
				<display-message-content
						v-model="messages"
						:user-id="{{auth()->id()}}"
				></display-message-content>
				<form-message-reply
						v-model="messages"
						v-bind:active-thread-id = "activeThread"
						:user-id="{{auth()->id()}}"
						@message-reply-success="onMessageReplySuccess"
						:show-response-type="true"
						:response-templates="{{json_encode($responseTemplates)}}"
				>
				</form-message-reply>
			</div>
		</div>
	</div>
</div>
