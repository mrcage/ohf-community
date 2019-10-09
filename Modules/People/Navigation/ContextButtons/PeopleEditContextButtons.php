<?php

namespace Modules\People\Navigation\ContextButtons;

use App\Navigation\ContextButtons\ContextButtons;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class PeopleEditContextButtons implements ContextButtons {

    public function getItems(View $view): array
    {
        $person = $view->getData()['person'];
        return [
            'back' => [
                'url' => route('people.show', $person),
                'caption' => __('app.cancel'),
                'icon' => 'times-circle',
                'authorized' => Auth::user()->can('view', $person)
            ]
        ];

    }

}
