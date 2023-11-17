@extends ('default')

@section ('title', 'Rechercher parmi les annonces postées sur Objectif Terres')

@section('head-script')
    @if($hasDepartmentPolygons)
        <!-- Import Leaflet CSS Style Sheet -->
        <link rel="stylesheet" href="https://npmcdn.com/leaflet@1.0.0-rc.2/dist/leaflet.css"/>
        <style>
            #global-map {
                width: 100%;
                min-height: 50vh;
                margin: 0;
                border-radius: 5px;
                z-index: 1;
                background-image: url("/images/illustrations/map.png");
                background-position: center;
                background-repeat: no-repeat;
                position: relative;
                padding: 2em 0;
                margin-bottom: 2em;
            }
            #global-map:after {
                content: ' ';
                position: absolute;
                left: 0;
                right: 0;
                top: 0;
                bottom: 0;
                background: rgba(0, 0, 0, .6);
                z-index: -1;
            }
            #global-map > div:first-child {
                min-width: 70vw;
                position: inherit;
                background-color: #f8f3ee;
                padding: 2em;
                max-width: 90vw;
            }
            #global-map .column.have-border {
                border-left: 2px solid #e3cfb5;
            }
            #global-map span.tag {
                background-color: #e3cfb5;
            }
            #global-map .dropdown div button span {
                width: 300px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                text-align: left;
            }
            @media (max-width: 769px) {
                #global-map {
                    min-height: 80vh;
                    padding: 0;
                    background-position: top;
                    background-size: cover;
                }
                #global-map > div:first-child {
                    width: 90vw;
                    padding: 1em;
                }
                #global-map .column.have-border {
                    border-left: none;
                }
            }
        </style>
    @endif
@endsection

@section('main-content')
    <research-tags :productions_searched="{{ json_encode($searchedTypeOfProductions)}}"
                   :regions_searched="{{ json_encode($searchedRegionNames) }}"></research-tags>

    <div class="container py-4">
        <div class="columns">
            <div class="column">
                <div class="select is-rounded">
                    <select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
                        <option disabled value="">Trier par</option>
                        <option {{request()->input('order') === 'desc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date', 'page'=> 0])) }}">
                            Date: du plus récent au plus ancien
                        </option>
                        <option {{request()->input('order') === 'asc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date', 'page'=> 0])) }}">
                            Date: du plus ancien au plus récent
                        </option>

                        @if($adsType =='landSeekAd' or $adsType== 'landOfferAd')
                            @if($adsType == 'landOfferAd')
                                <option {{request()->input('order') === 'asc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'price', 'page'=> 0])) }}">
                                    Prix : du moins au plus élevé
                                </option>
                                <option {{request()->input('order') === 'desc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'price', 'page'=> 0])) }}">
                                    Prix : du plus au moins élevé
                                </option>
                            @endif
                            @if($adsType == 'landSeekAd')
                                <option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface_range_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface_range_max', 'page'=> 0])) }}">
                                    Surface : du plus petit au plus grand
                                </option>
                                <option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface_range_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface_range_max', 'page'=> 0])) }}">
                                    Surface : du plus grand au plus petit
                                </option>
                            @elseif($adsType == 'landOfferAd')
                                <option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface', 'page'=> 0])) }}">
                                    Surface : du plus petit au plus grand
                                </option>
                                <option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface', 'page'=> 0])) }}">
                                    Surface : du plus grand au plus petit
                                </option>
                            @endif
                        @endif
                    </select>
                </div>
            </div>
            <div class="column is-flex is-justify-content-flex-end gap-2 jc-sb-mobile mx-3-mobile">
                <b-button rounded tag="a" href="/" type="is-danger">Modifier ma recherche</b-button>
                <modal
                        title="Sauvgarde d'une recherche"
                        subtitle="Donner un titre à votre recherche :"
                        :is-responsive="true"
                        button-label="Sauvegarder"
                        button-icon="heart-outline"
                        :is-disable="{{ $_GET["ad_category"] === 'all' ? 'true' : 'false' }}"
                >
                    <form method="POST" action="{{ route('researches.store', request()->input())}}">
                        @csrf
                        <b-input size="is-medium" name="name" placeholder="Votre titre..." rounded></b-input>
                        <b-button size="is-medium" class="mt-4" type="is-primary" rounded
                                  native-type="submit" expanded>Valider
                        </b-button>
                    </form>
                </modal>
            </div>
        </div>
    </div>

    @if($hasDepartmentPolygons)
        @if($hasDepartmentPolygons)
            <section class="section pt-0">
                <div class="container">
                    <div id="global-map"></div>
                </div>
            </section>
        @endif
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

    <section class="container my-7">
        {{ $ads->appends(Request::all())->links() }}
    </section>

@endsection

@section('script')
    @if($hasDepartmentPolygons)
        <script defer>
            regionMapInit('global-map', {
                region_id: "{{$request->get("regions_location_researches_ids")[0]}}",
                ad_category: "{{$request->get("ad_category")}}"
            });
        </script>
    @endif
@endsection
