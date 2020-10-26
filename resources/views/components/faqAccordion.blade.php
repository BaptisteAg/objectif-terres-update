<section class="">
    <div class="container has-text-centered">
        <h2 class="title is-2 is-spaced">Questions fréquentes</h2>
        <h5 class="subtitle is-5">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab animi, consectetur
            debitis delectus eaque est fugit hic ipsum laborum, laudantium nulla odit, omnis quasi repellat
            voluptatibus! Error fugiat reprehenderit suscipit.</h5>
        <section class="accordions">

            @foreach($cmsFaq as $question)
            <article class="accordion">
                <div class="accordion-header toggle">
                    <p class="button__label">{{$question->content_question}}</p>
                    <button class="toggle" aria-label="toggle"></button>
                </div>
                <div class="accordion-body">
                    <div class="accordion-content">
                        {{$question->content_answer}}
                    </div>
                </div>
            </article>
            @endforeach
        </section>
    </div>
</section>





