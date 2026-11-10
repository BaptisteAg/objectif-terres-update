<?php

namespace App\Presenters;

use App\Models\User;
use McCool\LaravelAutoPresenter\BasePresenter;

/**
 * Class UserPresenter
 *
 * @property User $wrappedObject
 */
class UserPresenter extends BasePresenter
{
    /**
     * @return string
     */
    public function profile()
    {
        return User::$profiles[$this->wrappedObject->profile] ?? 'Autre';
    }

    /**
     * @return string
     */
    public function civilityFullName()
    {
        return User::$civilities[$this->wrappedObject->civility] ?? 'Autre';
    }

    /**
     * @return string
     */
    public function roleFullName()
    {
        return User::$roles[$this->wrappedObject->role] ?? 'Autre';
    }

    /**
     * @return string
     */
    public function created_at()
    {
        return $this->wrappedObject->created_at ? \Carbon\Carbon::parse($this->wrappedObject->created_at)->format('d/m/Y') : null;
    }

    public function userDepartmentsCodes(): array
    {
        return $this->wrappedObject->departments->pluck('code')->toArray();

    }

    public function userTerritoryIds(): array
    {
        $territoryIds = [];
        foreach ($this->wrappedObject->departments as $department) {
            $territoryIds[] = $department->territory->id;
        }

        return array_unique($territoryIds);

    }
}
