<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use Tests\TestCase;

class ApiSalesforceTest extends TestCase
{
    public function test_cimetiere()
    {
        $userRepo = app(UserRepository::class);
        $repo = app(SalesForceRepository::class);
        $repo->authenticate();

        /** @var User $localUser */
        $user = $repo->findWhere('User', ['Username' => 'philippe.cimetiere@wanadoo.fr']);

        dd($user);
    }
}
