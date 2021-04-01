<div class="tile__pre-title">
	@if(isset($ad->attributionAd->adStatus))
		@if($ad->attributionAd->adStatus->id === \App\Models\AdStatus::APPROVE_ID)
			<span class="tile__date">Publié {{$ad->published_on_diff}}</span>
		@else
			<span class="tile__date">Crée  {{$ad->created_at_diff}}</span>
		@endif
	@else
		<span class="tile__date">Crée  {{$ad->created_at_diff}}</span>
	@endif
	@if(isset($ad->is_partner) && $ad->is_partner === 1 )
		<ul class="custom-tags">
			<li class="custom-tag warning">Annonce certifiée</li>
		</ul>
	@endif
</div>
<p class="tile__title">{{$ad->title ?? "Titre de l'annonce non renseigné"}}
</p>
<div class="tile__intro">
	@if(isset($ad->about_project_content))
		<p>{{ Illuminate\Support\Str::limit($ad->about_project_content, 200)}}</p>
	@else
		Pas de description renseignée pour cette annonce
	@endif
</div>