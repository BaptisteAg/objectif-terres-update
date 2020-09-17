@extends('default')

@section('title', 'Foire aux questions | Objectif Terres')

@section('main-content')
<div class="section cms-page">
	@include('components.faqAccordion')

	@include('components/downloadPDF')

	@include('components/step-guide')

	@include('components.partnering')

	@include('components.support-terre-liens')
</div>


@endsection

@section('script')
	<script src="{{ asset('js/bulma-accordion.js') }}"></script>
	<script>let accordions = bulmaAccordion.attach();</script>
@endsection