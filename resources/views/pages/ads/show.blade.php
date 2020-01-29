@extends('default')

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')
	@if($ad->ad_type === 'land_seek')
		@include('pages.ads.partials.land_seek.land_seek_show')
	@endif
	@if($ad->ad_type === 'land_offer')
		@include('pages.ads.partials.land_offer.land_offer_show')
	@endif
	@if($ad->ad_type === 'job_ad')
		@include('pages.ads.partials.job_ad.job_ad_show')
	@endif

@endsection

@section('script')
	<script src="{{asset('/js/bulma-carousel.js')}}"></script>

	<script>
        bulmaCarousel.attach('#ad_images', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigation: true,
        });

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

@endsection