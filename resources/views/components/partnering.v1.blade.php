<section class="section bg-l-pearl bg-trame_champs_light" style="background:rgba(0,0,0,0.05)">
    <div class="container is-fluid">
        @if(Route::currentRouteName() ==="minstaller-comme-paysan")
            <h2 class="title is-2 has-text-centered">Ils peuvent vous accompagner dans votre projet</h2>
        @elseif(Route::currentRouteName() ==="transmettre-ma-ferme")
            <h2 class="title is-2 has-text-centered"> Ils peuvent vous accompagner à transmettre</h2>
        @elseif(Route::currentRouteName() === "trouver-une-terre-ou-des-financements")
            <h2 class="title is-2 has-text-centered"> Ils peuvent vous accompagner au-delà du volet foncier de votre
                projet </h2>
        @else
            <h2 class="title is-2 has-text-centered">Nos partenaires</h2>
        @endif
        <div id="carousel-partners" class=" carousel carousel-large has-text-centered ">
            <div class="mr-50 ml-50">
                <figure class="image is-128x128 is-inline-block">
                    <img src="{{asset('/images/logo-partenaires/FADEAR-cmjn-01-01.png')}}" alt="logo adear">
                </figure>
                <div>
                    <p class="has-text-weight-bold">Les ADEAR</p>
                    <p> Ce sont les associations de développement de l’emploi agricole et rural. Présentes dans une
                        soixantaine de départements, elles ont mis en place un dispositif d’accompagnement des
                        porteurs de projet qui souhaitent s’installer en agriculture ou transmettre. Elles
                        soutiennent les valeurs de l’agriculture paysanne et accompagnent une grande diversité de
                        projets.
                        Plus d'informations <a target="_blank" href="http://www.jeminstallepaysan.org/">en
                            cliquant sur ce lien</a>
                    </p>
                </div>
            </div>
            <div class="mr-50 ml-50">
                <figure class="image is-128x128 is-inline-block">
                    <img style="width : 80%; margin-left : auto ; margin-right: auto"
                         src="{{asset('/images/logo-partenaires/LOGO_RESEAU_CIVAM_FOND_TRANSPARENT.PNG')}}"
                         alt="logo civam">
                </figure>
                <div>
                    <p class="has-text-weight-bold">Les CIVAM</p>
                    <p> Ce sont les Centres d’Initiatives pour Valoriser l’Agriculture et le Milieu rural. Ils ont
                        pour mission de rassembler agriculteurs et ruraux d’un même territoire pour développer de
                        nouvelles initiatives, se former, échanger, expérimenter et innover. Plus de 140 groupes
                        existent sur l’ensemble du territoire.
                        Plus d'informations <a target="_blank" href="http://www.civam.org/">en
                            cliquant sur ce lien</a>
                    </p>
                </div>
            </div>
            @if( Route::currentRouteName() !="trouver-une-terre-ou-des-financements" && Route::currentRouteName() != "transmettre-ma-ferme")
                <div class="mr-50 ml-50">
                    <figure class="image is-128x128 is-inline-block">
                        <img src="{{asset('/images/logo-partenaires/logo_inpact_Plan de travail 1.png')}}"
                             alt="logo inpact">
                    </figure>
                    <div>
                        <p class="has-text-weight-bold">InPACT</p>
                        <p> Initiatives pour une Agriculture citoyenne et territoriale est un regroupement de 10
                            réseaux
                            associatifs agricoles partageant une même vision de l’agriculture. Avec des champs
                            d’action
                            et des approches de l’accompagnement variés, le réseau InPACT dont est membre Terre de
                            Liens
                            est un acteur central de l’accompagnement à l’installation et à la transmission.
                            Des déclinaisons régionales ou plus locales d’InPACT associent parfois une diversité
                            plus
                            grande encore d’acteurs qui font des pas de côté en agriculture (GAB, association
                            d’éducation populaire, couveuse d’activité, ...).
                            Plus d'informations <a target="_blank"
                                                   href="http://agricultures-alternatives.org/rubrique12.html">en
                                cliquant sur ce lien</a>
                        </p>
                    </div>
                </div>
            @endif
            <div class="mr-50 ml-50">
                <figure class="image is-128x128 is-inline-block">
                    <img src="{{asset('/images/logo-partenaires/logo IA fond transparent.png')}}" alt="logo aocg">
                </figure>
                <div>
                    <p class="has-text-weight-bold">Les AFOCG</p>
                    <p> Ce sont les Associations de Formation collective à la gestion. Elles ont pour mission de
                        rendre leur adhérents autonome dans leur comptabilité et dans leur gestion, et de les
                        accompagner dans les différentes étapes de développement de leur entreprise (création,
                        évolution, etc.).
                    </p>
                </div>
            </div>
            <div class="mr-50 ml-50">
                <figure class="image is-128x128 is-inline-block">
                    <img style="width : 80%; margin-left : auto; margin-right: auto"
                         src="{{asset('/images/logo-partenaires/logo-fnab-new.png')}}" alt="logo gab">
                </figure>
                <div>
                    <p class="has-text-weight-bold">Les GAB</p>
                    <p>Les groupements d’agriculture biologique sont présents au niveau départemental. Ils
                        accueillent et accompagnent les porteurs de projet en agriculture biologique ou en
                        conversion à la bio, organisent des formations et des temps d’échanges entre agriculteurs et
                        consommateurs
                        Plus d'informations <a target="_blank" href="https://www.fnab.org/ ">en
                            cliquant sur ce lien</a>
                    </p>
                </div>
            </div>
            @if(Route::currentRouteName() != "transmettre-ma-ferme")
                <div class="mr-50 ml-50">
                    <figure class="image is-128x128 is-inline-block">
                        <img src="{{asset('/images/logo-partenaires/Logo Reneta - RVB.png')}}" alt="logo reneta">
                    </figure>
                    <div>
                        <p class="has-text-weight-bold">Le RENETA</p>
                        <p> C’est le réseau national des espaces test agricoles, dispositifs permettant à des
                            porteurs
                            de projet de tester la viabilité et la vivabilité de leur projet agricole
                            Plus d'informations <a target="_blank" href="http://www.sinstallerenagriculture.fr/">en
                                cliquant sur ce lien</a>
                        </p>
                    </div>
                </div>
            @endif
            {{--                @if( Route::currentRouteName() !="minstaller-comme-paysan" && Route::currentRouteName() != "transmettre-ma-ferme")--}}
            {{--                    <div class="mr-50 ml-50">--}}
            {{--                        <figure class="image is-128x128 is-inline-block">--}}
            {{--                            <img src="{{asset('/images/logo-partenaires/agricultures-et-territoires-logo.png')}}"--}}
            {{--                                 alt="logo chambres agriculture">--}}
            {{--                        </figure>--}}
            {{--                        <div>--}}
            {{--                            <p class="has-text-weight-bold">Les Chambres d’agriculture</p>--}}
            {{--                            <p> Présentes dans tous les départements, elles sont des interlocutrices importantes pour--}}
            {{--                                les--}}
            {{--                                porteurs de projets et les agriculteurs (gestion des démarches administratives, conseils--}}
            {{--                                techniques et économiques, etc.)--}}
            {{--                                Plus d'informations <a target="_blank" href="http://www.sinstallerenagriculture.fr/">en--}}
            {{--                                    cliquant sur ce lien</a>--}}
            {{--                            </p>--}}
            {{--                        </div>--}}
            {{--                    </div>--}}
            {{--                @endif--}}
            @if( Route::currentRouteName() !="trouver-une-terre-ou-des-financements" && Route::currentRouteName() != "transmettre-ma-ferme")
                <div class="mr-50 ml-50">
                    <figure class="image is-128x128 is-inline-block">
                        <img src="{{asset('/images/logo/logo_TdL_cartouche_blanc-rouge_500.png')}}"
                             alt="logo terre de liens">
                    </figure>
                    <div>
                        <p class="has-text-weight-bold">Terre de Liens</p>
                        <p>Le réseau associatif Terre de Liens peut vous accueillir, vous orienter et vous
                            accompagner
                            sur le volet foncier de votre projet.
                            {{--                            Plus d'informations <a target=_blank href="">en--}}
                            {{--                                cliquant sur ce lien</a>--}}
                        </p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bulma-carousel@4.0.4/dist/js/bulma-carousel.min.js"></script>
<script>
    bulmaCarousel.attach('#carousel-partners', {
        slidesToScroll: 1,
        slidesToShow: 4,
        loop: true,
        navigationSwipe: true,
    });
</script>
