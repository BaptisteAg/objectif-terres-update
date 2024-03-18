@extends ('default')

@section ('title', "Charte Objectif Terres")

@section('main-content')
    <section class="section cms-page">
        <div>
            <h1 class="page__title has-text-centered title is-3 pb-6">Conditions d'utilisation</h1>
        </div>
        <div class="container">
            <div class="row is-full has_margin">
                @if($pageContent->count())
                    @foreach($pageContent as $content)
                        {!! $content->content !!}
                    @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
