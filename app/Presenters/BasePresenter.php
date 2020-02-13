<?php namespace App\Presenters;

use \McCool\LaravelAutoPresenter\BasePresenter as OriginalBasePresenter;

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

		return $serialized;
	}
}