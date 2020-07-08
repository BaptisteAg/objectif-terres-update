<?php

namespace App\Console\Commands;

use App\Jobs\NotifyPublishDateExtendBeforeExpiration as NotifyPublishDateExtendBeforeExpirationJob;
use Illuminate\Console\Command;

class NotifyPublishDateExtendBeforeExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-publish-date-extend-before-expiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an alert to ad owners whose ads are going to expire soon and suggest to extend the expiration date';

    /** @var NotifyPublishDateExtendBeforeExpirationJob  */
    protected $job;

	/**
	 * Create a new command instance.
	 *
	 * @param NotifyPublishDateExtendBeforeExpirationJob $job
	 */
    public function __construct(NotifyPublishDateExtendBeforeExpirationJob $job)
    {
    	$this->job = $job;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->job->handle();
    }
}
