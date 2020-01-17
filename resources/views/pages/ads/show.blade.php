@extends('default')

@section('title', 'Titre de l\'annonce')


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