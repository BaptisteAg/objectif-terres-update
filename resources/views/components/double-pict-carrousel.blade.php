<section class="section has_margin">
    <div class="container">
        <div id="carousel-installations" class="carousel">
            @for ($i = 0; $i < 4; $i++)
                <div class="columns">
                    <div class="column">
                        <h2 class="title is-2">96 installations en 2018</h2>
                        <p>
                            Lorem ipsum dolor sit amet,
                            consectetur adipisicing elit, sed do
                            eiusmod tempor incididunt ut
                            labore et dolore magna aliquat
                            enim ad minim.
                        </p>
                    </div>
                    <div class="column is-three-quarters">
                        <div class="columns columns-carousel">
                            <div class="column card">
                                <div class="card-content">
                                    <div class="media">
                                        <figure class="image is-centered is-256x256">
                                            <img src="https://picsum.photos/800/600?random=1" alt="Placeholder image">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                            <div class="column card">
                                <div class="card-content">
                                    <div class="media">
                                        <figure class="image is-centered is-256x256">
                                            <img src="https://picsum.photos/800/600?random=1" alt="Placeholder image">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>
    </div>
</section>
