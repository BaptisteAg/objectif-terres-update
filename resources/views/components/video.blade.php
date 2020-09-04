@if($cmsCommonContent->count())
    @if($cmsCommonContent->has('Description vidéo'))
        <div class="youtube-player" data-id="Pr52_7-7Hwk"></div>
        <div id="overlay-text" style="display: none"><p>{!! $cmsCommonContent['Description vidéo'][0]->content  !!}</p></div>
    @endif
@endif