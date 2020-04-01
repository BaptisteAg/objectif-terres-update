<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'advisor.index' || Route::current()->getName() === 'advisor.show' ? 'is-active' : '' }}"><a href="{{route('advisor.index')}}">Suivi des PP</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a href="{{route('threads.index')}}">Messagerie</a></li>
		<li class="{{ Route::current()->getName() === 'advisor.index' ? 'is-active' : '' }}"><a href="{{route('advisor.index')}}">Aide & ressources</a></li>
	</ul>
</div>