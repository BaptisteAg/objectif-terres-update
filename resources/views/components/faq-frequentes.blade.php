<section class="section">
    <div class="container">
        <div class="rows">
            <div class="row has-text-centered">
                <h2 class="title is-2">Questions fréquentes</h2>
            </div>
            <div class="row has_margin">
                <div class="rows">
                    @foreach($cmsFaq as $question)
                        <div class="columns has_margin">
                            <div class="column is-6">
                                <h4 class="title is-4">{{$question->content_question}}</h4>
                                <p>{{$question->content_answer}}
                                </p>
                            </div>
                            {{--                            <div class="column is-6">--}}
                            {{--                                <h4 class="title is-4">Purus egestas elit justo ?</h4>--}}
                            {{--                                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod--}}
                            {{--                                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim--}}
                            {{--                                    veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea--}}
                            {{--                                    commodo consequat m dolor sit amet, consectetur adipisicing elit, sed--}}
                            {{--                                    do eiusmod tempor inc.--}}
                            {{--                                </p>--}}
                        </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
