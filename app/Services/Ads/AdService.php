<?php namespace App\Services\Ads;

use App\Repositories\Ads\AdRepository;
use App\Repositories\Ads\LandOfferAdRepository;
use App\Repositories\Ads\LandSeekAdRepository;
use App\Repositories\Ads\ProductionGenreRepository;
use Illuminate\Support\Facades\DB;

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

    public function find(int $id)
    {
        $ad = $this->repository->find($id);

        return $ad;
    }

    public function findAll()
    {
        $ads = $this->repository->all();

        return $ads;
    }

	public function findAllByUser($idUser)
	{
		$ads = $this->repository->allByIdUser($idUser);

		return $ads;
	}

    public function getProductionGenresFlattened()
    {
        return $this->productionGenreRepository->getFlattened();
    }
}