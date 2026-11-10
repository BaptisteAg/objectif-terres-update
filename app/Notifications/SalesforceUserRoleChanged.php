<?php

namespace App\Notifications;

use App\Models\User;

class SalesforceUserRoleChanged extends BasicNotification
{
    /**
     * @param  User|mixed  $localUser
     */
    public function __construct(User $localUser, int $oldRole, int $role)
    {
        parent::__construct([
            'subject' => $localUser->first_name.' '.$localUser->name.' a changé de rôle sur Objectif Terres !',
            'message' => $localUser->first_name.' '.$localUser->name.' a changé de rôle sur Objectif Terres. 
            Ancien rôle : '.User::$roles[$oldRole].'.
            Nouveau rôle est : '.User::$roles[$role],
        ]);
    }
}
