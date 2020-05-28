@extends('default')

@section('title')
	{{ $ad->title }}
@endsection

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
	@if($ad->ad_type === 'landSeek')
		@include('pages.ads.partials.landSeek.landSeekShow')
	@endif
	@if($ad->ad_type === 'landOffer')
		@include('pages.ads.partials.landOffer.landOfferShow')
	@endif
	@if($ad->ad_type === 'jobOffer')
		@include('pages.ads.partials.jobOffer.jobOfferAdShow')
	@endif
	@if($ad->ad_type === 'jobSeek')
		@include('pages.ads.partials.jobSeek.jobSeekAdShow')
	@endif
@endsection

@section('script')
	<script>
		@if(auth()->user()->role>=1 )
        let buttons = document.querySelectorAll('#open-modal-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('div[data-type="modal-message"]');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');

                modal.querySelector('div[data-type="modal-message-background"]').addEventListener('click', function (e) {
                    e.preventDefault();
                    modal.classList.remove('is-active');
                    html.classList.remove('is-clipped');
                });
                modal.querySelector('#close-modal').addEventListener('click', function (e) {
                    e.preventDefault();
                    modal.classList.remove('is-active');
                    html.classList.remove('is-clipped');
                });
            });
        });

        let deleteButton = document.querySelector('.close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';

        })
		@endif

		@if(auth()->user()->role>=1)
        function showValidationSupervisorModal() {
            let validationModal = document.querySelector('#modal-supervisor-validation');
            let html = document.querySelector('html');
            let listAdvisorUsers = document.getElementById("list_advisor_users");
            let advisorUserSelected = listAdvisorUsers.options[listAdvisorUsers.selectedIndex].text;
            let spanAdvisorSelected = document.querySelector('#user_advisor_selected');
            spanAdvisorSelected.innerHTML = advisorUserSelected;
            validationModal.classList.add('is-active');
            html.classList.add('is-clipped');

            validationModal.querySelector('#modal-supervisor-validation-background').addEventListener('click', function (e) {
                e.preventDefault();
                validationModal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
            validationModal.querySelector('#close-modal').addEventListener('click', function (e) {
                e.preventDefault();
                validationModal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
        }

		@endif

        function sendResponseTemplateMessage() {
            let listResponseTemplates = document.getElementById("response_templates_list");
            let responseTemplateSelected = listResponseTemplates.options[listResponseTemplates.selectedIndex].text;
            let textareaMessage = document.querySelector('#textearea_message');
            console.log(textareaMessage);
            textareaMessage.value = responseTemplateSelected;
        }

	</script>
	@if(count($ad->images) > 1)
		<script src="{{asset('/js/bulma-carousel.js')}}"></script>
		<script>
            const carousel = bulmaCarousel.attach('#ad-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigation: true,
            });
		</script>
	@endif

	<script>
        const vueThreads = new Vue({
            el: '#vue-messages',
            name: 'content'
        });
		@if(auth()->user()->role >= 1 and !$ad->project()->exists())
			const VueModerationModal = new Vue({
					el: "#vue-moderation-modal",
					name: 'content'
				})
		@endif
	</script>
@endsection