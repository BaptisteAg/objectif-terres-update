@if($cmsCommonContent->count())
    @if($cmsCommonContent->has('Téléchargement guide'))
        <section class="hero has_margin">
            <div class="hero-body contactus-background">
                <div class="container">
                    <div class="columns">
                        <div class="rows column is-6 guide-text">
                            <div class="row is-full">
                                @if(isset($cmsCommonContent['Téléchargement guide'][0]))
                                    {!! $cmsCommonContent['Téléchargement guide'][0]->content !!}
                                @endif
                            </div>
                            <div class="row is-full">
                                <button class="button basic small primary  waves-effect waves-button waves-float waves-light">
                                    TELECHARGER
                                </button>
                            </div>
                        </div>
                        <div class="column is-6 guide-pdf">
                            <a >
                                <img src="/images/placeholder-ad.png" alt="Placeholder image">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endif
