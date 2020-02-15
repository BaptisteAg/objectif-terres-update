<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AdRepository
 * @package App\Repositories\Ads
 * @property Ad $entity
 */
class AdRepository extends AbstractRepository implements AdRepositoryInterface
{
    public function entity()
    {
        return Ad::class;
    }

    public function all($paginate = null)
    {
        return $this->entity
            ->with($this->getEagerLoading())
            ->get();
    }

    /**
     * @param $id
     * @return Ad
     */
    public function find($id)
    {
    	/** @var Ad $model */
        $model = $this->entity
            ->where(["id" => $id])
            ->with($this->getEagerLoading())
            ->first();

        if (!$model) {
            throw (new ModelNotFoundException)->setModel(
                get_class($this->entity->getModel()),
                $id
            );
        }

        return $model;
    }

	/**
	 * @param  $idUser
	 * @return Ad[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function allByIdUser($idUser)
	{
		/** @var Ad $model */
		$model = $this->entity
			->where(["user_pp_id" => $idUser])
			->with($this->getEagerLoading())
			->get();

		if (!$model) {
			throw (new ModelNotFoundException)->setModel(
				get_class($this->entity->getModel()),
				$idUser
			);
		}

		return $model;
	}

	/**
	 * Creates an ad.
	 *
	 * @param int
	 * @param array
	 * @return Ad
	 * @throws \Throwable
	 */
    public function create(array $data): Ad
    {
        $ad = new Ad();

        $ad->fill($data);

        $ad->user_pp_id = auth()->user()->id;
        $ad->is_draft = false;

        $ad->save();

        foreach (["cities", "departments", "regions"] as $locationableType) {
            $locationables = $data["locationable"][$locationableType] ?? [];
            if (count($locationables)) {
                $ad->$locationableType()->attach($locationables, ["radius" => $data["locationable_radius"]]);
            }
        }

        if(isset($data["documents_ids"]) && is_array($data["documents_ids"])) {
            foreach($data["documents_ids"] as $documentId) {
                $ad->documents()->attach($documentId);
            }
        }

        return $ad;
    }

    private function getEagerLoading()
    {
        return [
            'landSeekAd',
			'landOfferAd',
			'jobAd',
			'cities',
			'cities.department',
			'cities.department.region',
			'departments',
			'departments.region',
			'regions',
			'adMessages',
            'landSeekAd.buildings',
            'landSeekAd.buildings.buildingType',
            'landSeekAd.buildings.requirement',
            'documents'
        ];
    }
}
