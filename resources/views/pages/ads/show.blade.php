@extends('default')

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
	@if($ad->ad_type === 'jobAd')
		@include('pages.ads.partials.jobAd.jobAdShow')
	@endif

@endsection

@section('script')


	<script>

        let buttons = document.querySelectorAll('#open-modal-message');
        buttons.forEach((button)=>{
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('.modal');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');

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
            });
		})

		let deleteButton = document.querySelector('#close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display='none';

        })
	</script>
	<script src="{{asset('/js/bulma-carousel.js')}}"></script>
	<script>

        const carousel = bulmaCarousel.attach('#ad-images', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigation: true,
        });

        // Loop on each carousel initialized
        for(let i = 0; i < carousel.length; i++) {

            carousel[i].on('after:show', state => {
                console.log(carousel[i].slides)

            });
        }



	</script>


@endsection