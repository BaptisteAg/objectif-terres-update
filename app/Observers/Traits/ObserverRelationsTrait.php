<?php

namespace App\Observers\Traits;

use Illuminate\Database\Eloquent\Model;

trait ObserverRelationsTrait
{
    use TracksHistoryTrait;

    protected function createdObserverSubAd(Model $subAd, array $fieldToNotTrack = [])
    {
        $this->track($subAd, function ($value, $field) use ($subAd, $fieldToNotTrack) {
            if (! in_array($field, $fieldToNotTrack)) {
                $fieldName = $this->fieldList[$field] ?? $field;
                $valueName = $this->valueList[$value] ?? $value;

                return [
                    'ad_id' => $subAd->ad->id,
                    'body' => "Création de l'annonce : pour le champs <em>".$fieldName."</em>, l'utilisateur a renseigné <em>".$valueName.'</em>',
                ];
            }
        });
    }

    protected function updatedObserverSubAd(Model $subAd)
    {
        $this->track($subAd, function ($value, $field) use ($subAd) {
            $fieldName = $this->fieldList[$field] ?? $field;
            $valueName = $this->valueList[$value] ?? $value;

            return [
                'ad_id' => $subAd->ad->id,
                'body' => "Modification de l'annonce : dans le champs <em>".$fieldName."</em>, l'utilisateur a modifié pour <em>".$valueName.'</em>',
            ];
        });
    }

    protected function morphToManySubAdObserver(string $relation, Model $model, array $ids)
    {
        $ad = $model->ad;
        $modelNames = [
            'productionGenres' => \App\Models\ProductionGenre::class,
            'productionGenresSecondary' => \App\Models\ProductionGenre::class,
            'offerGenres' => \App\Models\OfferGenre::class,
            'educationLevels' => \App\Models\EducationLevel::class,
            'bioCertifications' => \App\Models\BioCertification::class,
            'jobOfferTypes' => \App\Models\JobOfferType::class,

        ];
        $readableModelName = [
            'productionGenres' => 'production',
            'productionGenresSecondary' => 'productions secondaires',
            'offerGenres' => 'installation',
            'educationLevels' => 'niveau formation',
            'jobOfferTypes' => "type d'offre",
            'bioCertifications' => 'certification des terres',

        ];
        if (array_key_exists($relation, $modelNames)) {
            $this->polymorphicRelationTrack($relation, $model, $ad, $ids, $modelNames, $readableModelName);
        }
    }
}
