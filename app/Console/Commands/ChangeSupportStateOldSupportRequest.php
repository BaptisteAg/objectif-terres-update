<?php

namespace App\Console\Commands;

use App\Jobs\ChangeSupportStateOldSupportRequest as ChangeSupportStateOldSupportRequestJob;
use Illuminate\Console\Command;

class ChangeSupportStateOldSupportRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:change-support-state-old-support-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the support state to "To Archive ?" if support request older than 180 days and with support state = "Pending"';

    private $changeSupportStateOldSupportRequest;

    /**
     * Create a new command instance.
     */
    public function __construct(ChangeSupportStateOldSupportRequestJob $changeSupportStateOldSupportRequest)
    {
        parent::__construct();
        $this->changeSupportStateOldSupportRequest = $changeSupportStateOldSupportRequest;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->changeSupportStateOldSupportRequest->handle();
    }
}
