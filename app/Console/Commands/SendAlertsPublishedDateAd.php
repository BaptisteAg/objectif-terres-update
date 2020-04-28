<?php

namespace App\Console\Commands;

use App\Jobs\Notify3MonthsPublishedAd;
use App\Jobs\Notify5MonthsPublishedAd;
use Illuminate\Console\Command;

class SendAlertsPublishedDateAd extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:send-alert-date-published-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send an email if the ad is published since 3 or 5 months';
	protected $notify3MonthsPublishedAd;
	protected $notify5MonthsPublishedAd;

	/**
	 * Create a new command instance.
	 *
	 * @param Notify3MonthsPublishedAd $notify3MonthsPublishedAd
	 * @param Notify5MonthsPublishedAd $notify5MonthsPublishedAd
	 */
    public function __construct(Notify3MonthsPublishedAd $notify3MonthsPublishedAd, Notify5MonthsPublishedAd $notify5MonthsPublishedAd)
    {
    	$this->notify3MonthsPublishedAd = $notify3MonthsPublishedAd;
    	$this->notify5MonthsPublishedAd = $notify5MonthsPublishedAd;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
       $this->notify3MonthsPublishedAd->handle();
       $this->notify5MonthsPublishedAd->handle();
    }
}
