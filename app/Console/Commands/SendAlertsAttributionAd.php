<?php

namespace App\Console\Commands;

use App\Listeners\SendAdPublishedDateNotification;
use Illuminate\Console\Command;

class SendAlertsAttributionAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-date-published-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email if the ad is published since 3 or 5 months';
	protected $listener;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendAdPublishedDateNotification $listener)
    {
    	$this->listener = $listener;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
       $this->listener->alertPublishedOnDate();
    }
}
