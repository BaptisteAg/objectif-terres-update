@extends('default')

@section('title')
    {{ $ad->title }}
@endsection

@section('head-script')
    <!-- Import Leaflet CSS Style Sheet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <!-- Import Leaflet JS Library -->
    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.4.1/dist/esri-leaflet.js"
            integrity="sha512-xY2smLIHKirD03vHKDJ2u4pqeHA7OQZZ27EjtqmuhDguxiUvdsOuXMwkg16PQrm9cgTmXtoxA6kwr8KBy3cdcw=="
            crossorigin=""></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')

    <section class="section pt-0 ">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li class="breadcrumb__home">
                        <a href="/" class="breadcrumb__link"> <i class="fas fa-home"></i></a>
                    </li>
                    <li>
                        @if($ad->type === "landSeekAd")
                            <a class="breadcrumb__link"
                               href="{{route('researches.index',  ["offer_type"=>"SeekAd", 'ad_category' => 'land'])}}">
                                {{--                                <span class="icon">--}}
                                {{--                                    <i class="fas fa-home"></i>--}}
                                {{--                                </span>--}}
                                <span>{{$ad->ad_type_full_name}}</span>
                            </a>
                        @elseif($ad->type === "landOfferAd")
                            <a class="breadcrumb__link"
                               href="{{route('researches.index',  ["offer_type"=>"OfferAd", 'ad_category' => 'land'])}}">
                                {{--                                <span class="icon">--}}
                                {{--                                    <i class="fas fa-home"></i>--}}
                                {{--                                </span>--}}
                                <span>{{$ad->ad_type_full_name}}</span>
                            </a>
                        @elseif($ad->type === "jobSeekAd")
                            <a class="breadcrumb__link"
                               href="{{route('researches.index',  ["offer_type"=>"SeekAd", 'ad_category' => 'job'])}}">
                                {{--                                <span class="icon">--}}
                                {{--                                    <i class="fa-universal-access"></i>--}}
                                {{--                                </span>--}}
                                <span>{{$ad->ad_type_full_name}}</span>
                            </a>
                        @elseif($ad->type === "jobOfferAd")
                            <a class="breadcrumb__link"
                               href="{{route('researches.index',  ["offer_type"=>"OfferAd", 'ad_category' => 'job'])}}">
                                {{--                                <span class="icon">--}}
                                {{--                                    <i class="fas fa-universal-access"></i>--}}
                                {{--                                </span>--}}
                                <span>{{$ad->ad_type_full_name}}</span>
                            </a>
                        @endif
                    </li>
                    <li><span class="breadcrumb__link">{{$ad->title}}</span></li>
                </ul>
            </nav>
            @auth
                @if(auth()->user()->role >= 1 && $ad->attributionAd)

                    @auth
                        @if(auth()->user()->role >= 1 )
                            {{--@if (session()->has('supervisor_dashboard_url'))
                                <div class="content ml-80 mt-30">
                                    <a class="text_size large"
                                       href="{{route('supervisor.show', Session::get('supervisor_dashboard_url') )}}">
                                        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                                        <span>Retour au tableau de bord </span>
                                    </a>
                                </div>
                            @elseif(session()->has('moderator_dashboard_url'))
                                <div class="content ml-80 mt-30">
                                    <a class="text_size large"
                                       href="{{route('moderator.show', Session::get('moderator_dashboard_url') )}}">
                                        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                                        <span>Retour à l'espace modérateur </span>
                                    </a>
                                </div>
                            @else--}}
                            @include('components.back-links')
                            {{--@endif--}}
                        @endif
                    @endauth

                    @if($ad->isProject() && auth()->user()->role >= 2)
                        @include ('pages.ads.partials.attribution-project-options')
                    @elseif(! $ad->isProject())
                        @include('pages.ads.partials.moderator-options')
                    @endif
                @endif
                @if(auth()->user()->id === $ad->user_pp_id)
                    @include('pages.ads.partials.ad-status-message-display')
                @endif
            @endauth

            @if($ad->canEdit())
                <div class="is-pulled-right ">
                    <a href="{{  route('ads.delete', [ $ad->id]) }}"
                       onclick="return confirm('Êtes vous sûr·e ? Cette opération est irréversible.')"
                       class="button form-button basic danger has-tooltip-multiline"
                       data-tooltip="L'annonce ne sera plus visible par le public et non plus par les modérateurs et RT">
                        <span class="icon is-small">
                            <i class="fas fa-trash-alt"></i>
                        </span>
                        <span>Supprimer</span>
                    </a>
                </div>

                <div class="is-pulled-right mr-10  ">
                    <a href="{{  route('ads.archive', [ $ad->id]) }}"
                       onclick="return confirm('Êtes vous sûr·e ?')"
                       class="button form-button basic danger has-tooltip-multiline"
                       data-tooltip="L'annonce ne sera plus visible par le public, par contre, les modérateurs et RT pourront toujours les consulter">
                        <span class="icon is-small">
                            <i class="fas fa-trash-alt"></i>
                        </span>
                        <span>Archiver</span>
                    </a>
                </div>

                <div class="is-pulled-right mr-10 ">
                    <a href="{{ $isSupportRequest ? route('support-request.edit') : route('ads.edit', ["id" => $ad->id]) }}"
                       class="button form-button basic warning">
                        <span class="icon is-small">
                            <i class="fas fa-pen"></i>
                        </span>
                        <span>Modifier</span>
                    </a>
                </div>

                <div class="is-clearfix"></div>
            @endif

            <h1 class="title is-1 has-text-link has-text-centered">{{$ad->title}}</h1>

            <div>
                <h1 class="title is-1 bg-beige">{{$ad->type}}</h1>
                @if($ad->type === 'landSeekAd')
                    @include('pages.ads.partials.landSeek.landSeekShow')
                @endif
                @if($ad->type === 'landOfferAd')
                    @include('pages.ads.partials.landOffer.landOfferShow')
                @endif
                @if($ad->type === 'jobOfferAd')
                    @include('pages.ads.partials.jobOffer.jobOfferAdShow')
                @endif
                @if($ad->type === 'jobSeekAd')
                    @include('pages.ads.partials.jobSeek.jobSeekAdShow')
                @endif

                <div id="map_ad"></div>

                <div class="section">
                    @include('pages.ads.partials.threadsDisplay')
                </div>
            </div>
        </div>
        <div class="is-pulled-right mr-30 ">
            <a href="https://portail-terredeliens.force.com/rhizome/s/signaler-un-abus" target="_blank">
                <span class="icon has-text-info">
                    <i class="fas fa-exclamation-circle"></i>
                </span>
                <span>
                    Signaler un abus
                </span>
            </a>
        </div>

    </section>
    @include('components.support-terre-liens')
