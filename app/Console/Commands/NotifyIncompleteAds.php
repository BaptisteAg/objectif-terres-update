<?php

namespace App\Console\Commands;

use App\Jobs\NotifyIncompleteAd;
use Illuminate\Console\Command;

class NotifyIncompleteAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-incomplete-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to all ads published since 10 days and incomplete';

    protected $job;

	/**
	 * Create a new command instance.
	 *
	 * @param NotifyIncompleteAd $job
	 */
    public function __construct(NotifyIncompleteAd $job)
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
