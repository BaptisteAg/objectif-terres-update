@section('title', $ad->landSeekAd->title)

<section class="section is-medium ">
	<div class="container ">
		<div class="columns">
			<div class="column is-two-thirds">
				@if ($message = Session::get('success'))
					<article class="message is-success">
						<div class="message-header">
							<p>Succès</p>
							<button id="close-notification" class="delete" aria-label="delete"></button>
						</div>
						<div class="message-body">
							Votre message a bien été envoyé !
						</div>
					</article>
				@endif
				@if ($message = Session::get('save'))
					<article class="message is-success">
						<div class="message-header">
							<p>Succès</p>
							<button id="close-notification" class="delete" aria-label="delete"></button>
						</div>
						<div class="message-body">
							Cette annonce a été sauvegardée dans vos favoris !
						</div>
					</article>
				@endif
				@if ($message = Session::get('error'))
					<article class="message is-warning">
						<div class="message-header">
							<p>Avertissement</p>
							<button id="close-notification" class="delete" aria-label="delete"></button>
						</div>
						<div class="message-body">
							Vous avez déjà sauvegardé cette annonce dans vos favoris !
						</div>
					</article>
				@endif
			</div>
			<div class="column"></div>
		</div>
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Recherches foncières</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->landSeekAd->title}}</h1>
		<div class="columns">
			<div class=" column is-two-thirds ">
				<div id="ad_images" class="carousel">
					@foreach($ad->documents as $document)
						<div class="card">
							<div class="card-image">
								<figure class="image is-2by1">
									@if($document->path === "0")
										<img src="https://picsum.photos/480/320" alt="picsum">
									@else
										<img src="/images/{{$document->path}}" alt="Placeholder image">
									@endif
								</figure>
							</div>
						</div>
					@endforeach
				</div>
			</div>
			<div class="column">
				<div class="card">
					<div class="card-content">
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black ">Publié le  : </span><span
										class="subtitle">{{ \Carbon\Carbon::parse($ad->created_at)->format('d/m/Y')}}</span>
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span><span
										class="subtitle">Recherche de foncier</span></p>

						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation(s) : </span>
							@if(count($ad->cities))
								<p><span class="subtitle">Villes : {{$ad->cities->pluck('name')->implode(', ') }}</span>
								</p>
							@endif

							@if(count($ad->departments))
								<p>
									<span class="subtitle">Départements : {{$ad->departments->pluck('name')->implode(', ') }}</span>
								</p>
							@endif

							@if(count($ad->regions))
								<p>
									<span class="subtitle">Régions : {{$ad->regions->pluck('name')->implode(', ') }}</span>
								</p>
							@endif
						</div>
						<div class="content">
							@if(count($ad->landSeekAd->priceRanges))
								<p><span class="is-size-4  has-text-black">Prix recherché : </span>
									@foreach($ad->landSeekAd->priceRanges as $priceRange)
										<span class="subtitle has-text-black">{{$priceRange->price }}€</span><br>
									@endforeach
									@endif
								</p>
						</div>
					</div>
					<footer class="card-footer">
						<button id="open-modal-message" type="button" class="card-footer-item button is-link">
								 <span class="icon is-small">
								<i class="fas fa-reply"></i>
								</span>
							<span> Répondre à l'annonce</span>
						</button>
						{!! Form::open(['route'=>'favoriteAds.create']) !!}
						<input name="ad_id" value="{{$ad->id}}" type="hidden">
						<button class="card-footer-item button is-link is-light">
							 <span class="icon is-small">
									<i class="fas fa-save"></i>
								</span>
							<span> Sauvegarder l'annonce</span>
						</button>
						{!! Form::close() !!}
					</footer>
				</div>
			</div>
		</div>
		{!! Form::open(['route' => 'adMessages.create', 'method'=>'post']) !!}
		<div class="modal">
			<div class="modal-background"></div>
			<div class="modal-content">
				<div class="card">
					<div class="card-content">
						<h3 class="title is-3 has-text-centered has-text-black ">Envoyer un message au porteur de
							projet</h3>
					</div>
					<div class="card-content">
						<div class="container">
							<div class="field">
								<label class="label">Votre message :</label>
								<div class="field">
									<div class="control">
										<input type="hidden" name="ad_id" value="{{$ad->id}}">
										<textarea required name="content" class="textarea is-medium"
												  placeholder="Votre message..."></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
					<footer class="card-footer">
						<div class="buttons card-footer-item">
							<button type="submit" class="button is-link">
								<span>Envoyer</span></button>
						</div>
						<button id="close-modal" class="modal-close is-large" aria-label="close"></button>
					</footer>
				</div>
			</div>
		</div>
		{!! Form::close() !!}
		<hr class="navbar-divider">
		<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
		<div class="columns is-multiline is-mobile is-centered">

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Type d'installation souhaité</p>
				<p class="has-text-centered">{{$ad->landSeekAd->installationType->name}}</p>
			</div>

			@if($ad->landSeekAd->offerGenre)
				<div class="column is-one-quarter ">
					<p class="has-text-link is-size-5 has-text-centered"> Accès au foncier souhaité </p>
					<p class="has-text-centered">{{$ad->landSeekAd->offerGenre->name}}</p>
				</div>
			@endif

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Souhaite s'installer en bio</p>

				@if ($ad->landSeekAd->is_bio === 1)
					<p class="has-text-centered">Oui</p>
				@elseif ($ad->landSeekAd->is_bio === 0)
					<p class="has-text-centered">Non</p>
				@else
					<p class="has-text-centered">Ne sais pas</p>
				@endif
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Surface(s) recherchée(s)(en ha)</p>
				@foreach ($ad->landSeekAd->surfaceRanges as $surfaceRangeSeek)
					@if($surfaceRangeSeek->surface !== '')
						<p class="has-text-centered">{{$ad->landSeekAd->surfaceRanges->pluck('surface')->implode(', ') }}</p>
					@else
						<p class="has-text-centered">Non renseigné</p>
					@endif
				@endforeach
			</div>
			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Production(s) envisagée(s)</p>
				@foreach ($ad->landSeekAd->productionGenres as $productionGenresSeek)
					@if($productionGenresSeek->name !== '')
						<p class="has-text-centered">{{$productionGenresSeek->name}}</p>
					@else
						<p class="has-text-centered">-</p>
					@endif
				@endforeach
			</div>

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered">Habitation(s) et bâti(s) recherché(s)</p>

				@if($ad->landSeekAd->has_farm_buildings === 1)
					<p class="has-text-centered">Avec des bâtis agricoles existants</p>
				@else
					<p class="has-text-centered">Sans bâtis agricoles existants</p>
				@endif
				@if($ad->landSeekAd->has_houses === 1)
					<p class="has-text-centered">Avec une maison d’habitation existante</p>
				@else
					<p class="has-text-centered">Sans maison d’habitation existante</p>
				@endif
			</div>

		</div>

		<hr class="navbar-divider">
		<div class="content">
			<h3 class="title is-3">Description du projet</h3>
			<p> {{$ad->about_project_content}}</p>
		</div>

		<div class="content">
			<h3 class="title is-3">A propos du porteur de projet</h3>
			<p> {{$ad->about_content}}</p>
		</div>

		@if($ad->landSeekAd->experience_farming)
			<div class="content">
				<h3 class="title is-3">Expérience du porteur de projet dans le domaine agricole</h3>
				<p> {{$ad->landSeekAd->experience_farming}}</p>
			</div>
		@endif
		<div class="content">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<div class="box has-background-white-ter ">
						<article class="media">
							<div class="media-content">
								<div class="content has-text-centered ">
									<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette annonce
										?</p>
									<button id="open-modal-message" class="button is-link  is-large">
									 	<span class="icon is-small">
										<i class="fas fa-reply"></i>
										</span>
										<span> Répondre à l'annonce</span>
									</button>
								</div>
							</div>
						</article>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


@include('components.partnering')
@include('components.support_terre_liens')

