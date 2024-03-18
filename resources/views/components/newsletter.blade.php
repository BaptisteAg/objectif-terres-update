<section class="bg-beige is-flex is-justify-content-center newsletter mt-6">
    <div class="columns container is-desktop p-3-mobile">
        <div class="column px-0 is-three-fifths is-flex is-flex-direction-column is-justify-content-center">
            <h2 class="title has-text-centered has-text-left-desktop mb-5">Newsletter Terre de Liens</h2>
            <p class="has-text-centered has-text-left-desktop">Restez informé des campagnes et de l'actualité en
                vous inscrivant à la newsletter.</p>
        </div>
        <div class="column is-flex is-flex-direction-column is-justify-content-center">
            <newsletter :csrf_token="'{{ csrf_token() }}'"></newsletter>
        </div>
    </div>
</section>