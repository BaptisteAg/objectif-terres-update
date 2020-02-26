<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'moderator.index' ? 'is-active' : '' }}"><a href="{{route('moderator.index')}}">Vos annonces attribuées</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a href="{{route('threads.index')}}">Messagerie</a></li>
		<li><a>Aide</a></li>
	</ul>
</div>