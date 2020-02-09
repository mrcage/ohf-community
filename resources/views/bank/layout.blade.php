@extends('layouts.tabbed_view', [
    'nav_elements' => [
        [
            'url' => route('bank.withdrawal.search'),
            'label' => __('people.withdrawal'),
            'icon' => 'id-card',
            'active' => function($currentRouteName) {
                return $currentRouteName == 'bank.withdrawal.search';
            },
            'authorized' => Gate::allows('do-bank-withdrawals'),
        ],
        [
            'url' => route('bank.deposit'),
            'label' => __('people.deposit'),
            'icon' => 'money-bill-alt',
            'active' => function($currentRouteName) {
                return $currentRouteName == 'bank.deposit';
            },
            'authorized' => Gate::allows('do-bank-deposits'),
        ]
    ]
])