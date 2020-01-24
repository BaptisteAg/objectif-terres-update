<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Omniphx\Forrest\Providers\Laravel\Facades\Forrest;
use Tests\TestCase;

class ExampleTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();

    }


    public function AuthenticateTest()
    {
        Route::get('/authenticate', function()
        {
            Forrest::authenticate();

            $this->assertAuthenticated();
            redirect()->back();

        });


    }

    public function AuthenticateUserTest($username, $password) {

        Route::Post('/authenticate', function() use ($username, $password){
            $url = 'https://test.salesforce.com';
            Forrest::authenticateUser($url, $username, $password);
        });
    }

    public function testCreateAccountTest()
    {
        $user = [
            'name' => 'test test',
        ];

        $this->AuthenticateTest();

//        $this->assertAuthenticated();

        Forrest::sobjects('Account', [
            'method' => 'post',
            'body' => $user
        ]);

        dd(Forrest::query('SELECT Id FROM Account WHERE Name = "test test"'));

    }
}
