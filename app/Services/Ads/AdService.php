<?php namespace App\Services\Ads;

use App\Models\Ad;
use App\Models\AdStatus;
use App\Models\AttributionAd;
use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\JobOfferAdRepository;
use App\Repositories\Ads\JobSeekAdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
use App\Repositories\AttributionAds\AttributionAdsRepository;
use Illuminate\Support\Facades\DB;

/**
 * Class AdService
 * @package App\Services\Ads
 */
class AdService
{
    /**
     * @var AdRepository
     */
    protected $repository;
    /**
     * @var LandSeekAdRepository
     */
    protected $landSeekAdRepository;
    /**
     * @var LandOfferAdRepository
     */
    protected $landOfferAdRepository;
    /**
     * @var ProductionGenreRepository
     */
    protected $productionGenreRepository;
    /**
     * @var JobOfferAdRepository
     */
    protected $jobOfferAdRepository;
    /**
     * @var JobSeekAdRepository
     */
    protected $jobSeekAdRepository;
	/**
	 * @var AttributionAdsRepository
	 */
    protected $attributionAdsRepository;

	/**
	 * AdService constructor.
	 * @param AdRepository $repository
	 * @param AttributionAdsRepository $attributionAdsRepository
	 * @param LandSeekAdRepository $landSeekdAdRepository
	 * @param LandOfferAdRepository $landOfferAdRepository
	 * @param JobOfferAdRepository $jobOfferAdRepository
	 * @param JobSeekAdRepository $jobSeekAdRepository
	 * @param ProductionGenreRepository $productionGenreRepository
	 */
	public function __construct(
        AdRepository $repository,
        AttributionAdsRepository $attributionAdsRepository,
        LandSeekAdRepository $landSeekdAdRepository,
        LandOfferAdRepository $landOfferAdRepository,
        JobOfferAdRepository $jobOfferAdRepository,
        JobSeekAdRepository $jobSeekAdRepository,
        ProductionGenreRepository $productionGenreRepository
    ) {
        $this->repository = $repository;
        $this->attributionAdsRepository = $attributionAdsRepository;
        $this->landSeekAdRepository = $landSeekdAdRepository;
        $this->landOfferAdRepository = $landOfferAdRepository;
        $this->jobOfferAdRepository = $jobOfferAdRepository;
        $this->jobSeekAdRepository = $jobSeekAdRepository;
        $this->productionGenreRepository = $productionGenreRepository;
    }

	/**
	 * @param $data
	 * @return mixed
	 * @throws \Throwable
	 */
    public function create($data)
    {
        $ad =  DB::transaction(function() use($data) {

        	$attributionAdData = [];
        	$toModerateStatus = AdStatus::where('name', '=', 'A modérer')->first();
			$attributionAdData['user_moderator_id'] = 25;
			$attributionAdData['ad_status_id'] = $toModerateStatus->id;

			$ad = $this->repository->create($data);
			$attributionAdData['ad_id'] = $ad->id;
			$this->attributionAdsRepository->create($attributionAdData);

			$adData = $data[$data["ad_type"]];
            $adData["ad_id"] = $ad->id;

            if ($data["ad_type"] === "land_seek") {
                $landSeekAd = $this->landSeekAdRepository->create($adData);
            }
            else if ($data["ad_type"] === "land_offer") {
                $landOfferAd = $this->landOfferAdRepository->create($adData);
            }
            else if ($data["ad_type"] === "job_offer") {
                $jobOfferAd = $this->jobOfferAdRepository->create($adData);
            }
            else if ($data["ad_type"] === "job_seek") {
                $jobSeekAd = $this->jobSeekAdRepository->create($adData);
            }

            return $ad;
        });

        return $ad;
    }

	/**
	 * @param int $id
	 * @return \App\Models\Ad
	 */
	public function find(int $id)
    {
        $ad = $this->repository->find($id);

        return $ad;
    }

	/**
	 * @return \App\Models\Ad[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|mixed
	 */
	public function findAll()
    {
        $ads = $this->repository->all();

        return $ads;
    }

	/**
	 * @param $idUser
	 * @return \App\Models\Ad[]|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
	 */
	public function findAllByUser($idUser)
	{
		$ads = $this->repository->allByIdUser($idUser);

		return $ads;
	}

	/**
	 * @return array|\Illuminate\Support\Collection
	 */
	public function getProductionGenres()
    {
        return $this->productionGenreRepository->all();
    }

    /**
     * @return array|\Illuminate\Support\Collection
     */
    public function getProductionGenresFlattened()
    {
        return $this->productionGenreRepository->getFlattened();
    }

	/**
	 * @param Ad $ad
	 * @return void
	 * @throws \Exception
	 */
	public function delete(Ad $ad)
	{
		return $this->repository->destroy($ad->id);
	}
}