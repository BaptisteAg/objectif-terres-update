@extends('default')

@section('title', 'Foire aux questions | Objectif Terres')

@section('main-content')
    <section class="container px-2-mobile mb-4 old">
        @if($pageContent->count())
            @if($pageContent->has('faq'))
                {!! $pageContent['faq']->content !!}
            @endif
        @endif
    </section>


    {{--	@include('components.faqAccordion')--}}

    {{--	@include('components/downloadPDF')--}}

    {{--	@include('components/step-guide')--}}


    {{-- @include('components.support-terre-liens') --}}

@endsection

@section('script')
    <script src="{{ asset('js/bulma-accordion.js') }}"></script>
    <script>let accordions = bulmaAccordion.attach();</script>
@endsection
