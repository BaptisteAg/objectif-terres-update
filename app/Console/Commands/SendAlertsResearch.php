<?php

namespace App\Console\Commands;

use App\Events\ResearchEvents;
use App\Listeners\SendResearchNotification;
use Illuminate\Console\Command;

class SendAlertsResearch extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-research';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';


	protected $researchNotification;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(SendResearchNotification $researchNotification)
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
		$this->researchNotification->alertResearch();
    }
}
