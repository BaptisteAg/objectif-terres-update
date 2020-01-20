@extends('default')

@section('title', 'Titre de l\'annonce')


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