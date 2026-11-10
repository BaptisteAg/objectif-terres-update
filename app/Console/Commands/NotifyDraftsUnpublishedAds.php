<?php

namespace App\Console\Commands;

use App\Jobs\NotifyUnpublishedAds;
use Illuminate\Console\Command;

class NotifyDraftsUnpublishedAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-drafts-unpublished-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to all ads not attributed since 7 days';

    protected $job;

    /**
     * Create a new command instance.
     */
    public function __construct(NotifyUnpublishedAds $job)
    {
        $this->job = $job;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->job->handle();
    }
}
