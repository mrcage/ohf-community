<?php

namespace Modules\Shop\Navigation\ContextButtons;

use App\Navigation\ContextButtons\ContextButtons;

use App\Models\Collaboration\WikiArticle;

use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class ShopContextButtons implements ContextButtons {

    public function getItems(View $view): array
    {
        $help_article_id = \Setting::get('shop.help_article');
        $help_article = $help_article_id != null ? WikiArticle::find($help_article_id) : null;
        return [
            'manageCards' => [
                'url' => route('shop.manageCards'),
                'caption' => __('shop::shop.manage_cards'),
                'icon' => 'ticket-alt',
                'authorized' => Gate::allows('validate-shop-coupons')
            ],
            'settings' => [
                'url' => route('shop.settings.edit'),
                'caption' => __('app.settings'),
                'icon' => 'cogs',
                'authorized' => Gate::allows('configure-shop')
            ],
            'help'=> $help_article != null ? [
                'url' => route('kb.articles.show', $help_article),
                'caption' => null,
                'icon' => 'question-circle',
                'authorized' => Auth::user()->can('view', $help_article),
            ] : null,
        ];
    }

}
