<?php namespace App\Presenters;

use App\Models\User;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class UserPresenter
 * @package App\Presenters
 * @property User $wrappedObject
 */
class UserPresenter extends BasePresenter
{

	public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

}
