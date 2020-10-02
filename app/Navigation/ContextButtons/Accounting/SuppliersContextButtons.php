<?php

namespace App\Navigation\ContextButtons\Accounting;

use App\Models\Accounting\MoneyTransaction;
use App\Navigation\ContextButtons\ContextButtons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class SuppliersContextButtons implements ContextButtons
{
    public function getItems(View $view): array
    {
        return [
            'transactions' => [
                'url' => route('accounting.transactions.index'),
                'caption' => __('accounting.transactions'),
                'icon' => 'money-bill-alt',
                'authorized' => Auth::user()->can('viewAny', MoneyTransaction::class) || Gate::allows('view-accounting-summary'),
            ],
        ];
    }

}