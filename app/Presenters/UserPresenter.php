<?php namespace App\Presenters;

use App\Models\Ad;
use App\Models\User;
use McCool\LaravelAutoPresenter\BasePresenter;
use phpDocumentor\Reflection\Types\Boolean;

/**
 * Class UserPresenter
 * @package App\Presenters
 * @property User $wrappedObject
 */
class UserPresenter extends BasePresenter
{
	/**
	 * @return string
	 */
	public function profile()
	{
		if ($this->wrappedObject->profile === 1) {
			return 'un candidat à l’installation agricole';
		}
		if ($this->wrappedObject->profile === 2) {
			return 'une personne en recherche de travail ou d’expérience professionnelle dans le domaine agricole';
		}
		if ($this->wrappedObject->profile === 3) {
			return 'un agriculteur qui souhaite consolider sa ferme';
		}
		if ($this->wrappedObject->profile === 4) {
			return 'un agriculteur qui souhaite transmettre sa ferme';
		}
		if ($this->wrappedObject->profile === 5) {
			return 'un propriétaire foncier qui souhaite vendre ou louer sa terre';
		}
		if ($this->wrappedObject->profile === 6) {
			return 'autre';
		}

	}

	/**
	 * @return string
	 */
	public function civilityFullName()
	{
		if ($this->wrappedObject->civility === 1) {
			return 'Madame';
		}
		if ($this->wrappedObject->civility === 2) {
			return 'Monsieur';
		}
		if ($this->wrappedObject->civility === 3) {
			return 'Autre';
		}
	}

	/**
	 * @return string
	 */
	public function created_at()
	{
		return  \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y');
	}

	/**
	 * @return array
	 */
	public function userDepartmentsCodes() : array
	{
		 return $this->wrappedObject->departments->pluck('code')->toArray();

	}



}
