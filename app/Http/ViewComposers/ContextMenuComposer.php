<?php

namespace App\Http\ViewComposers;

use App\Support\Facades\ContextButtons;
use Illuminate\Support\Facades\Route;
use Illuminate\View\View;

class ContextMenuComposer
{
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $currentRouteName = Route::currentRouteName();

        $view->with('buttons', ContextButtons::get($currentRouteName, $view)
            ->filter(fn ($item) => $item['authorized']));
    }
}
