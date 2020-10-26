
@extends ('default')

@section ('title', "Trouver un emploi")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class=" cms-page">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Trouver un emploi</h1>
                    @if($pageContent->count())
                        @if($pageContent->has('trouver-un-emploi-texte-dintroduction-sous-le-titre-principal-et-votre-plateforme-agricole'))
                            {!! $pageContent['trouver-un-emploi-texte-dintroduction-sous-le-titre-principal-et-votre-plateforme-agricole']->content !!}
                        @endif
                    @endif
            </div>
        </div>
    </section>

    @include('components.multiple-img-block')

    <section class="">
        <div class="container block-numbers">
            <div class="container has-text-centered">
                <div class="rows">
                    <div class="row is-full">
                        @if($pageContent->count())
                            @if($pageContent->has('trouver-un-emploi-texte-sous-le-bloc-dimages'))
                                {!! $pageContent['trouver-un-emploi-texte-sous-le-bloc-dimages']->content !!}
                            @endif
                        @endif
                    </div>
                    @include('components/number-circle-percent')
                </div>
            </div>
        </div>
    </section>

    <section class="hero has_margin">
        <div class="hero-body block-video">
            @include('components.video')
        </div>
    </section>

    @if(! $cmsFaq->isEmpty())
        @include('components.faq-frequentes')
    @endif

    <section class=" contactus-background">
        <div class="container">
            <div class="columns">
                <div class="column is-6">
                    @if($pageContent->count())
                        @if($pageContent->has('trouver-un-emploi-avez-vous-besoin-dun-conseil-demploi'))
                            {!! $pageContent['trouver-un-emploi-avez-vous-besoin-dun-conseil-demploi']->content !!}
                        @endif
                    @endif
                </div>
                <div class="column is-6 contactUs-button">
                    <button class="button is-link">CONTACTEZ-NOUS</button>
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

    @include('components/step-guide')

    @include('components.partnering')

    @include('components.support-terre-liens')





@endsection
