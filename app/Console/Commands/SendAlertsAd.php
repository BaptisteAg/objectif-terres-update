<?php

namespace App\Console\Commands;

use App\Listeners\SendCompleteAdDataNotification;
use Illuminate\Console\Command;

class SendAlertsAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-ads-to-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to all ads published since 10 days and not complete';

    protected $sendCompleteAdDataNotification;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendCompleteAdDataNotification $sendCompleteAdDataNotification)
    {
    	$this->sendCompleteAdDataNotification = $sendCompleteAdDataNotification;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendCompleteAdDataNotification->alertAdToComplete();
    }
}
