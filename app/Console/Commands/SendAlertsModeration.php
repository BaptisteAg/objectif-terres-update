<?php

namespace App\Console\Commands;

use App\Jobs\NotifyOverdueModeration;
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

    protected $job;

	/**
	 * Create a new command instance.
	 *
	 * @param NotifyOverdueModeration $job
	 */
    public function __construct(NotifyOverdueModeration $job)
    {
    	$this->job = $job;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->job->handle();
    }
}
