<?php namespace App\Presenters;

use App\Models\Message;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class MessagePresenter
 * @package App\Presenters
 * @property Message $wrappedObject
 */
class MessagePresenter extends BasePresenter
{

	public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}
	public function created_at_diff()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->diffForHumans();
	}

}
