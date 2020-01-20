<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\AdRepositoryInterface;
use App\Models\Ad;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

/**
 * Class AdRepository
 * @package App\Http\Repositories\Ads
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

    /**
     * @param $id
     * @return Ad
     */
    public function find($id)
    {
        $model = $this->entity
            ->where(["id" => $id])
            ->with(['landSeekAd', 'landOfferAd', 'jobAd'])
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
     * Creates an ad.
     *
     * @param int
     * @param array
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

        foreach (["cities", "departments", "regions"] as $locationableType) {
            $locationables = $adData["locationable"][$locationableType] ?? [];
            if (count($locationables)) {
                $ad->$locationableType()->attach($locationables, ["radius" => $adData["locationable_radius"]]);
            }
        }

        if ($data["ad_type"] === "land_seek") {
            $adData["ad_id"] = $ad->id;
            $landSeekAd = $this->landSeekAdRepository->create($adData);
        }

        return $ad;
    }
}
