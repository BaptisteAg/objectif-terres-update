@extends('default')

@section('title', 'Foire aux questions | Objectif Terres')

@section('main-content')

	@include('components.faqAccordion')

	@include('components/downloadPDF')

	@include('components/step-guide')

	@include('components.partnering')

	@include('components.support-terre-liens')

@endsection

@section('script')
	<script src="{{ asset('js/bulma-accordion.js') }}"></script>
	<script>let accordions = bulmaAccordion.attach();</script>
@endsection