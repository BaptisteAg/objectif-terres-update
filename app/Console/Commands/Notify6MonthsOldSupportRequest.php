<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Notify6MonthsOldSupportRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-6-moths-old-support-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a message to every user that have a 6 months old support request';

    protected $job;

    /**
     * Create a new command instance.
     */
    public function __construct(\App\Jobs\Notify6MonthsOldSupportRequest $job)
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
