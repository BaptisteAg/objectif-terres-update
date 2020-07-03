@section('title', $ad->title)
<section class="section">
	<div class="container ">

		<nav class="breadcrumb" aria-label="breadcrumbs">
			<ul>
				<li><a class="breadcrumb__link" href="#">Annonces</a></li>
				<li><a class="breadcrumb__link" href="#">Opportunités professionnelles</a></li>
			</ul>
		</nav>
		<h1 class="title has-text-link">{{$ad->title}}</h1>
		@if(auth()->user()->role >= 1)
			@include('pages.ads.partials.moderator-options')
		@endif

		<div class="columns">
			<div id="slider-container" class="column is-two-thirds ">
				<div id="ad-images" class="carousel ">
					@if(count($ad->documents) <= 0)
						<div class="card carousel-item ad-carousel ">
							<div class="card-image">
								<figure class="image is-2by1">
									<img src="https://picsum.photos/480/320" alt="picsum">
								</figure>
							</div>
						</div>
						<div class="card carousel-item  ad-carousel">
							<div class="card-image">
								<figure class="image is-2by1">
									<img src="https://picsum.photos/480/320" alt="picsum">
								</figure>
							</div>
						</div>
					@else
						@foreach($ad->documents as $document)
							<div class="card">
								<div class="card-image">
									<figure class="image is-2by1">
										@if($document->path === "0")
											<img src="https://picsum.photos/480/320" alt="picsum">
										@else
											<img src="{{URL::asset($document->path)}}" alt="Placeholder image">
										@endif
									</figure>
								</div>
							</div>
						@endforeach
					@endif
				</div>
			</div>
			<div class="column">
				<div class="card">
					<div class="card-content">
						<div class="content">
							@if(is_null($ad->published_on))
								<p><span class="is-size-5  has-text-black ">Annonce soumise le : </span><span
											class="subtitle">{{ $ad->created_at}}</span>
								</p>
							@else
								<p><span class="is-size-5  has-text-black ">Publié le  : </span><span
											class="subtitle">{{ $ad->published_on}}</span>
								</p>
							@endif
						</div>
						<div class="content">
							<p><span class="is-size-5  has-text-black ">Publié par  : </span>
								@if(auth()->user()->role >=1)
									<span class="subtitle"><a href="{{route('user.show', $ad->userPp->id)}}">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</a></span>
								@else
									<span class="subtitle">{{ $ad->userPp->first_name}} {{$ad->userPp->name}}</span>
								@endif
							</p>
						</div>
						<div class="content">
							<p><span class="is-size-5 is-capitalized has-text-black">Catégorie : </span>
									<span class="subtitle">{{$ad->ad_type_full_name}}</span>
							</p>
						</div>
						<div class="content">
							<span class="is-size-5 is-capitalized has-text-black">Localisation(s) : </span>
							<p><span class="is-size-6 is-italic">Commune(s) :</span><span
										class="subtitle">{{$ad->cities->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Département(s) :</span><span
										class="subtitle">{{$ad->departments->pluck('name')->implode(', ') }}</span></p>
							<p><span class="is-size-6 is-italic">Région(s) :</span><span
										class="subtitle">{{$ad->regions->pluck('name')->implode(', ') }}</span></p>
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
						@if($ad->userPp->accept_share_contact_infos === 1)
							<div class="content">
								<p><span class="is-size-5 has-text-black">N° de téléphone du porteur de projet : </span>
								</p>
								<p><span class="subtitle">{{$ad->userPp->phone}}</span></p>
							</div>
						@endif
					</div>
					@include('pages.ads.partials.buttons-favorite-and-message')
				</div>
			</div>
		</div>

		@include('pages.ads.partials.adMessageModal')

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
		<div class="section">
			@include('pages.ads.partials.threadsDisplay')
		</div>
	</div>

</section>
@include('components.partnering')
@include('components.support-terre-liens')


