<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'supervisor.index' || Route::current()->getName() === 'supervisor.show'  ? 'is-active' : '' }}"><a href="{{route('supervisor.index')}}">Suivi des annonces</a></li>
		<li class=""><a href="/">Rapports et indicateurs</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a href="{{route('threads.index')}}">Messagerie</a></li>
	</ul>
</div>