<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'advisors.index' ? 'is-active' : '' }}"><a href="{{route('advisors.index')}}">Suivi des PP</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a href="{{route('threads.index')}}">Messagerie</a></li>
		<li class="{{ Route::current()->getName() === 'advisors.index' ? 'is-active' : '' }}"><a href="{{route('advisors.index')}}">Aide & ressources</a></li>
	</ul>
</div>