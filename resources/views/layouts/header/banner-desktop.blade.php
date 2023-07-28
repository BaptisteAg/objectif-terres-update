<div id="top-bar__1__desktop">
    <header-page id="header-page" inline-template
                 :old-search-values="{{json_encode(old())}}">
        <section class="header is-flex is-justify-content-space-between is-align-items-center">
            <div class="is-flex">
                <figure class="image is-128x128">
                    <a class=""
                       href="{{route ('home')}}">
                        <img class="is-rounded"
                             src="/images/logo/logo_TdL_cartouche_blanc-rouge_500.png"
                             alt="objectif-terres-logo">
                    </a>
                </figure>
                <div class="pl-4 is-flex is-flex-direction-column is-justify-content-center pl-">
                    <h1 class="title mb-0 mt-0">Objectif Terres</h1>
                    <p class="mt-0">Faites pousser votre projet agricole</p>
                </div>
            </div>
            <div class="is-flex is-align-items-center">
                <a class="button is-danger">Nous soutenir</a>
                <span class="icon ml-5">
                    <span class="mdi mdi-24px mdi-bell-outline"></span>
                </span>
                <span class="icon ml-5">
                    <span class="mdi mdi-24px mdi-email-outline"></span>
                </span>
                <span class="icon-text ml-5">
                  <span class="icon">
                    <span class="mdi mdi-24px mdi-account-outline"></span>
                  </span>
                  <span>Utilisateur</span>
                </span>
            </div>
        </section>

    </header-page>
</div>
