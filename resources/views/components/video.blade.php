@if($cmsCommonContent->count())
    @if($cmsCommonContent->has('Description vidéo'))
        <div class="youtube-player" data-id="Nkxi7iu0Lfw"></div>
        <div id="overlay-text" style="display: none"><p>{!! $cmsCommonContent['Description vidéo'][0]->content  !!}</p></div>
    @endif
@endif
