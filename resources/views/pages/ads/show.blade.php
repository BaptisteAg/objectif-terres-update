@extends('default')

@section('head-script')
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection


@section('main-content')
	@if($ad->ad_type === 'land_seek')
		@include('pages.ads.partials.land_seek_show')
	@endif
	@if($ad->ad_type === 'land_offer')
		@include('pages.ads.partials.land_offer_show')
	@endif
	@if($ad->ad_type === 'job_ad')
		@include('pages.ads.partials.job_ad_show')
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
	</script>

@endsection