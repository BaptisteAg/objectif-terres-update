<?php namespace App\Repositories\Ads;

use App\Models\Ad;
use App\Models\Document;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AdRepository
 * @package App\Repositories\Ads
 * @property Ad $entity
 */
class AdRepository extends AbstractRepository implements AdRepositoryInterface
{
    /** @var LandSeekdAdRepository */
    protected $landSeekAdRepository;

    public function __construct(LandSeekdAdRepository $landSeekAdRepository)
    {
        parent::__construct();

        $this->landSeekAdRepository = $landSeekAdRepository;
    }

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
        $model = $this->entity
            ->where(["id" => $id])
            ->with($this->getEagerLoading())
            ->firstOrFail();

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

		$model = $this->entity
			->where(["sf_pp_id" => $idUser])
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

        $adData = $data[$data["ad_type"]];

        $ad->fill($adData);

        $ad->sf_pp_id = 999;
        $ad->is_draft = false;

        $ad->save();

        $adData["ad_id"] = $ad->id;

        foreach (["cities", "departments", "regions"] as $locationableType) {
            $locationables = $adData["locationable"][$locationableType] ?? [];
            if (count($locationables)) {
                $ad->$locationableType()->attach($locationables, ["radius" => $adData["locationable_radius"]]);
            }
        }

        if(isset($adData["documents"])) {
            foreach($adData["documents"] as $documentId) {
                $ad->documents()->attach($documentId);
            }
        }


        if ($data["ad_type"] === "land_seek") {
            $landSeekAd = $this->landSeekAdRepository->create($adData);
        }
        else if ($data["ad_type"] === "land_offer") {
            //$landSeekAd = $this->landSeekAdRepository->create($adData);
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
        ];
    }
}
