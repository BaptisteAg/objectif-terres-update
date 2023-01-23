<?php

namespace Tests\Feature;

use App\Models\User;
use App\Repositories\SalesForce\SalesForceRepository;
use App\Repositories\Users\UserRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;
use Tests\TestCase;

class ApiSalesforceTest extends TestCase
{
    public function testCimetiere()
    {
        $userRepo = app(UserRepository::class);
        $repo = app(SalesForceRepository::class);
        $repo->authenticate();

        /** @var User $localUser */
        $user = $repo->findWhere('User', ["Username" => "philippe.cimetiere@wanadoo.fr"]);

        dd($user);
    }
}
