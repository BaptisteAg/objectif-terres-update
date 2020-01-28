<?php namespace App\Services\AdMessages;

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

}