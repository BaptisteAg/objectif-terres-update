<?php


namespace App\Observers\Traits;


use Illuminate\Database\Eloquent\Model;

trait SubAdHistoryObserverTrait
{

	protected function createdObserverSubAd(Model $subAd)
	{
//		$this->track($subAd, function ($value, $field) use ($subAd) {
//			if (!in_array($field, $this->fieldToNotTrack)) {
//				$fieldName = $this->fieldList[$field] ?? $field;
//				$valueName = $this->valueList[$value] ?? $value;
//
//				return [
//					'ad_id' => $subAd->ad->id,
//					'body' => "Création de l'annonce : pour le champs <em>" . $fieldName . "</em>, l'utilisateur a renseigné <em>" . $valueName . "</em>",
//				];
//			}
//		});
	}
}