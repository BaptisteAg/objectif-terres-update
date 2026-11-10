<?php

namespace App\Console\Commands;

use App\Services\Salesforce\SalesforceService;
use Faker\Factory;
use Illuminate\Console\Command;

class SalesforceCreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'salesforce:create-user
                            {--email= : set user email}
                            {--password= : set user password}
                            {--role= : set user role}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a salesforce user for roles > 0.';

    /**
     * @var SalesforceService
     */
    protected $salesforceService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SalesforceService $salesforceService)
    {
        parent::__construct();

        $this->salesforceService = $salesforceService;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $faker = Factory::create();

        $email = $faker->email;
        $password = 'crif9bf1';
        $firstName = $faker->firstName;
        $lastName = $faker->lastName;
        $role = 4;
        $departments = ['69'];

        if ($this->option('email')) {
            $email = $this->option('email');
        }
        if ($this->option('password')) {
            $password = $this->option('password');
        }
        if ($this->option('role')) {
            $role = $this->option('role');
        }

        $data = compact('email', 'password', 'firstName', 'lastName', 'role', 'departments');

        $this->salesforceService->createPortalUser($data);
        $this->info('User created : '.json_encode($data, JSON_PRETTY_PRINT));
        $this->alert('An email has been set to this email. It needs validation.');
    }
}
