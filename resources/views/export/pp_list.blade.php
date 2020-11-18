<table>
	<thead>
	<tr>
		<th colspan="11"><h1>Données générales des porteurs de projet</h1></th>
	</tr>
	</thead>
	<tr>
		<th >Nom</th>
		<th>Prénom</th>
		<th>Civilité</th>
		<th>N° de téléphone</th>
		<th>Adresse email</th>
		<th>Adresse postale</th>
		<th>Commune</th>
		<th>Profil</th>
		<th>Autre profil</th>
		<th>Accepte de recevoir communications Terre de Liens</th>
		<th>Date d'inscription</th>
	</tr>

	<tbody>
	@foreach($ads as $ad)
		<tr>
			<td>{{$ad->userPp->name?? ''}} </td>
			<td>{{$ad->userPp->first_name ?? ''}}</td>
			<td>
				@if(isset($ad->userPP->civility))
					{{App\Models\User::$civilities[$ad->userPP->civility]}}
				@else
				@endif
			</td>
			<td>
					{{$ad->userPP->phone?? ''}}
			</td>
			<td>{{$ad->userPP->email?? ""}}</td>
			<td>{{$ad->userPP->street ?? ""}}</td>
			<td>{{$ad->userPP->city?? ""}}</td>
			<td>
				@if(isset($ad->userPP->profile))
					{{{App\Models\User::$profiles[$ad->userPP->profile]}}}
				@else
				@endif
			</td>
			<td>{{$ad->userPP->other_profile ?? ""}}</td>
			<td>
				@if($ad->userPP->accept_communication === 1 )
					oui
				@else
					non
			@endif
			<td>{{$ad->userPp->created_at?: ''}}</td>
		</tr>
	@endforeach
	</tbody>
</table>
