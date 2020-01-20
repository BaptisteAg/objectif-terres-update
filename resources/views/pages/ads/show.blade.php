@extends('default')

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')

	@isset($landSeekAd)
		@include('pages.ads.partials.land_seek_show')
	@endisset
	@isset($landOfferAd)
		@include('pages.ads.partials.land_offer_show')
	@endisset
	@isset($jobAd)
		@include('pages.ads.partials.job_ad_show')
	@endisset

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
	</script>
@endsection