@if($cmsCommonContent->count())
    @if($cmsCommonContent->has('"Donner-vous plus de chances"'))
        <section class="hero">
            <div class="hero-body contactus-background">
                <div class="container columns">
                    <div class="rows margin-p column is-three-quarters is-offset-5 custom-padding">
                        <div class="row is-full ">
                            @if(isset($cmsCommonContent['"Donner-vous plus de chances"'][0]))
                                {!! $cmsCommonContent['"Donner-vous plus de chances"'][0]->content !!}
                            @endif
                        </div>
                        <div class="row is-full">
                            <button class="button is-link">CONTACTEZ-NOUS</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
