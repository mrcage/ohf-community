<?php

namespace App\Navigation\ContextButtons;

use App\LibraryBook;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class LibraryBookIndexContextButtons implements ContextButtons {

    public function getItems(View $view): array
    {
        return [
            'action' => [
                'url' => route('library.books.create'),
                'caption' => __('app.add'),
                'icon' => 'plus-circle',
                'icon_floating' => 'plus',
                'authorized' => Auth::user()->can('create', LibraryBook::class)
            ],
        ];
    }

}
