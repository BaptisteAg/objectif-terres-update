<div class="tabs is-centered is-medium">
	<ul>
		@if(auth()->user()->supportRequests()->count())
			<li class="{{ Route::current()->getName() === 'support-request.show' ? 'is-active' : '' }}">
				<a href="{{route ('support-request.show')}}">
					<span class="icon is-small">
						<i class="fas fa-rocket" aria-hidden="true"></i>
					</span>
					<span>Mon Accompagnement</span>
				</a>
			</li>
		@endif
		@if(auth()->user()->ads()->count())
			<li class="{{ Route::current()->getName() === 'ads.list' ? 'is-active' : '' }}">
				<a href="{{route ('ads.list')}}">
					<span class="icon is-small">
						<i class="fas fa-newspaper" aria-hidden="true"></i>
					</span>
					<span>Mes Annonces</span>
				</a>
			</li>
		@endif
		<li class="{{Route::current()->getName() === 'researches.show' ? 'is-active' : '' }}">
			<a href="{{route('researches.show')}}">
				<span class="icon is-small">
					<i class="fas fa-save" aria-hidden="true"></i>
				</span>
				<span>Mes Recherches</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'favoriteAds.show' ? 'is-active' : '' }}">
			<a href="{{route('favoriteAds.show')}}">
				<span class="icon is-small">
					<i class="fas fa-star" aria-hidden="true"></i>
				</span>
				<span>Annonces favorites</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'threads.index' ? 'is-active' : '' }}">
			<a href="{{route('threads.index')}}">
				<span class="icon is-small">
					<i class="fas fa-comments"></i>
				</span>
				<span>Messagerie</span>
			</a>
		</li>
		<li class="{{ Route::current()->getName() == 'user.edit' ? 'is-active' : '' }}">
			<a href="{{route('user.edit')}}">
				<span class="icon is-small">
					<i class="fas fa-user"></i>
				</span>
				<span>Mes informations</span>
			</a>
		</li>
	</ul>
</div>