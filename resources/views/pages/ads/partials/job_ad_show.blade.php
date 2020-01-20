@section('title', $ad->jobAd->title)
<section class="section is-medium ">
	<div class="container ">
		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a href="#">Annonces</a></li>
				<li><a href="#">Opportunités professionnelles</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->jobAd->title}}</h1>
		<div class="columns">
			<div class=" column is-two-thirds ">
				<div id="ad_images" class="carousel">
					@foreach($ad->documents as $document)
						<div class="card">
							<div class="card-image">
								<figure class="image is-2by1">
									@if($document->path === "0")
										<img src="https://picsum.photos/480/320" alt="pop">
									@else
										<img src="{{$document->path}}" alt="Placeholder image">
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
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span>
								@if($ad->jobAd->is_offer === 1)
									<span class="subtitle">Proposition opportunité professionnelle</span>
								@else
									<span class="subtitle">Recherche opportunité professionnelle</span>
								@endif
							</p>
						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation(s) : </span>
							<p><span class="is-size-6 is-italic">Commune(s) :</span><span class="subtitle">{{$ad->cities->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Département(s) :</span><span class="subtitle">{{$ad->departments->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Région(s) :</span><span class="subtitle">{{$ad->regions->pluck('name')->implode(', ') }}</span></p>
						</div>
						<div class="content">
							<p><span class="is-size-4  has-text-black">Statut :</span>
								@if ($ad->jobAd->jobStatus)
									<span class="subtitle has-text-black">{{$ad->jobAd->jobStatus->name}}</span>
								@else
									<span class="subtitle has-text-black">Non précisé</span>
								@endif
							</p>
						</div>
					</div>
					<footer class="card-footer">
						<button class="card-footer-item button is-link">
								 <span class="icon is-small">
								<i class="fas fa-reply"></i>
								</span>
							<span> Répondre à l'annonce</span>
						</button>
						<button class="card-footer-item button is-link is-light">
							 <span class="icon is-small">
									<i class="fas fa-save"></i>
								</span>
							<span> Sauvegarder l'annonce</span>
						</button>
					</footer>
				</div>
			</div>
		</div>
		<hr class="navbar-divider">
		<h3 class="title is-3 has-text-centered">Caractéristiques du projet</h3>
		<div class="columns is-multiline is-mobile is-centered">

			<div class="column is-one-quarter ">
				<p class="has-text-link is-size-5 has-text-centered"> Activité(s) agricole(s)</p>
				<p class="has-text-centered">
					<span>{{$ad->jobAd->agriculturalActivity->pluck('name')->implode(', ') }}</span>
				</p>
			</div>

			@if($ad->jobAd->educationLevel)
				<div class="column is-one-quarter ">
					<p class="has-text-link is-size-5 has-text-centered"> Niveau de formation agricole</p>
					<p class="has-text-centered">{{$ad->jobAd->educationLevel->name}}</p>
				</div>
			@endif

			@if($ad->jobAd->experience_farming)
				<div class="column is-one-quarter ">
					<p class="has-text-link is-size-5 has-text-centered"> Expérience dans le monde agricole (en
						année)</p>
					<p class="has-text-centered">{{$ad->jobAd->experience_farming}}</p>
				</div>
			@endif

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
		<div class="content">
			<div class="columns is-mobile is-centered">
				<div class="column is-half">
					<div class="box has-background-white-ter ">
						<article class="media">
							<div class="media-content">
								<div class="content has-text-centered ">
									<p class="has-text-centered is-size-4">Vous souhaitez répondre à cette annonce
										?</p>
									<button class="button is-link  is-large">
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


