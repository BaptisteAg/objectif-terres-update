<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\AdRepositoryInterface;
use App\Models\Ad;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

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
