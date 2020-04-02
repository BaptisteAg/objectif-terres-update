<div class="tabs is-centered is-medium">
	<ul>
		<li class="{{ Route::current()->getName() === 'ads.list' ? 'is-active' : '' }}"><a
					href="{{route ('ads.list')}}"><span class="icon is-small">
											<i class="far fa-newspaper" aria-hidden="true"></i></span>
				<span>Mes annonces</span>
			</a>
		</li>
		<li class="{{Route::current()->getName() === 'researches.show' ? 'is-active' : '' }}"><a
					href="{{route('researches.show')}}"><span class="icon is-small">
											<i class="fas fa-save" aria-hidden="true"></i></span>
				<span>Mes recherches sauvegardées</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'favoriteAds.show' ? 'is-active' : '' }}">
			<a
					href="{{route('favoriteAds.show')}}"><span class="icon is-small">
											<i class="fas fa-star" aria-hidden="true"></i></span>
				<span>Mes annonces favorites</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'threads.index' ? 'is-active' : '' }}">
			<a
					href="{{route('threads.index')}}"><span class="icon is-small">
											<i class="fas fa-comments"></i></span>
				<span>Ma messagerie</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'user.edit' ? 'is-active' : '' }}">
			<a
					href="{{route('user.edit')}}"><span class="icon is-small">
											<i class="fas fa-user"></i></span>
				<span>Mes informations</span>
			</a>
		</li>
	</ul>
</div>