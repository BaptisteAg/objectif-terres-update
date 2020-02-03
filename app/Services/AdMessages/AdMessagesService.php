<?php namespace App\Services\AdMessages;

use App\Models\Ad;
use App\Repositories\AdMessages\AdMessagesRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdMessagesService
{

	/**
	 * @var AdMessagesRepository
	 */
	protected $repository;

	public function __construct(AdMessagesRepository $repository)
	{
		$this->repository = $repository;
	}

	public function create(Request $request)
	{
		$data = [];
		foreach ($request->input() as $item => $value) {
			$data[$item] = $value;
		}
		$adMessage = DB::transaction(function () use ($data) {
			$adMessage = $this->repository->create($data);

			return $adMessage;
		});

		return $adMessage;

	}

	/**
	 * @param Ad $ad
	 * @return mixed
	 */
	public function findAllByAd(Ad $ad)
	{
		$adMessages = $this->repository->findAllByAd($ad);

		return $adMessages;

	}

}