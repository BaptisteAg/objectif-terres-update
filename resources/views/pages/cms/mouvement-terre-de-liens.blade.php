@extends ('default')

@section ('title', 'Qui sommes nous ?')

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <div class="cms-page">
        <section class="">
            <div id="a-propos-d-objectif-terres" class="container mx-3-mobile">
                <div>
                    @if($pageContent->count())
                        {!! $pageContent['mouvement-terre-de-liens']->content !!}
                    @endif
                </div>
            </div>
        </section>
@endsection

@section('script')
    <script>
        let links = document.querySelector('.cms-page').querySelectorAll('a')
        links.forEach((link) => {
            link.setAttribute('target', '_blank');
        })
    </script>
@endsection
