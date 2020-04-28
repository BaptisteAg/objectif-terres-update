<?php

namespace App\Console\Commands;

use App\Events\ResearchAlertEvent;
use App\Jobs\NotifyNewResultsResearch;
use App\Listeners\SendResearchNotification;
use Illuminate\Console\Command;

class SendAlertsResearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-new-results-research';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an alert to user when new ads related to his saved research is published';


	protected $researchNotification;

	/**
	 * Create a new command instance.
	 *
	 * @param NotifyNewResultsResearch $researchNotification
	 */
    public function __construct(NotifyNewResultsResearch $researchNotification)
    {
    	$this->researchNotification = $researchNotification;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
		$this->researchNotification->handle();
    }
}
