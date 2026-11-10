<?php

namespace App\Console\Commands;

use App\Jobs\NotifyOverdueModeration as NotifyOverdueModerationJob;
use Illuminate\Console\Command;

class NotifyOverdueModeration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-overdue-moderation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an alert to moderator if a an ad isn\'t moderate for a week';

    /** @var NotifyOverdueModerationJob */
    protected $job;

    /**
     * Create a new command instance.
     */
    public function __construct(NotifyOverdueModerationJob $job)
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
