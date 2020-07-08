<?php

namespace App\Console\Commands;

use App\Jobs\UnpublishOldAds as UnpublishAdsJob;
use Illuminate\Console\Command;

class UnpublishOldAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:unpublish-old-ads';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Unpublish old ads and send an email';
    /**
     * @var UnpublishAdsJob
     */
    private $unpublishOldAds;


    /**
	 * Create a new command instance.
	 *
	 * @param UnpublishOldAds $unpublishOldAds
	 */
    public function __construct(UnpublishAdsJob $unpublishOldAds)
    {
        parent::__construct();

        $this->unpublishOldAds = $unpublishOldAds;
    }

    /**
     * Execute the console command.
     *
     * @throws \Exception
     */
    public function handle()
    {
       $this->unpublishOldAds->handle();
    }
}
