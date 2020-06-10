<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'moderator.index' || Route::current()->getName() === 'moderator.show'   ? 'is-active' : '' }}"><a class="without-link-styles" href="{{route('moderator.index')}}">Vos annonces attribuées</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a class="without-link-styles" href="{{route('threads.index')}}">Messagerie</a></li>
		<li class="{{ Route::current()->getName() === 'moderator.help' ? 'is-active' : '' }}"><a class="without-link-styles" href="{{route('moderator.help')}}">Aide & ressources</a></li>
	</ul>
</div>