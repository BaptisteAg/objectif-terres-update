<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'supervisor.index' || Route::current()->getName() === 'supervisor.show'  ? 'is-active' : '' }}">
			<a href="{{route('supervisor.index')}}">Suivi des demandes d'accomapgnement</a></li>
		<li class=""><a href="/">Rapports et indicateurs</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a
					href="{{route('threads.index')}}">Messagerie</a></li>
		<li class="{{ Route::current()->getName() === 'supervisor.help' ? 'is-active' : '' }}"><a
					href="{{route('supervisor.help')}}">Aide et ressources</a></li>
	</ul>
</div>