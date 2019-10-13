<?php

namespace Modules\People\Http\Controllers\Reporting;

use App\Http\Controllers\Reporting\BaseReportingController;

use Modules\People\Entities\Person;

use Carbon\Carbon;

class PeopleReportingController extends BaseReportingController
{
    /**
     * Index
     */
    function index()
    {
        return view('people::reporting.people', [
            'people' => [[
                'Registered' => Person::count(),
                'Registered today' => Person::whereDate('created_at', '=', Carbon::today())->count(),
            ]],
            'nationalities' => Person::getNationalities(),
            'gender' => Person::getGenderDistribution(),
            'ageDistribution' => Person::getAgeDistribution(),
		]);
    }

}
