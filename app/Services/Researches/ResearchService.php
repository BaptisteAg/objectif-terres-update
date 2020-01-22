<?php namespace App\Services\Researches;


use App\Repositories\Researches\ResearchRepository;
use Illuminate\Support\Facades\DB;

class ResearchService
{
	/**
	 * @var ResearchRepository
	 */
	protected $repository;

	public function __construct(ResearchRepository $repository)
	{
		$this->repository = $repository;
	}


	/**
	 * @param $data
	 * @throws \Throwable
	 */
	public function create($data)
	{
		$research =  DB::transaction(function() use($data) {
			$research = $this->repository->create($data);

			return $research;
		});

		return $research;
	}

	public function find(int $id)
	{
		$research = $this->repository->find($id);

		return $research;
	}

	public function findAll()
	{

		$researches = $this->repository->all();
		return $researches;
	}
}