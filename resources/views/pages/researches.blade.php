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
						@guest
							<a id="open-modal" href="">
								<span class="icon"><i class="far fa-heart"></i></span>
								<span>Sauvegarder cette recherche</span>
							</a>
							<div class="modal">
								<div class="modal-background"></div>
								<div class="modal-content">
									<div class="card">
										<div class="card-content">
											<div class="content">
												<p class="title is-3 has-text-centered has-text-link">Pas encore
													connecté·e ?</p>
												<p class="subtitle is-6">Pour sauvegarder cette recherche, vous devez
													vous connecter ou créer un compte sur Objectif Terres</p>
											</div>
										</div>
										<footer class="card-footer">
											<div class="buttons card-footer-item">
												<a href="{{route('signIn')}}">
													<button class="button is-link">
														<span>Se connecter</span></button>
												</a>
												<a href="{{route('register')}}">
													<button class="button is-link is-light">
														<span>S'inscrire</span></button>
												</a>
											</div>
											<button id="close-modal" class="modal-close is-large"
													aria-label="close"></button>
										</footer>
									</div>
								</div>
							</div>
						@else
{{--							{!! Form::open(['route' => 'researches.store']) !!}--}}
{{--							<input type="hidden" name="ad_type" value="{{$adType}}">--}}
{{--							@foreach ($regions->pluck('id') as $region)--}}
{{--								<input type="hidden" name="regions[]" value="{{ $region }}">--}}
{{--							@endforeach--}}

							<a id="open-modal" href="">
								<span class="icon"><i class="far fa-heart"></i></span>
								<span>Sauvegarder cette recherche</span>
							</a>
							<div class="modal">
								<div class="modal-background"></div>
								<div class="modal-content">
									<div class="card">
										<div class="card-content">
											<div class="field">
												<label class="label">Donner un titre à votre recherche :</label>
												<div class="control">
													<input class="input" type="text" name="name" id="title"
														   placeholder="Votre titre...">
												</div>
											</div>
										</div>
										<footer class="card-footer">
											<div class="buttons card-footer-item">
												<button type="submit" class="button is-link">
													<span>Valider</span></button>
											</div>
											<button id="close-modal" class="modal-close is-large"
													aria-label="close"></button>
										</footer>
									</div>
								</div>
							</div>
{{--							{!! Form::close() !!}--}}

						@endguest

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
							<a href="{{route("ads.show", $ad->id)}}">
								<figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
							</a>
							<div>
								{{ $ad->regions->pluck('name')->implode(', ') }}
							</div>
{{--							@if($adType === 'landOfferAd')--}}
{{--								<div><span>{{ $ad->$adType->land->price }}</span> € |--}}
{{--									<span>{{ $ad->$adType->land->area }}</span> ha--}}
{{--								</div>--}}
{{--							@else--}}
{{--								<div><span></span></div>--}}
{{--							@endif--}}
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
										@if($ad->is_today)
											<span>Publié aujourd'hui</span>
										@else
											<span>Publié {{ $ad->created_at_diff }}</span>
										@endif
									</div>
								</div>
							</nav>
							<div></div>
							<a href="{{route("ads.show", $ad->id)}}"><h1 class="title">{{ $ad->title }}</h1>
							</a>
							<div class="content descritption">
								<p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 200) }}</p>
							</div>

							<a href="{{route("ads.show", $ad->id)}}">
								<button class="button is-link ">
											<span class="icon is-small">
											 <i class="fas fa-eye"></i>
											</span>
									<span>Voir plus</span>
								</button>
							</a>
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
							<div><p>Objectif Terre est là pour vous aider à le réaliser ! Avec un suivi sur mesure et
									notre expérience du secteur, nous sommes en mesure de vous apporter une vraie plus
									value, de l'idée initiale au projet déjà défini. <u>Rencontrons-nous !</u></p></div>
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
							<div><p>En 2018, plus de xx fermiers ont pu s'installer ou céder leurs terres avec succès,
									grâce à la platerforme Objectif Terre et au travail mené sur le terrain par
									l'association Terre de Liens</p></div>
						</div>
					</div>
				</section>
			@else
				@include('components.sectionOrientationTerreLiens')
			@endif

			@include('components.partnering')
			@include('components.supportTerreLiens')

		</div>
	</section>
@endsection

@section('script')

	<script>
        document.querySelector('a#open-modal').addEventListener('click', function (event) {
            event.preventDefault();
            let modal = document.querySelector('.modal');  // assuming you have only 1
            let html = document.querySelector('html');
            modal.classList.add('is-active');
            html.classList.add('is-clipped');

            modal.querySelector('.modal-background').addEventListener('click', function (e) {
                e.preventDefault();
                modal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
            modal.querySelector('#close-modal').addEventListener('click', function (e) {
                e.preventDefault();
                modal.classList.remove('is-active');
                html.classList.remove('is-clipped');
            });
        });

	</script>

@endsection