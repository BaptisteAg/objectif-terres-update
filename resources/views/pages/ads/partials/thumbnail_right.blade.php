<div class="tile__pre-title">
    <span class="tile__date">Publié {{$ad->created_at_diff}}</span>
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