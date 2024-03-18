<?php

namespace App\Console\Commands;

use App\Exports\Advisors\AdvisorsExport;
use App\Exports\ProjectExport;
use App\Models\Ad;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class ExportAllSupportRequests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'export:support-requests';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $i = 0;
        //DB::listen(function ($query) use(&$i) {
        //    // send this to a log or whatever
        //    $backtrace = debug_backtrace();
//
        //    print_r([
        //        "i" => $i++,
        //        "backtrace" => collect($backtrace)
        //            ->filter(function ($item) {
        //                return isset($item['file']) && strpos($item['file'], 'vendor') === false;
        //            })
        //            ->map(function ($item) {
        //                return $item['file'] . ':' . $item['line'] . ' ' . $item['function'] . '()';
        //            })
        //            ->toArray(),
        //        "query" => $query->sql,
        //    ]);
        //});
        $ads = Ad::query()
            ->whereNotNull('project_id')
            ->orderByDesc('created_at')
            ->with([
                'userPp' => function ($query) {
                    $query->withTrashed();
                },
                'userPp.zipCode',

                'landSeekAd',
                'landSeekAd.buildings',
                'landSeekAd.buildings.buildingType',
                'landSeekAd.buildings.requirement',
                'landSeekAd.installationType',
                'landSeekAd.educationLevels',
                'landSeekAd.productionGenres',
                'landSeekAd.offerGenres',

                'landOfferAd',
                'landOfferAd.productionGenres',
                'landOfferAd.productionGenresPossible',
                'landOfferAd.bioCertifications',
                'landOfferAd.offerGenres',

                'cities',
                'cities.department',
                'cities.department.region',
                'departments',
                'departments.region',
                'departments.region',
                'regions',

                'project',
                'project.supportStage',
                'project.supportState',
                'project.projectStatus',
                'adNotes',
                'adNotes.projectDataKey',
                'adNotes.projectDataValue',
                'attributionAd',
                'attributionAd.adStatus',
                'attributionAd.userAdvisor',
                'attributionAd.userSupervisor',
                'supportRequestTerritoryId'
            ])
            ->withCount('adNotes')
            ->get();

        (new ProjectExport($ads))
            ->store(storage_path('/exports/export_accompagnements_' . Carbon::now()->format('d_m_Y H-i-s') . '.xlsx'));
    }
}
