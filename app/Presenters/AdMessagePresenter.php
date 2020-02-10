<?php namespace App\Presenters;

use App\Models\AdMessage;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class AdMessagePresenter
 * @package App\Presenters
 * @property AdMessage $wrappedObject
 */
class AdMessagePresenter extends BasePresenter
{

	public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

	public function is_today()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->isToday();
	}

	public function created_at_diff()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->diffForHumans();
	}
}
