@extends ('default')

@section ('title', "Conditions d'utilisation")

@section('main-content')
    <section class="section cms-page">
        <div>
            <h1 class="page__title has-text-centered ">Conditions d'utilisation</h1>
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
