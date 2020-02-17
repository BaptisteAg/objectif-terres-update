<?php namespace App\Services\Ads;

use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
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
	 * AdService constructor.
	 * @param AdRepository $repository
	 * @param LandSeekAdRepository $landSeekdAdRepository
	 * @param LandOfferAdRepository $landOfferAdRepository
	 * @param ProductionGenreRepository $productionGenreRepository
	 */
	public function __construct(
        AdRepository $repository,
        LandSeekAdRepository $landSeekdAdRepository,
        LandOfferAdRepository $landOfferAdRepository,
        ProductionGenreRepository $productionGenreRepository
    ) {
        $this->repository = $repository;
        $this->landSeekAdRepository = $landSeekdAdRepository;
        $this->landOfferAdRepository = $landOfferAdRepository;
        $this->productionGenreRepository = $productionGenreRepository;
    }

    /**
     * @param $data
     * @throws \Throwable
     */
    public function create($data)
    {
        $ad =  DB::transaction(function() use($data) {
            $ad = $this->repository->create($data);

            $adData = $data[$data["ad_type"]];
            $adData["ad_id"] = $ad->id;

            //dd($data);

            if ($data["ad_type"] === "land_seek") {
                $landSeekAd = $this->landSeekAdRepository->create($adData);
            }
            else if ($data["ad_type"] === "land_offer") {
                $landOfferAd = $this->landOfferAdRepository->create($adData);
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
	public function getProductionGenresFlattened()
    {
        return $this->productionGenreRepository->getFlattened();
    }

	/**
	 * @param int $id
	 * @throws \Exception
	 */
	public function delete(int $id)
	{
		return $this->repository->destroy($id);
	}
}