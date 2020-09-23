@extends('default')

@section('title', 'Foire aux questions | Objectif Terres')

@section('main-content')
    <div class="section cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('faq'))
                            {!! $pageContent['faq']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>


        {{--	@include('components.faqAccordion')--}}

        {{--	@include('components/downloadPDF')--}}

        {{--	@include('components/step-guide')--}}


    </div>
    @include('components.support-terre-liens')

@endsection

@section('script')
    <script src="{{ asset('js/bulma-accordion.js') }}"></script>
    <script>let accordions = bulmaAccordion.attach();</script>
@endsection