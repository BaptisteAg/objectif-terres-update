<div class="tabs is-centered is-medium">
	<ul>
		<li class="{{ Route::current()->getName() === 'support-request.show' ? 'is-active' : '' }}">
			<a class="" href="https://terredeliens.my.site.com/objectifterres/s/mes-demandes" target="_blank">
				<span class="icon is-small">
					<i class="fas fa-rocket" aria-hidden="true"></i>
				</span>
				<span>Mon Accompagnement</span>
			</a>
		</li>
		@if(auth()->user()->ads()->count())
			<li class="{{ Route::current()->getName() === 'ads.list' ? 'is-active' : '' }}">
				<a class="" href="{{route ('ads.list')}}">
					<span class="icon is-small">
						<i class="fas fa-newspaper" aria-hidden="true"></i>
					</span>
					<span>Mes Annonces</span>
				</a>
			</li>
		@endif
		<li class="{{Route::current()->getName() === 'researches.show' ? 'is-active' : '' }}">
			<a class="" href="{{route('researches.show')}}">
				<span class="icon is-small">
					<i class="fas fa-save" aria-hidden="true"></i>
				</span>
				<span>Mes Recherches</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'favoriteAds.show' ? 'is-active' : '' }}">
			<a class="" href="{{route('favoriteAds.show')}}">
				<span class="icon is-small">
					<i class="fas fa-star" aria-hidden="true"></i>
				</span>
				<span>Annonces favorites</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'threads.index' ? 'is-active' : '' }}">
			<a class="" href="{{route('threads.index')}}">
				<span class="icon is-small">
					<i class="fas fa-comments"></i>
				</span>
				<span>Messagerie</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'user.edit' ? 'is-active' : '' }}">
			<a class="" href="{{route('user.edit', auth()->user()->id)}}">
				<span class="icon is-small">
					<i class="fas fa-user"></i>
				</span>
				<span>Mes informations</span>
			</a>
		</li>
	</ul>
</div>