@extends('default')

@section('title')
    {{ $ad->title }}
@endsection

@section('head-script')
    <!-- Import Leaflet CSS Style Sheet -->
    <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
    <!-- Import Leaflet JS Library -->
    <script src="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/css/bulma-carousel.min.css">
@endsection

@section('main-content')
    @auth
        @if(auth()->user()->role >= 1 )
            @if (session()->has('supervisor_dashboard_url'))
                <div class="content ml-80 mt-30">
                    <a class="text_size large"
                       href="{{route('supervisor.show', Session::get('supervisor_dashboard_url') )}}">
                        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                        <span>Retour </span>
                    </a>
                </div>
            @elseif(session()->has('moderator_dashboard_url'))
                <div class="content ml-80 mt-30">
                    <a class="text_size large"
                       href="{{route('moderator.show', Session::get('moderator_dashboard_url') )}}">
                        <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                        <span>Retour </span>
                    </a>
                </div>
            @else
                @if(auth()->user()->role === 1)
                    <div class="content ml-80 mt-30">
                        <a class="text_size large" href="{{route('moderator.index')}}">
                            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                            <span>Aller sur votre espace modérateur </span>
                        </a>
                    </div>
                @elseif(auth()->user()->role === 2 )
                    <div class="content ml-80 mt-30">
                        <a class="text_size large" href="{{route('advisor.index')}}">
                            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                            <span>Aller sur votre espace primo-accueillant </span>
                        </a>
                    </div>
                @elseif(auth()->user()->role === 3)
                    <div class="content ml-80 mt-30">
                        <a class="text_size large" href="{{route('supervisor.index')}}">
                            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                            <span>Aller sur votre espace responsable territorial </span>
                        </a>
                    </div>
                @else
                    <div class="content ml-80 mt-30">
                        <a class="text_size large" href="{{URL::previous()}}">
                            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
                            <span>Retour </span>
                        </a>
                    </div>
                @endif
            @endif
        @endif
    @endauth

    <section class="section pt-0 ads-content">
        <div class="container">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li class="breadcrumb__home">
                        <a href="/" class="breadcrumb__link"><i class="fas fa-home"></i></a>
                    </li>
                    <li><a class="breadcrumb__link" href="#"><?=empty($isSupportRequest) ? 'Annonces' : 'Accompagnement'?></a></li>
                    <li><a class="breadcrumb__link" href="#">{{$ad->ad_type_full_name}}</a></li>
                    <li><span class="breadcrumb__link">{{$ad->title}}</span></li>
                </ul>
            </nav>
            @auth
                @if(auth()->user()->role >= 1)
                    @if($ad->project()->exists() && auth()->user()->role >= 3)
                        @include ('pages.ads.partials.attribution-project-options')
                    @else
                        @include('pages.ads.partials.moderator-options')
                    @endif
                @endif
                @if(auth()->user()->id === $ad->user_pp_id)
                    @include('pages.ads.partials.ad-status-message-display')
                @endif
            @endauth
            <h1 class="title is-1 has-text-link has-text-centered">{{$ad->title}}</h1>
            <div class="ads-content">
                @if($ad->ad_type === 'landSeek')
                    @include('pages.ads.partials.landSeek.landSeekShow')
                @endif
                @if($ad->ad_type === 'landOffer')
                    @include('pages.ads.partials.landOffer.landOfferShow')
                @endif
                @if($ad->ad_type === 'jobOffer')
                    @include('pages.ads.partials.jobOffer.jobOfferAdShow')
                @endif
                @if($ad->ad_type === 'jobSeek')
                    @include('pages.ads.partials.jobSeek.jobSeekAdShow')
                @endif
            </div>
        </div>
    </section>
    @include('components.support-terre-liens')
@endsection

@section('script')
    <script>

        let buttons = document.querySelectorAll('#open-modal-message');
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

        let deleteButton = document.querySelector('.close-notification');
        deleteButton.addEventListener('click', function (e) {
            let notification = document.querySelector('.message');
            notification.style.display = 'none';

        })

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
            let responseTemplateSelected = listResponseTemplates.options[listResponseTemplates.selectedIndex].text;
            let textareaMessage = document.querySelector('#textearea_message');
            console.log(textareaMessage);
            textareaMessage.value = responseTemplateSelected;
        }

    </script>
{{--    @if(count($ad->images) > 1)--}}
        <script src="{{asset('/js/bulma-carousel.js')}}"></script>
        <script>
            const carousel = bulmaCarousel.attach('#ad-images', {
                slidesToScroll: 1,
                slidesToShow: 1,
                loop: true,
                navigationSwipe: true,
                pagination: true,
            });
        </script>
{{--    @endif--}}

    <script>
        const vueThreads = new Vue({
            el: '#vue-messages',
            name: 'content'
        });
                @auth()
                @if(auth()->user()->role >= 1 and !$ad->project()->exists())
        const VueModerationModal = new Vue({
                el: "#vue-moderation-modal",
                name: 'content'
            })
        @endif
        @endauth
    </script>

    <script>

        var map = L.map('map_ad', { /* use the same name as your <div id=""> */
            center: [46.290552, 2.771017], /* set GPS Coordinates */
            zoom: 5, /* define the zoom level */
            zoomControl: true, /* false = no zoom control buttons displayed */
            scrollWheelZoom: false /* false = scrolling zoom on the map is locked */
        });

        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWlja2l3YXkiLCJhIjoiY2s0YmE0NHZqMDZrejNrcGlxeWJmNHRtdCJ9.In4xuZz8wYnXmDX5jrrhCg', { /* set your personal MapBox Access Token */
            maxZoom: 18, /* zoom limit of the map */
            minZoom: 5,
            id: 'mapbox.satellite' /* mapbox.light / dark / streets / outdoors / satellite */
        }).addTo(map);


        function setupLocationPolygon(polygonData, options) {
            var polygon = L.geoJSON(polygonData.geojson, {
                smoothFactor: options.smoothFactor || 0,
                style: {
                    color: '#b34818'
                }
            });

            polygon.addTo(map);
            map.fitBounds(polygon.getBounds());

            return polygon
        }

        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");

        @foreach($ad->regions as $location)
            formData.append('names[]', "{{$location->name}}");
        @endforeach
        @foreach($ad->departments as $location)
            formData.append('names[]', "{{$location->name}}");
        @endforeach
        @foreach($ad->cities as $location)
            formData.append('names[]', "{{$location->name}}");
        @endforeach

        fetch('/locations/polygon/ad-locations', {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(regionsPolygonData => {

                regionsPolygonData.forEach(polygonData => {
                    setupLocationPolygon(polygonData, {
                        smoothFactor : 2
                    })
                })
            })

    </script>
@endsection