@if(auth()->user()->role === 1)
    <div class="content ml-20 mt-10">
        <a class="text_size large" href="{{route('moderator.index')}}">
            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
            <span>Aller sur votre espace modérateur </span>
        </a>
    </div>
@elseif(auth()->user()->role === 2 )
    <div class="content ml-20 mt-10">
        <a class="text_size large" href="{{route('advisor.index')}}">
            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
            <span>Aller sur votre espace primo-accueillant </span>
        </a>
    </div>
@elseif(auth()->user()->role === 3)
    <div class="content ml-20 mt-10">
        <a class="text_size large" href="{{route('supervisor.index')}}">
            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
            <span>Aller sur votre tableau de bord </span>
        </a>
    </div>
@endif