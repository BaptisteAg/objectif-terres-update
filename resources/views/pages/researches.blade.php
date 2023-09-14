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
    @if($hasDepartmentPolygons)
        <div id="global-map"></div>
    @endif
    <section class="container">
        @foreach($ads as $ad)
            <a class="columns is-flex fd-c-mobile" href="/annonces/{{$ad->id}}">
                <div class="column is-two-fifths">
                    <figure class="image is-3by2">
                        @if($ad->hasImages && $ad->images[0]?->path)
                            <img class="objT-border"
                                 src="{{app('url')->assetFrom('https://objectif-terres.org', $ad->images[0]->path)}}"
                                 alt="{{$ad->images[0]->name}}">
                        @else
                            <img class="objT-border"
                                 src="https://images.unsplash.com/photo-1557234195-bd9f290f0e4d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1170&q=80"
                                 alt="placeholder">
                        @endif
                    </figure>
                </div>
                <div class="column is-flex is-flex-direction-column">
                    <div class="columns is-mobile mt-2 mb-0 mt-4-mobile mb-3-mobile is-justify-content-space-between">
                        <div class="column pl-0-mobile">
                             <span class="tag is-warning has-text-weight-bold is-uppercase">
                                  {{ $ad->formatted_type }}
                             </span>
                        </div>

                        <div class="column pr-0-mobile title is-6 has-text-right" style="color: #A74B2B">
                            {{ $ad->formatted_price }}
                        </div>
                    </div>

                    <p class="title is-5">{{ $ad->title }}</p>

                    @if(isset($ad->about_project_content))
                        <p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 200)}}</p>
                    @else
                        Pas de description renseignée pour cette annonce
                    @endif

                    <div class="is-flex mt-auto mb-4 is-justify-content-space-between">
                        <div class="is-flex is-flex-direction-column fd-r-mobile jc-sb-mobile pt-3-mobile" style="width: 100%">
                            <p class="pb-3 pb-0-mobile">
                                @if(!empty($ad->surface))
                                    <span class="has-text-weight-bold">< ></span> {{ $ad->surface }} Ha
                                @endif
                            </p>
                            <p>{{ $ad->formatted_location }}</p>
                        </div>
                        <div class="mt-auto is-hidden-touch">
                            <b-button rounded size="is-medium" tag="a"
                                      href="/annonces/{{$ad->id}}">
                                Voir l'annonce
                            </b-button>
                        </div>
                    </div>
                </div>
            </a>

        @endforeach
    </section>

@endsection

@section('script')

@endsection
