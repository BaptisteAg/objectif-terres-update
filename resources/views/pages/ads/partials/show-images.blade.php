<div id="slider-container" class="column is-half ">
    <div id="ad-images" class="carousel">
        @if($ad->hasImages)
            @foreach($ad->images as $document)
                <div class="card">
                    <div class="card-image">
                        <figure >
                            @if($document->path === "0")
                                <img class="custom-carousel-image-size" src="/images/placeholder-ad.png" alt="picsum" >
                            @else
                                <img class="custom-carousel-image-size" src="{{URL::asset($document->path)}}" alt="Placeholder image" >
                            @endif
                        </figure>
                    </div>
                </div>
            @endforeach
        @else
            <div class="card carousel-item ad-carousel">
                <div class="card-image">
                    <figure class="image is-2by1">
                        <img src="/images/placeholder-ad.png">
                    </figure>
                </div>
            </div>
            <div class="card carousel-item  ad-carousel">
                <div class="card-image">
                    <figure class="image is-2by1">
                        <img src="https://picsum.photos/480/320">
                    </figure>
                </div>
            </div>
            <div class="card carousel-item  ad-carousel">
                <div class="card-image">
                    <figure class=" image is-16by9 ">
                        <img src="/images/placeholder-ad.png">
                    </figure>
                </div>
            </div>
        @endif
    </div>
</div>