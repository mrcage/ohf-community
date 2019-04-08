<?php

namespace Modules\People\Widgets;

use App\Widgets\Widget;

use Modules\People\Entities\Person;

use Illuminate\Support\Facades\Gate;

use Carbon\Carbon;

class PersonsWidget implements Widget
{
    function authorize(): bool
    {
        return Gate::allows('manage-people');
    }

    function view(): string
    {
        return 'people::dashboard.widgets.persons';
    }

    function args(): array {
        return [
            'num_people' => Person::count(),
			'num_people_added_today' => Person::whereDate('created_at', '=', Carbon::today())->count(),
        ];
    }
}