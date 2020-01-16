<?php namespace App\Http\Repositories\Ads;

use App\Htttp\Repositories\AdRepositoryInterface;
use App\Models\Ad;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class AdRepository extends AbstractRepository implements AdRepositoryInterface
{
    /** @var LandSeekdAdRepository  */
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

        $ad->fill($data);

        dd($data);
        if($data["ad_type"] === "land_seek") {
            $landSeekdAd = $this->landSeekAdRepository->create($data);
            $ad->landSeekAd = $landSeekdAd;
        }

        $ad->save();

        return $ad;
    }
}