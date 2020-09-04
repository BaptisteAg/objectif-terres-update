@if($cmsCommonContent->count())
    @if($cmsCommonContent->has('Chiffres clés'))
        <div class="row is-full">
            <div class="columns columns-numbers has_margin">
                <div class="column">
                    @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                        @if($cmsContent->slug === "premier-chiffre")
                            <div class="progress" data-percentage={{$cmsContent->content}}>
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value">
                                    <div>
                                        {{$cmsContent->content}}%<br>
                                    </div>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                    <div>
                        @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                            @if($cmsContent->slug === "description-premier-chiffre")
                                {!! $cmsContent->content !!}
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="column">
                    @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                        @if($cmsContent->slug === "premier-chiffre")
                            <div class="progress" data-percentage={{$cmsContent->content}}>
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value">
                                    <div>
                                        {{$cmsContent->content}}%<br>
                                    </div>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                    <div>
                        @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                            @if($cmsContent->slug === "description-deuxieme-chiffre")
                                {!! $cmsContent->content !!}
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="column">
                    @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                        @if($cmsContent->slug === "premier-chiffre")
                            <div class="progress" data-percentage="{{$cmsContent->content}}">
                                <span class="progress-left">
                                    <span class="progress-bar"></span>
                                </span>
                                <span class="progress-right">
                                    <span class="progress-bar"></span>
                                </span>
                                <div class="progress-value">
                                    <div>
                                        {{$cmsContent->content}}%<br>
                                    </div>
                                </div>
                            </div>
                            @break
                        @endif
                    @endforeach
                    <div>
                        @foreach($cmsCommonContent['Chiffres clés'] as $cmsContent)
                            @if($cmsContent->slug === "description-troisieme-chiffre")
                                {!! $cmsContent->content !!}
                                @break
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
