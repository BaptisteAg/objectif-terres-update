@extends ('default')

@section ('title', 'Rechercher parmi les annonces postées sur Objectif Terres')
@section('head-script')
@endsection

@section('main-content')
    <research-tags :productions_searched="{{ json_encode($searchedTypeOfProductions)}}"
                   :regions_searched="{{ json_encode($searchedRegionNames) }}"></research-tags>

    @if($hasDepartmentPolygons)
        <div id="global-map"></div>
    @endif

    <section class="container">
        <h2 class="title mb-3 mx-3-mobile">
            {{ $ads->total() }} annonce{{ $ads->total() > 1 ? 's' : '' }} trouvée{{ $ads->total() > 1 ? 's' : '' }}
        </h2>
        <p class="mb-6 mx-3-mobile">
            Certaines annonces peuvent être comptabilisées plusieurs fois selon leur localisation
        </p>
        @foreach($ads as $ad)
            @include('pages.ads.partials.card')
        @endforeach
    </section>

@endsection

@section('script')

@endsection
