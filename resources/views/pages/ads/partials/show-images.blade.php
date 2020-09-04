<div id="slider-container" class="column is-half ">
    <div id="ad-images" class="carousel">
        @if($ad->hasImages)
            @foreach($ad->images as $document)
                <div class="card">
                    <div class="card-image">
                            @if($document->path === "0")
                                <img class="custom-carousel-image-size" src="/images/new-placeholder-ad.png" alt="picsum" >
                            @else
                                    <img class="custom-carousel-image-size" data-source="{{URL::asset($document->path)}}" src="{{URL::asset($document->path)}}" style="cursor: pointer">
                            @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="card carousel-item ad-carousel">
                <div class="card-image">
                    <figure>
                        <img class="custom-carousel-image-size" src="/images/new-placeholder-ad.png">
                    </figure>
                </div>
            </div>
        @endif
    </div>
</div>

<div id="image-extended-container" class="overlay">
    <img id="image-extended"  src="/images/new-placeholder-ad.png">
</div>