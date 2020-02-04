<?php namespace App\Services\Ads;

use App\Repositories\Ads\AdRepository;
use Illuminate\Support\Facades\DB;

class AdService
{
    /**
     * @var AdRepository
     */
    protected $repository;

    public function __construct(AdRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $data
     * @throws \Throwable
     */
    public function create($data)
    {
        $ad =  DB::transaction(function() use($data) {
            $ad = $this->repository->create($data);

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
}