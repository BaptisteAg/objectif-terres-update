@extends ('default')

<?php /** @var \App\Models\CmsPage $page */ ?>

@section ('title', $page->page_name)

@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    <div class="cms-page">
        <section class="">
            <div class="container mx-3-mobile">
                <div>
                    {!! $page->content !!}
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
