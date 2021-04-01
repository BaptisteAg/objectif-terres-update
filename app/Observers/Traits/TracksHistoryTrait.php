<?php


namespace App\Observers\Traits;


use App\Models\Ad;
use App\Models\History;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

trait TracksHistoryTrait
{
	/**
	 * @param Model $model
	 * @param callable|null $func
	 * @param null $table
	 * @param null $id
	 */
	protected function track(Model $model, callable $func = null, $table = null, $id = null)
	{
		// Allow for overriding of table if it's not the model table
		$table = $table ?: $model->getTable();
		// Allow for overriding of id if it's not the model id
		$id = $id ?: $model->id;
		// Allow for customization of the history record if needed
		$func = $func ?: [$this, 'getHistoryBody'];

		// Get the dirty fields and run them through the custom function, then insert them into the history table
		$this->getUpdated($model)
			->map(function ($value, $field) use ($func) {
				return call_user_func_array($func, [$value, $field]);
			})
			->each(function ($fields) use ($table, $id) {
				if($fields){
					History::create([
							'reference_table' => $table,
							'reference_id'    => $id,
							'actor_id'        => Auth::user()->id,
						] + $fields);
				}

			});
	}

	/**
	 * @param $value
	 * @param $field
	 * @return array
	 */
	protected function getHistoryBody($value, $field)
	{
		return [
			'body' => "Updated {$field} to ${value}",
		];
	}

	/**
	 * @param Model $model
	 * @return \Illuminate\Support\Collection
	 */
	protected function getUpdated(Model $model)
	{
		return collect($model->getDirty())->filter(function ($value, $key) {
			// We don't care if timestamps are dirty, we're not tracking those
			return !in_array($key, ['created_at', 'updated_at']);
		})->mapWithKeys(function ($value, $key) {
			// Take the field names and convert them into human readable strings for the description of the action
			// e.g. first_name -> first name
			return [str_replace('_', ' ', $key) => $value];
		});
	}

	/**
	 * @param string $relation
	 * @param Model $model
	 * @param Ad $ad
	 * @param array $ids
	 * @param array $modelNames
	 * @param array $readableModelName
	 */
	protected function polymorphicRelationTrack(string $relation, Model $model, Ad $ad, array $ids, array $modelNames, array $readableModelName){
		$relationIdsFromModel = $model->$relation->pluck('id')->toArray();
		if ($relationIdsFromModel !== $ids) {
			foreach ($ids as $id) {
				if (!in_array($id, $relationIdsFromModel)) {
					$relationModel = $modelNames[$relation]::where('id', $id)->get()->first();

					History::create([
						'reference_table' => $relation,
						'reference_id' => $id,
						'ad_id' => $ad->id,
						'actor_id' => Auth::user()->id,
						'body' => "Annonce n°" . $ad->id . " : pour le champs <em>" . $readableModelName[$relation] . "</em>, l'utilisateur a renseigné <em>" . $relationModel->name . "</em>"
					]);
				}
			}
		}
	}

	protected function belongsToRelationTrack(string $relation, Model $related, Model $parent,  array $readableModelName)
	{
		History::create([
			'reference_table' => $relation,
			'reference_id' => $related->id,
			'ad_id' => $related->ad_id,
			'actor_id' => Auth::user()->id,
			'body' => "Annonce n°" . $related->ad_id . " : pour le champs <em>" . $readableModelName[$relation] . "</em>, l'utilisateur a renseigné <em>" . $parent->name . "</em>"
		]);

	}
}