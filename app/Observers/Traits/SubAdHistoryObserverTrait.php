<?php


namespace App\Observers\Traits;


use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait SubAdHistoryObserverTrait
{
	use TracksHistoryTrait;

	/**
	 * @param Model $subAd
	 * @param array $fieldToNotTrack
	 */
	protected function createdObserverSubAd(Model $subAd, array $fieldToNotTrack = [])
	{
		$this->track($subAd, function ($value, $field) use ($subAd, $fieldToNotTrack) {
			if (!in_array($field, $fieldToNotTrack)) {

				$fieldName = $this->fieldList[$field] ?? $field;
				$valueName = $this->valueList[$value] ?? $value;

				return [
					'ad_id' => $subAd->ad->id,
					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
				];
			}
		});
	}


	/**
	 * @param Model $subAd
	 */
	protected function updatedObserverSubAd(Model $subAd)
	{
		$this->track($subAd, function ($value, $field) use ($subAd) {
			if (str_ends_with($field, ' id')) {
				return $this->handleBelongsToRelationObserver($subAd, $field, $value, "Modification de l'annonce");
			}

			$fieldName = $this->fieldList[$field] ?? $field;
			$valueName = $this->valueList[$value] ?? $value;

			return [
				'ad_id' => $subAd->ad->id,
				'body' => "Modification de l'annonce : dans le champs <em>" . $fieldName . "</em>, l'utilisateur a modifié pour <em>" . $valueName . "</em>",
			];
		});
	}

	/**
	 * @param Model $subAd
	 * @param string $field
	 * @param string $value
	 * @param string $typeOfObserver
	 */
	protected function handleBelongsToRelationObserver(Model $subAd, string $field, string $value, string $typeOfObserver = "Création de l'annonce")
	{
		$fieldNameInCamelCase = ucwords($field);
		$modelName = str_replace(' ', '', $fieldNameInCamelCase);
		$belongToRelationModelName = 'App\Models\\'.substr($modelName, 0, strpos($modelName, "Id"));
		$belongsToModel = $belongToRelationModelName::where('id', $value)->first();
		if(isset($belongsToModel)){
			 History::create([
					'reference_table' => $subAd->getTable(),
					'reference_id'    => $subAd->ad->id,
					'actor_id'        => Auth::user()->id,
					'body' => $typeOfObserver.' : un champs a été mis à jours'
				]);
		}
	}
}