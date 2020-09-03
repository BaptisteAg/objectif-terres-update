@if($cmsCommonContent->count())
    @if($cmsCommonContent->has("\"Par où démarrer\""))
        <section class="section">
            <div class="container">
                <div class="columns">
                    <div class="column block-demarrer">
                        @foreach($cmsCommonContent["\"Par où démarrer\""] as $cmsContent)
                            @if($cmsContent->slug === "par-ou-commencer-introduction")
                                {!! $cmsContent->content !!}
                                @break
                            @endif
                        @endforeach
                        <button class="button basic small primary  waves-effect waves-button waves-float waves-light">
                            <span class="button_label">
                                DEPOSER VOTRE ANNONCE MAINTENANT
                            </span>
                        </button>
                        <p class="has-text-centered">ou</p>
                        <button class="button basic small primary  waves-effect waves-button waves-float waves-light">
                            CONTACTEZ
                            NOUS
                        </button>
                    </div>
                    <div class="column">
                        <div class="rows">
                            <div class="row-is-full block-step-numbers">
                                <div class="number-step">1</div>
                                <div class="content-numbers">
                                    @foreach($cmsCommonContent["\"Par où démarrer\""] as $cmsContent)
                                        @if($cmsContent->slug === "par-ou-commencer-premiere-etape")
                                            {!! $cmsContent->content !!}
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row-is-full block-step-numbers">
                                <div class="number-step">2</div>
                                <div class="content-numbers">
                                    @foreach($cmsCommonContent["\"Par où démarrer\""] as $cmsContent)
                                        @if($cmsContent->slug === "par-ou-commencer-deuxieme-etape")
                                            {!! $cmsContent->content !!}
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="row-is-full block-step-numbers">
                                <div class="number-step">3</div>
                                <div class="content-numbers">
                                    @foreach($cmsCommonContent["\"Par où démarrer\""] as $cmsContent)
                                        @if($cmsContent->slug === "par-ou-commencer-troisieme-etape")
                                            {!! $cmsContent->content !!}
                                            @break
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
