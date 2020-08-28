@extends ('default')

@section ('title', "Confier mes terres")

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <section class="section">
        <div class="container">
            <div class="rows">
                <div class="row is-full">
                    <h1 class="title is-1 has_margin">Confier mes terres à TDL</h1>
                    <p>Faire un legs c’est avant tout et eget risus varius blandit sit amet non magna. Sed
                        posuere consectetur est at lobortis. Vestibulum id ligula porta felis euismod
                        semper. Duis mollis, est non commodo luctus, nisi erat porttitor ligula,
                    </p>
                </div>
                <div class="row is-full">
                    @if($pageContent->count())
                        @if($pageContent->has('confier-mes-terres-partager-son-patrimoine-de-don'))
                            {!! $pageContent['confier-mes-terres-partager-son-patrimoine-de-don']->content !!}
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('components.multiple-img-block')

    <section class="hero has_margin">
        <div class="hero-body block-video">
            @include('components.video')
        </div>
    </section>

    @if(! $cmsFaq->isEmpty())
        @include('components.faq-frequentes')
    @endif

    <section class="section contactus-background">
        <div class="container">
            <div class="rows">
                <div class="columns">
                    <div class="column is-9 block-tdl-contact">
                        <div class="row">
                            @if($pageContent->count())
                                @if($pageContent->has('confier-mes-terres-leguez-vos-terres-par-etape'))
                                    {!! $pageContent['confier-mes-terres-leguez-vos-terres-par-etape']->content !!}
                                @endif
                            @endif
                        </div>
                        <div class="row">
                            <button class="button is-link">CONTACTEZ-NOUS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('components/downloadPDF')

    @include('components.partnering')

    @include('components.support-terre-liens')


@endsection

@section('script')
    <script>
        console.log(thumb)
    </script>

@endsection

