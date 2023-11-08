<div>
    <h3 class="title is-4">Description du projet</h3>
    <p>{!! nl2br($ad->about_project_content ??"") !!}</p>
</div>


@if($ad->about_content)
    <div>
        <h3 class="title is-4">A propos du porteur de projet</h3>
        <p>{!! nl2br($ad->about_content ?? "") !!}</p>
    </div>
@endif
