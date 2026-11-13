<?php

namespace App\Nova\Dashboards;

use App\Nova\Metrics\NewUsers;
use App\Nova\Metrics\SurveyCount;
use App\Nova\Metrics\SurveyResults;
use App\Nova\Metrics\UsersPerDay;
use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function cards()
    {
        return [
            (new NewUsers)->width('1/2'),
            (new UsersPerDay)->width('1/2'),
            (new SurveyCount)->width('1/3'),
            (new SurveyResults)->width('2/3'),
        ];
    }
}
