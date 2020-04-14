<table>
	<thead>
	<tr>
		<th colspan="11" style="text-align: center"><h1>Données générales des porteurs de projet</h1></th>
	</tr>
	</thead>
	<tr style="border-bottom: solid #000000 2px">
		<th style="background-color: #bdbdbd; width: auto">Nom</th>
		<th style="background-color: #bdbdbd; width: auto">Prénom</th>
		<th style="background-color: #bdbdbd; width: auto">Civilité</th>
		<th style="background-color: #bdbdbd; width: auto">N° de téléphone</th>
		<th style="background-color: #bdbdbd; width: auto">Adresse email</th>
		<th style="background-color: #bdbdbd; width: auto">Adresse postale</th>
		<th style="background-color: #bdbdbd; width: auto">Commune</th>
		<th style="background-color: #bdbdbd; width: auto">Profil</th>
		<th style="background-color: #bdbdbd; width: auto">Autre profil</th>
		<th style="background-color: #bdbdbd; width: auto">Accepte de recevoir communications Terre de Liens</th>
		<th style="background-color: #bdbdbd; width: auto">Date d'inscription</th>
	</tr>

	<tbody>
	@foreach($ads as $ad)
		<tr>
			<td>{{$ad->userPp->name}} </td>
			<td>{{$ad->userPp->first_name}}</td>
			<td>{{App\Models\User::$civilities[$ad->userPP->civility]}}</td>
			<td>{{$ad->userPP->phone}}</td>
			<td>{{$ad->userPP->email}}</td>
			<td>{{$ad->userPP->address}}</td>
			<td>{{$ad->userPP->city}}</td>
			<td>{{{App\Models\User::$profiles[$ad->userPP->profile]}}}</td>
			<td>{{$ad->userPP->other_profile}}</td>
			<td>
				@if($ad->userPP->accept_communication === 1 )
					oui
				@else
					non
			@endif
			<td>{{$ad->userPp->created_at}}</td>
		</tr>
	@endforeach
	</tbody>
</table>
