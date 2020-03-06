<?php

namespace App\Console\Commands;

use App\Listeners\SendModerationNotification;
use Illuminate\Console\Command;

class SendAlertsModeration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-moderation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an alert to moderator if a an ad isn\'t moderate since a week';

    protected $sendModerationNotification;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendModerationNotification $sendModerationNotification)
    {
    	$this->sendModerationNotification = $sendModerationNotification;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sendModerationNotification->alertModeration();
    }
}
