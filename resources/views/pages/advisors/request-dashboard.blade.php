@extends ('default')

@section ('title', 'Espace de suivi')

@section('main-content')

	<div class="columns">
		<div class="column is-half">
			<nav class="panel">
				<div class="tabs is-toggle is-fullwidth">
					<ul>
						<li class="is-active">
							<a>
								<span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
								<span>Profil</span>
							</a>
						</li>
						<li>
							<a>
								<span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span>
								<span>Projet</span>
							</a>
						</li>
						<li>
							<a>
								<span class="icon is-small"><i class="fas fa-film" aria-hidden="true"></i></span>
								<span>Annonces</span>
							</a>
						</li>
					</ul>
				</div>
				<a class="panel-block is-active">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					bulma
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					marksheet
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					minireset.css
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					jgthms.github.io
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-code-branch" aria-hidden="true"></i>
    </span>
					daniellowtw/infboard
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-code-branch" aria-hidden="true"></i>
    </span>
					mojs
				</a>
				<label class="panel-block">
					<input type="checkbox">
					remember me
				</label>
				<div class="panel-block">
					<button class="button is-link is-outlined is-fullwidth">
						Reset all filters
					</button>
				</div>
			</nav>
		</div>
		<div class="column is-half">
			<nav class="panel">
				<div class="tabs is-toggle is-fullwidth">
					<ul>
						<li class="is-active">
							<a>
								<span class="icon is-small"><i class="fas fa-image" aria-hidden="true"></i></span>
								<span>Pictures</span>
							</a>
						</li>
						<li>
							<a>
								<span class="icon is-small"><i class="fas fa-music" aria-hidden="true"></i></span>
								<span>Music</span>
							</a>
						</li>
						<li>
							<a>
								<span class="icon is-small"><i class="fas fa-film" aria-hidden="true"></i></span>
								<span>Videos</span>
							</a>
						</li>
						<li>
							<a>
								<span class="icon is-small"><i class="far fa-file-alt" aria-hidden="true"></i></span>
								<span>Documents</span>
							</a>
						</li>
					</ul>
				</div>
				<a class="panel-block is-active">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					bulma
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					marksheet
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					minireset.css
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-book" aria-hidden="true"></i>
    </span>
					jgthms.github.io
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-code-branch" aria-hidden="true"></i>
    </span>
					daniellowtw/infboard
				</a>
				<a class="panel-block">
    <span class="panel-icon">
      <i class="fas fa-code-branch" aria-hidden="true"></i>
    </span>
					mojs
				</a>
				<label class="panel-block">
					<input type="checkbox">
					remember me
				</label>
				<div class="panel-block">
					<button class="button is-link is-outlined is-fullwidth">
						Reset all filters
					</button>
				</div>
			</nav>
		</div>
	</div>

@endsection