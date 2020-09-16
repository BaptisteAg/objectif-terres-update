{{--    <section class="section test">--}}
{{--        <div id="vue-homepage" class="container">--}}
{{--            <homepage-components inline-template>--}}
{{--                <rss-feed src="{{ route('rss.news') }}"></rss-feed>--}}
{{--            </homepage-components>--}}
{{--        </div>--}}
{{--    </section>--}}

<section class="section" style="display:none;" :style="{display:ready?'block':'none'}">
    <h2 class="title is-2 is-spaced has-text-centered ">Actualités de Terre de Liens</h2>
    <carousel class="list tiles" :per-page="1" :per-page-custom="[[768, 3], [1024, 5]]" :pagination-size="20">
        @foreach($rssNews as $item)
            <slide class="tile tile_text-image_v">
                <a href="{{ $item["link"] }}" class="tile__link">
                    <div class="vignette photo">
                        <div class="vignette__image-wrap vignette__ratio_1-1">
                            <img src="{{ $item["thumbnail"] }}" class="vignette__image" alt="{{ $item["title"] }}">
                        </div>
                        {{--                                <p class="vignette__credit">Crédit photo Jeanne Cianovitch</p>--}}
                    </div>
                    <div class="tile__content">
                        <h4 class="tile__title">{{ $item["title"] }}</h4>
                        @if(count($item["categories"]))
                            <div class="tags">
                            @foreach($item["categories"] as $category)
                                <span class="tag info">{{ $category }}</span>
                            @endforeach
                            </div>
                        @endif
                        <div class="tile__intro">
                            <p>
                                {{ Str::words($item["description"], 50) }}
                            </p>
                        </div>
                        <p class="button__wrap"> <span class="button round small warning read-more">
                                <span class="button__icon"><i class="fas fa-arrow-right" aria-hidden="true"></i></span> </span>
                        </p>
                    </div>
                </a>
            </slide>
        @endforeach
    </carousel>
</section>