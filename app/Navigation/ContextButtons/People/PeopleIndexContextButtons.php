<?php

namespace App\Navigation\ContextButtons\People;

use App\Models\People\Person;
use App\Navigation\ContextButtons\ContextButtons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PeopleIndexContextButtons implements ContextButtons
{
    public function getItems(View $view): array
    {
        return [
            'action' => [
                'url' => route('people.create'),
                'caption' => __('app.register'),
                'icon' => 'plus-circle',
                'icon_floating' => 'plus',
                'authorized' => Auth::user()->can('create', Person::class),
            ],
            'report' => [
                'url' => route('reporting.people'),
                'caption' => __('app.report'),
                'icon' => 'chart-line',
                'authorized' => Gate::allows('view-people-reports'),
            ],
            'maintenance' => [
                'url' => route('people.maintenance'),
                'caption' => __('app.maintenance'),
                'icon' => 'eraser',
                'authorized' => Auth::user()->can('cleanup', Person::class),
            ],
            'import-export' => [
                'url' => route('people.import-export'),
                'caption' => __('app.import_export'),
                'icon' => 'sync',
                'authorized' => Auth::user()->can('export', Person::class) || Auth::user()->can('create', Person::class),
            ],
        ];
    }
}
