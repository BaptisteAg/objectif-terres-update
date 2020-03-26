@extends ('default')

@section ('title', 'Rechercher parmis les annonces postées sur Objectif Terres')

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
												<a href="{{route('login')}}">
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
							<a id="open-modal" href="">
								<span class="icon"><i class="far fa-heart"></i></span>
								<span>Sauvegarder cette recherche</span>
							</a>
							<form method="POST" action="{{ route('researches.store', request()->input())}}">
								@csrf
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
														Valider
													</button>

												</div>
												<button id="close-modal" class="modal-close is-large"
														aria-label="close"></button>
											</footer>
										</div>
									</div>
								</div>
							</form>
						@endguest
					</div>
				</div>
			</nav>
			<nav class="level">
				<div class="level-left">
					<div class="">
						@if ($adsType === 'landOfferAd')
							<h1 class="title">Offres foncières</h1>
						@elseif($adsType === 'landSeekAd')
							<h1 class="title">Recherche de fonciers</h1>
						@elseif($adsType === 'jobOfferAd')
							<h1 class="title">Offres d'emploi</h1>
						@else
							<h1 class="title">Recherche d'emploi</h1>
						@endif
						<h2 class="subtitle">{{ ($ads->total()) }} annonces trouvées</h2>
					</div>
				</div>
				<div class="level-right">
					<div class="level-item ">
						<label class="label">Trier par : </label>
						<br>
						<div class="select">
							<select onchange="this.options[this.selectedIndex].value && (window.location = this.options[this.selectedIndex].value);">
								<option value="">Choisissez un filter</option>
								<option {{request()->input('order') === 'desc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'date', 'page'=> 0])) }}">
									Date: du plus récent au plus ancien
								</option>
								<option {{request()->input('order') === 'asc' && request()->input('sort') === 'date' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'date', 'page'=> 0])) }}">
									Date: du plus ancien au plus récent
								</option>

								@if($adsType =='landSeekAd' or $adsType== 'landOfferAd')
									@if($adsType == 'landOfferAd')
										<option {{request()->input('order') === 'asc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'price', 'page'=> 0])) }}">
											Prix : du moins au plus élevé
										</option>
										<option {{request()->input('order') === 'desc' && request()->input('sort') === 'price' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'price', 'page'=> 0])) }}">
											Prix : du plus au moins élevé
										</option>
									@endif
									@if($adsType == 'landSeekAd')
										<option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface_max', 'page'=> 0])) }}">
											Surface : du plus petit au plus grand
										</option>
										<option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface_max' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface_max', 'page'=> 0])) }}">
											Surface : du plus grand au plus petit
										</option>
									@elseif($adsType == 'landOfferAd')
										<option {{request()->input('order') === 'asc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'asc', 'sort'=>'surface', 'page'=> 0])) }}">
											Surface : du plus petit au plus grand
										</option>
										<option {{request()->input('order') === 'desc' && request()->input('sort') === 'surface' ? 'selected' : '' }} value="{{ route('researches.index', array_merge(Request::all(), ['order'=>'desc', 'sort'=>'surface', 'page'=> 0])) }}">
											Surface : du plus grand au plus petit
										</option>
									@endif
								@endif
							</select>
						</div>
					</div>
				</div>
			</nav>
			<section class="section">
				@foreach($ads as $ad)
					<div class="columns">
						<div class="column is-two-fifths">
							<a href="{{route("ads.show", $ad->id)}}">
								<figure><img src="https://picsum.photos/500/300" alt="Placeholder image"></figure>
							</a>
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
										<span>Publié {{ $ad->created_at_diff }}</span>
									</div>
								</div>
							</nav>
							<div></div>
							<a href="{{route("ads.show", $ad->id)}}">
								<h1 class="title">{{ $ad->title }}</h1>
							</a>

							@if($adsType === 'landOfferAd')
								<div><span>{{ $ad->landOfferAd->price }}</span> € |
									<span>{{ $ad->landOfferAd->surface }}</span> ha
								</div>
							@else
								<div><span></span></div>
							@endif
							@if(count($ad->regions))
								<p class="is-italic ">{{$ad->regions->pluck('name')->implode(', ')}}</p>
							@endif
							@if(count($ad->departments))
								<p class="is-italic ">{{$ad->departments->pluck('name')->implode(', ')}}</p>
							@endif
							@if(count($ad->cities))
								<p class="is-italic ">{{ $ad->cities->pluck('name')->implode(', ') }}</p>
							@endif

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
					<br>
				@endforeach
			</section>
			<section class="section">
				<div class="columns is-mobile is-centered">
					<div class="column is-half ">
						{{ $ads->appends(Request::all())->links() }}
					</div>
				</div>

				{{--				@if($ads->lastPage() > 1)--}}
				{{--					<nav class="pagination is-centered" role="navigation" aria-label="pagination">--}}
				{{--						<ul class="pagination-list">--}}
				{{--							<li>--}}
				{{--								<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => 1])) }}"--}}
				{{--								   class="{{ $ads->currentPage() === 1 ?'pagination-link is-current-page' : 'pagination-link' }}"--}}
				{{--								   aria-label="Goto page 1">1</a>--}}
				{{--							</li>--}}
				{{--							<li class="{{ $ads->lastPage() > 6 }}"><span class="pagination-ellipsis">&hellip;</span>--}}
				{{--							</li>--}}
				{{--							@if($ads->lastPage() >= 3)--}}
				{{--								@if($ads->lastPage()<=10)--}}
				{{--									<li>--}}
				{{--										<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => $ads->currentPage()-1])) }}"--}}
				{{--										   class="pagination-link is-current-page' "--}}
				{{--										   aria-label="Goto page {{ $ads->currentPage()-1 }}"><< Précédent</a>--}}
				{{--									</li>--}}
				{{--									<li>--}}
				{{--										<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => $ads->currentPage()])) }}"--}}
				{{--										   class="{{ ((int)request()->input('page') === $ads->currentPage()) ? ' pagination-link is-current-page' : 'pagination-link' }}"--}}
				{{--										   aria-label="Goto page {{ $ads->currentPage() }}">{{ $ads->currentPage() }}</a>--}}
				{{--									</li>--}}
				{{--									<li>--}}
				{{--										<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => $ads->currentPage() + 1])) }}"--}}
				{{--										   class="pagination-link is-current-page' "--}}
				{{--										   aria-label="Goto page {{ $ads->currentPage()+1 }}">Suivant >></a>--}}
				{{--									</li>--}}
				{{--								@else--}}
				{{--									@for($i = 2; $i <= $ads->lastPage()-1; $i++)--}}
				{{--										<li>--}}
				{{--											<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => $i])) }}"--}}
				{{--											   class="{{ ((int)request()->input('page') === $i) ? ' pagination-link is-current-page' : 'pagination-link' }}"--}}
				{{--											   aria-label="Goto page {{ $i }}">{{ $i }}</a>--}}
				{{--										</li>--}}
				{{--									@endfor--}}
				{{--								@endif--}}
				{{--							@endif--}}
				{{--							<li><span class="pagination-ellipsis">&hellip;</span></li>--}}
				{{--							<li>--}}
				{{--								<a href="{{ route('researches.index', array_merge(Request::all(), ['page' => $ads->lastPage()])) }}"--}}
				{{--								   class="{{ ($ads->currentPage() == $ads->lastPage()) ? ' pagination-link is-current-page' : 'pagination-link' }}"--}}
				{{--								   aria-label="Goto page {{ $ads->lastPage() }}">{{ $ads->lastPage() }}</a>--}}
				{{--							</li>--}}
				{{--						</ul>--}}
				{{--					</nav>--}}
				{{--				@endif--}}
			</section>
			@if($adsType === 'landOfferAd' || $adsType === 'landSeekAd')
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
				@include('components.section-orientation-terre-liens')
			@endif


		</div>
	</section>
	@include('components.partnering')
	@include('components.support-terre-liens')
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
