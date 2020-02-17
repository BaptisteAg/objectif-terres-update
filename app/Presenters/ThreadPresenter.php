<?php namespace App\Presenters;

use App\Models\Thread;

/**
 * Class AdPresenter
 * @package App\Presenters
 * @property Thread $wrappedObject
 */
class ThreadPresenter extends BasePresenter
{
	public function title() : string
	{
		$title = array_filter([$this->wrappedObject->title]);

		if(!count($title)) {
			$title = [];
			if($this->wrappedObject->ad->title){
				$title = $this->wrappedObject->ad->title;
				return $title;
			}
			foreach ($this->wrappedObject->users as $user){
				if ($user->id !== auth()->id()){
					array_push($title, $user->first_name. ' '. $user->name);
				}
				array_unique($title);
			}
		}

		return implode(' - ', $title);
	}

	public function unread_count()
	{
		return $this->wrappedObject->unreadMessages()->count();
	}

	public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

	public function created_at_diff()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->diffForHumans();
	}
}