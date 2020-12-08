@extends ('default')

@section ('title', 'Liste des utilisateurs Terre de Liens')


@section('main-content')

    <div class="content ml-80 mt-30">
        <a class="text_size large"
           href="{{\Laravel\Nova\Nova::path()}}">
            <span class="icon is-medium"><i class="fas fa-arrow-left"></i></span>
            <span>Retour dans l'administration </span>
        </a>
    </div>
    @if(count($usersGroupedByTerritories) >0)
        <div class="section pt-0">
            <h1 class="title is-2 has-text-link">Liste des utilisateurs Terre de Liens par territoire</h1>
            <div class="columns is-mobile is-centered">
                <div class="column is-three-quarters">
                    <table class="table is-responsive is-hoverable is-fullwidth is-striped">
                        <thead>
                        <tr>
                            <th>Nom du territoire</th>
                            <th>Utilisateurs rattachés au territoire</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($usersGroupedByTerritories as $territoryName => $users)
                            <tr>
                                <td class="has-text-weight-bold">{{$territoryName}}</td>
                                <td>
                                    @if(count($users) >0)
                                        @foreach($users as $user)
                                            @if(($user->first_name == null) && ($user->name == null))
                                                <span>{{$user->email}} </span>
                                            @else
                                                <span>{{$user->first_name != null ? $user->first_name : ""}} {{ $user->name != null ? $user->name : "" }} </span>
                                            @endif
                                            -
                                            <span class="is-italic">{{$user->roleFullName}}</span>
                                            @if($user->userPermissions->count())
                                                @foreach($user->userPermissions as $permission )
                                                    -
                                                    <span class="is-size-7">{{\App\Models\UserPermission::$permissions[$permission->permission]}}</span>
                                                    @endforeach
                                                    @endif
                                                    </p>

                                                @endforeach
                                            @else
                                                <p>Aucun utilisateur</p>
                                            @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    @endif
@endsection