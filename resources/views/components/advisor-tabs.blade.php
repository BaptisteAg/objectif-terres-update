<div class="mt-25">
    <div class="tabs">
        <ul class="is-justify-content-center">
            <li class="{{ Route::current()->getName() === 'advisor.index' || Route::current()->getName() === 'advisor.show' ? 'is-active' : '' }}">
                <a class="" href="{{route('advisor.index')}}">Suivi de l'activité sur votre territoire</a></li>
            <li class="{{ Route::current()->getName() === 'threads.index' ? 'is-active' : '' }}"><a class=""
                                                                                                    href="{{route('threads.index')}}">Messagerie</a>
            </li>
            <li class="{{ Route::current()->getName() === 'advisor.help' ? 'is-active' : '' }}"><a class=""
                                                                                                   href="{{route('advisor.help')}}">Aide
                    & ressources</a></li>
        </ul>
    </div>
</div>