@endsection

@section('script')
    <script>
        let buttons = document.querySelectorAll('button.open-modal-message');
        buttons.forEach((button) => {
            button.addEventListener('click', function (event) {
                event.preventDefault();
                let modal = document.querySelector('div[data-type="modal-message"]');
                let html = document.querySelector('html');
                modal.classList.add('is-active');
                html.classList.add('is-clipped');

                modal.querySelector('div[data-type="modal-message-background"]').addEventListener('click', function (e) {
                    e.preventDefault();
                    modal.classList.remove('is-active');
                    html.classList.remove('is-clipped');
                });
                modal.querySelector('#close-modal').addEventListener('click', function (e) {
                    e.preventDefault();
                    modal.classList.remove('is-active');
                    html.classList.remove('is-clipped');
                });
            });
        });

        @auth()
        @if(auth()->user()->role >= 1)
        function showValidationSupervisorModal() {
            let validationModal = document.querySelector('#modal-supervisor-validation');
            let html = document.querySelector('html');
            let listAdvisorUsers = document.getElementById("list_advisor_users");
            let advisorUserSelected = listAdvisorUsers.options[listAdvisorUsers.selectedIndex].text;
            let spanAdvisorSelected = document.querySelector('#user_advisor_selected');
            spanAdvisorSelected.innerHTML = advisorUserSelected;
            validationModal.classList.add('is-active');
            html.classList.add('is-clipped');

            validationModal.querySelector('#modal-supervisor-validation-background').addEventListener('click', function (e) {
                e.preventDefault();
                validationModal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
            validationModal.querySelector('#close-modal').addEventListener('click', function (e) {
                e.preventDefault();
                validationModal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
        }
        @endif
        @endauth
        function sendResponseTemplateMessage() {
            let listResponseTemplates = document.getElementById("response_templates_list");
            let responseTemplateSelected = listResponseTemplates.options[listResponseTemplates.selectedIndex].value;
            let textareaMessage = document.querySelector('#textearea_message');
            textareaMessage.value = responseTemplateSelected;
        }

    </script>
    {{--    @if(count($ad->images) > 1)--}}
    <script src="{{asset('/js/bulma-carousel.js')}}"></script>
    <script>
        @if($ad->images->count() > 1)
        const carousel = bulmaCarousel.attach('#ad-images', {
            slidesToScroll: 1,
            slidesToShow: 1,
            loop: true,
            navigationSwipe: true,
            pagination: true,
        });
        @endif
    </script>
    {{--    @endif--}}

    {{--    <script>
            let vueMessageContainer = document.querySelector('#vue-messages');
            if (vueMessageContainer !== null) {
                const vueThreads = new Vue({
                    el: '#vue-messages',
                    name: 'content'
                });
            }

            @auth()
                @if(auth()->user()->role >= 1 and !$ad->project()->exists())
                    const VueModerationModal = new Vue({
                        el: "#vue-moderation-modal",
                        name: 'content'
                    });
                @endif
            @endauth
        </script>--}}

    <script defer>

        let locationsAd = [];

        @foreach($ad->regions as $location)
        locationsAd.push("{{$location->name}}");
        @endforeach

        @foreach($ad->departments as $location)
        locationsAd.push("{{$location->name}}");
        @endforeach

        @foreach($ad->cities as $location)
        @if($ad->landOfferAd && !$ad->landOfferAd->accept_use_zip_code)
        locationsAd.push("{{$location->department->name}}");
        @else
        locationsAd.push("{{$location->name}};{{$location->zip_code}}");
        @endif
        @endforeach
        showAdMapInit('map_ad', locationsAd);
    </script>

    <script>

        {{--var map = L.map('map_ad', { /* use the same name as your <div id=""> */--}}
        {{--    center: [46.290552, 2.771017], /* set GPS Coordinates */--}}
        {{--    zoom: 5, /* define the zoom level */--}}
        {{--    zoomControl: true, /* false = no zoom control buttons displayed */--}}
        {{--    scrollWheelZoom: false /* false = scrolling zoom on the map is locked */--}}
        {{--});--}}

        {{--L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg', { /* set your personal MapBox Access Token */--}}
        {{--    maxZoom: 18, /* zoom limit of the map */--}}
        {{--    minZoom: 5,--}}
        {{--    id: 'mapbox.satellite' /* mapbox.light / dark / streets / outdoors / satellite */--}}
        {{--}).addTo(map);--}}

        {{--L.esri.basemapLayer('Imagery').addTo(map);--}}
        {{--L.esri.basemapLayer('ImageryLabels').addTo(map);--}}


        {{--function setupLocationPolygon(polygonData, options) {--}}
        {{--    var polygon = L.geoJSON(polygonData.geojson, {--}}
        {{--        smoothFactor: options.smoothFactor || 0,--}}
        {{--        style: {--}}
        {{--            color: '#b34818'--}}
        {{--        }--}}
        {{--    });--}}

        {{--    polygon.addTo(map);--}}
        {{--    map.fitBounds(polygon.getBounds());--}}

        {{--    return polygon--}}
        {{--}--}}

        {{--var formData = new FormData();--}}
        {{--formData.append('_token', "{{ csrf_token() }}");--}}

        {{--@foreach($ad->regions as $location)--}}
        {{--    formData.append('names[]', "{{$location->name}}");--}}
        {{--@endforeach--}}
        {{--@foreach($ad->departments as $location)--}}
        {{--    formData.append('names[]', "{{$location->name}}");--}}
        {{--@endforeach--}}


        {{--@foreach($ad->cities as $location)--}}
        {{--    @if($ad->landOfferAd && !$ad->landOfferAd->accept_use_zip_code)--}}
        {{--        formData.append('names[]', "{{$location->department->name}}");--}}
        {{--    @else--}}
        {{--        formData.append('names[]', "{{$location->name}}");--}}
        {{--    @endif--}}

        {{--@endforeach--}}



        {{--fetch('/locations/polygon/ad-locations', {--}}
        {{--    method: 'POST',--}}
        {{--    body: formData--}}
        {{--})--}}
        {{--    .then(response => response.json())--}}
        {{--    .then(regionsPolygonData => {--}}

        {{--        regionsPolygonData.forEach(polygonData => {--}}
        {{--            setupLocationPolygon(polygonData, {--}}
        {{--                smoothFactor : 2--}}
        {{--            })--}}
        {{--        })--}}
        {{--    })--}}

    </script>
@endsection
