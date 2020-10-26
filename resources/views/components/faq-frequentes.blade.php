<section class="">
    <div class="container">
        <div class="rows">
            <div class="row has-text-centered">
                <h2 class="title is-2">Questions fréquentes</h2>
            </div>
            <div class="row has_margin">
                <div class="rows">
                    <div class="columns has_margin  is-multiline is-mobile ">
                        @foreach($cmsFaq as $question)
                            <div class="column is-6 mb-40">
                                <h4 class="title is-4">{{$question->content_question}}</h4>
                                <p>{!! $question->content_answer !!}
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
