@extends ('default')

@section ('title', 'Rechercher parmis les annonces posté sur Objectif Terres')

@section('main-content')


    <section class="section">
        <div class="container">
            <nav class="level">
                <div class="level-left">
                    <div class="level-item">
                        @include('components.breadcrumb')
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        <span class="icon"><a href=""><i class="far fa-heart"></i></a></span>
                        Sauvegarder cette recherche
                    </div>
                </div>
            </nav>

            <nav class="level">
                <div class="level-left">
                    <div class="">
                        @if ($adType === 'landOfferAd')
                            <h1 class="title">Offres foncières</h1>
                        @elseif($adType === 'landSeekAd')
                            <h1 class="title">Demandes de fonciers</h1>
                        @elseif($adType === 'landSeekAd')
                            <h1 class="title">Offres d'emploi</h1>
                        @else
                            <h1 class="title">Demandes d'emploi</h1>
                        @endif
                        <h2 class="subtitle">{{ count($ads) }} annonces trouvées.</h2>
                    </div>
                </div>
                <div class="level-right">
                    <div class="level-item">
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Tout', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Vente', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                        {!! Form::open(['url' => '']) !!}
                        {!! Form::submit('Location', ['class' => 'button']) !!}
                        {!! Form::close() !!}
                    </div>
                    <div class="level-item">
                        <div class="help">Trier : </div>
                        {!! Form::open(['url' => '']) !!}
                        <div class="select">
                            {!! Form::select('select', ['date' => 'Date: du plus récent au plus ancien', 'S' => 'Small']) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </nav>


            <section class="section">
                @foreach($ads as $ad)
                <div class="columns is-gapless">
                    <div class="column is-two-fifths">
                        <figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
                        <div>
                            {{ $ad->regions->pluck('name')->implode(', ') }}
                        </div>
                        @if($adType === 'landOfferAd')
                            <div><span>{{ $ad->$adType->land->price }}</span> € | <span>{{ $ad->$adType->land->area }}</span> ha</div>
                        @else
                            <div><span></span></div>
                        @endif
                    </div>
                    <div class="column">
                        <nav class="level">
                            <div class="level-left">
                                <div class="level-item">
                                    <span>Partenaire Objectif Terre</span>
                                </div>
                            </div>
                            <div class="level-right">
                                <div class="level-item">
                                    @if($ad->created_at->isToday())
                                        <span>Publié aujourd'hui</span>
                                    @else
                                        <span>Publié {{ $ad->created_at->diffForHumans() }}</span>
                                    @endif
                                </div>
                            </div>
                        </nav>
                        <div></div>
                        <h1 class="title">{{ $ad->$adType->title }}</h1>
                        <div class="descritption">Je suis une discritpion {{ Illuminate\Support\Str::limit($ad->about_project_content, 200) }}</div>
                        <a href="{{url("/annonce", $ad->id)}}">Voir</a>
                    </div>
                </div>
                @endforeach
            </section>

            <section class="section">
{{--                @if($ads->lastPage() > 1)--}}
{{--                    <nav class="pagination is-centered" role="navigation" aria-label="pagination">--}}
{{--                        <ul class="pagination-list">--}}
{{--                            <li class="{{ $ads->currentPage() === 1 ? 'disabled' : '' }}">--}}
{{--                                <a href="{{ $ads->url(1) }}" class="pagination-link" aria-label="Goto page 1">1</a>--}}
{{--                            </li>--}}
{{--                            <li class="{{ $ads->lastPage() > 6 }}"><span class="pagination-ellipsis">&hellip;</span></li>--}}
{{--                            @if($ads->lastPage() >= 3)--}}
{{--                                @for($i = 1; $i <= $ads->lastPage(); $i++)--}}
{{--                                    <li class="{{ ($ads->currentPage() == $i) ? ' active' : '' }}">--}}
{{--                                        <a href="{{ $ads->url($i) }}" class="pagination-link" aria-label="Goto page {{ $i }}">{{ $i }}</a>--}}
{{--                                    </li>--}}
{{--                                @endfor--}}
{{--                            @endif--}}
{{--                            <li><span class="pagination-ellipsis">&hellip;</span></li>--}}
{{--                            <li class="{{ ($ads->currentPage() == $ads->lastPage()) ? ' disabled' : '' }}">--}}
{{--                                <a href="{{ '/recherches' . $ads->url($ads->currentPage()+1) }}" class="pagination-link" aria-label="Goto page {{ $ads->lastPage() }}">{{ $ads->lastPage() }}</a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </nav>--}}
{{--                @endif--}}
                <pagination :per-page="10" :records="500" @paginate="myCallback"></pagination>
            </section>

            @if($adType === 'landOfferAd' || $adType === 'landSeekAd')
                <section class="section">
                    <div class="columns">
                        <div class="column">
                            <h1 class="title is-1">Avez-vous un projet agricole ?</h1>
                            <div><p>Objectif Terre est là pour vous aider à le réaliser ! Avec un suivi sur mesure et notre expérience du secteur, nous sommes en mesure de vous apporter une vraie plus value, de l'idée initiale au projet déjà défini. <u>Rencontrons-nous !</u></p></div>
                            <div>
                                <p><i class="far fa-check-circle"></i> Un suivi sur mesure</p>
                                <p><i class="far fa-check-circle"></i> Des experts du secteur foncier</p>
                                <p><i class="far fa-check-circle"></i> Des ressources</p>
                                <p><i class="far fa-check-circle"></i> Des formations adaptées</p>
                            </div>
                            <a href="/" class="button is-dark is-uppercase is-medium">Contactez-nous</a>
                        </div>
                        <div class="column">
                            <figure><img src="https://picsum.photos/600/350" alt="Placeholder image"></figure>
                            <div><p>En 2018, plus de xx fermiers ont pu s'installer ou céder leurs terres avec succès, grâce à la platerforme Objectif Terre et au travail mené sur le terrain par l'association Terre de Liens</p></div>
                        </div>
                    </div>
                </section>
            @else
                @include('components.section_orientation_terre_liens')
            @endif

            @include('components.partnering')
            @include('components.support_terre_liens')

        </div>
    </section>
@endsection
