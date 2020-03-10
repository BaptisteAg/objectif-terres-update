<?php namespace App\Presenters;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use \McCool\LaravelAutoPresenter\BasePresenter as OriginalBasePresenter;
use Psy\VarDumper\Presenter;

/**
 * @property Model $wrappedObject
 */
abstract class BasePresenter extends OriginalBasePresenter implements \JsonSerializable
{
	/**
	 * Ensures Presenter will keep its behavior when json_encode is called on it
	 *
	 * @return false|mixed|string
	 */
	public function jsonSerialize()
	{
		$serialized = [];

		foreach($this->wrappedObject->getAttributes() as $attribute => $value) {
			$serialized[$attribute] = $this->$attribute;
		}

		foreach($this->wrappedObject->getRelations() as $relationName => $relation) {
			$serialized[$relationName] = $this->$relationName;
		}

		foreach($serialized as $attribute => &$value) {
			if($value instanceof Collection) {
				$value = $value->toArray();
			}
			if($value instanceof AdPresenter) {
				$value = $value->toArray();
			}
		}

		return $serialized;
	}
}