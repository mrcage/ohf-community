<?php

namespace App\Navigation\ContextButtons\Visitors;

use App\Navigation\ContextButtons\ContextButtons;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class VisitorIndexContextButtons implements ContextButtons
{
    public function getItems(View $view): array
    {
        return [
            'export' => [
                'url' => route('api.visitors.export'),
                'caption' => __('Export'),
                'icon' => 'download',
                'authorized' => Gate::allows('export-visitors'),
            ],
        ];
    }
}
