<?php namespace App\Presenters;

use App\Models\Thread;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class AdPresenter
 * @package App\Presenters
 * @property Thread $wrappedObject
 */
class ThreadPresenter extends BasePresenter
{
	public function test()
	{
		$title = $this->wrappedObject->title;

		if(!$title) {
			$title=[];
			foreach ($this->wrappedObject->users as $user){
				if ($user->id !== auth()->id()){
					array_push($title, $user);
				}
				array_unique($title);
			}
		}
		return $title;
	}
}