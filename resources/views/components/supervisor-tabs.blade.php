<div class="tabs">
	<ul>
		<li class="{{ Route::current()->getName() === 'supervisor.index' || Route::current()->getName() === 'supervisor.show'  ? 'is-active' : '' }}">
			<a class="" href="{{route('supervisor.index')}}">Suivi de l'activité sur votre territoire</a></li>
		<li class="{{ Route::current()->getName() === 'supervisor.report' || Route::current()->getName() === 'supervisor.report'  ? 'is-active' : '' }}">
			<a class="" href="{{route('supervisor.report')}}">Rapports et indicateurs</a></li>
		<li class="{{ Route::current()->getName() === 'supervisor.projectDataKeysEdit' || Route::current()->getName() === 'supervisor.projectDataKeysEdit'  ? 'is-active' : '' }}">
			<a class="" href="{{route('supervisor.projectDataKeysEdit')}}">Administration des indicateurs</a></li>
		<li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a class=""
					href="{{route('threads.index')}}">Messagerie</a></li>
		<li class="{{ Route::current()->getName() === 'supervisor.help' ? 'is-active' : '' }}"><a class=""
					href="{{route('supervisor.help')}}">Aide et ressources</a></li>
	</ul>
</div>