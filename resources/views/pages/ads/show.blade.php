@extends('default')

@section('title', 'Titre de l\'annonce')


@section('main-content')
    <section class="section is-medium ">
        <div class="container ">
            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="#">Annonces</a></li>
                    <li><a href="#">Offres foncière</a></li>
                    <li><a href="#">Rhônes-Alpes</a></li>
                </ul>
            </nav>
            <h1 class="title has-text-link">Vends 10 hectares de terres</h1>
            <div class="columns">
                <div class=" column is-two-thirds ">
                    <div class="card">
                        <div class="card-image">
                            <figure class="image is-3by2">
                                <img src="https://picsum.photos/480/320" alt="Placeholder image">
                            </figure>
                        </div>
                    </div>
                    <p class="has-text-grey is-size-6">15 janvier 2020</p>
                    <p class="is-size-4"> 3 000 € /mois</p>
                </div>
                <div class="column">
                    <div class="card">
                        <div class="card-content">
                            <p><span class="title is-capitalized">Date : </span><span class="subtitle">15 janvier 2020</span>
                            </p>

                        </div>
                        <footer class="card-footer">
                            <button class="card-footer-item button is-info">Répondre à l'annonce</button>
                            <button class="card-footer-item button is-info is-light">Voir son numéro</button>
                        </footer>
                    </div>
                </div>
            </div>
        </div>


        {{--    @include('components.support_terre_liens')--}}
    </section>

@endsection