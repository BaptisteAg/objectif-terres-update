@if($ad->hasNonImageDocuments)
    <div class="content">
        <p>
            <span class="is-size-5 ad-show-feature-label">Documents joints au projet : </span><br>
            @foreach($ad->nonImageDocuments as $document)
                @if($document->type === "application/pdf")
                    <i class="fa fa-file-pdf"></i>
                @elseif($document->type === "application/msword")
                    <i class="fa fa-file-alt"></i>
                @else
                    <i class="fa fa-file"></i>
                @endif

                <a href="{{URL::asset($document->path)}}"
                   target="_blank">{{$document->name}}</a>
            @endforeach
        </p>
    </div>
@endif