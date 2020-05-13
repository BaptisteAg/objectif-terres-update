<?php namespace App\Repositories\AdNotes;


use App\Models\AdNote;
use Illuminate\Support\Facades\DB;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;


/**
 * Class UserRepository
 * @package App\Repositories\Users
 * @property AdNote $entity
 */
class AdNotesRepository extends AbstractRepository implements AdNotesRepositoryInterface
{

	public function entity()
	{
		return AdNote::class;
	}

	/**
	 * Creates a note.
	 * @param array $data
	 * @return mixed
	 * @throws \Throwable
	 */
	public function create(array $data)
	{
		$adNote = DB::transaction(function () use ($data) {
			$adNote = new AdNote();
			$adNote->fill($data);
			$adNote->save();
			return $adNote;
		});
		return $adNote;
	}


	/**
	 * @param array $data
	 * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
	 */
	public function findAllByProjectDataKeyAndAdId(array $data)
	{
		return $this->entity
			->where("ad_id", "=", $data['ad_id'])
			->where("project_data_key_id", "=",$data['project_data_key_id'])
			->orderByDesc('created_at')
			->with('user')
			->get();
	}

}