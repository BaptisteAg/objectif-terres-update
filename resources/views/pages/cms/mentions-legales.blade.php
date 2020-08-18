@extends ('default')

@section ('title', "Mentions Légales")

@section('main-content')
    <section class="section">
        <div>
            <h1 class="page__title has-text-centered ">Mentions Légales</h1>
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
