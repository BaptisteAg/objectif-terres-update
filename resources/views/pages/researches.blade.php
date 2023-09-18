@extends ('default')

@section ('title', 'Rechercher parmi les annonces postées sur Objectif Terres')
@section('head-script')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
    @if($hasDepartmentPolygons)
        <!-- Import Leaflet CSS Style Sheet -->
        <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
    @endif
@endsection

@section('main-content')
    <research-tags :productions_searched="{{ json_encode($searchedTypeOfProductions)}}"
                   :regions_searched="{{ json_encode($searchedRegionNames) }}"></research-tags>

    @if($hasDepartmentPolygons)
        <div id="global-map"></div>
    @endif

    <section class="container">
        <h2 class="title mb-3">
            {{ $ads->total() }} annonce{{ $ads->total() > 1 ? 's' : '' }} trouvée{{ $ads->total() > 1 ? 's' : '' }}
        </h2>
        <p class="mb-6">
            Certaines annonces peuvent être comptabilisées plusieurs fois selon leur localisation
        </p>
        @foreach($ads as $ad)
            @include('pages.ads.partials.card')
        @endforeach
    </section>

@endsection

@section('script')

@endsection
