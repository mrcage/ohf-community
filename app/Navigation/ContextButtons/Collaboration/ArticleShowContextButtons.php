<?php

namespace App\Navigation\ContextButtons\Collaboration;

use App\Models\Collaboration\WikiArticle;
use App\Navigation\ContextButtons\ContextButtons;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class ArticleShowContextButtons implements ContextButtons
{
    public function getItems(View $view): array
    {
        $article = $view->getData()['article'];

        $previous_route = previous_route();
        if (in_array($previous_route, ['kb.tag', 'kb.articles.index'])) {
            $back_url = URL::previous();
        } else {
            $back_url = route('kb.index');
        }

        return [
            'action' => [
                'url' => route('kb.articles.edit', $article),
                'caption' => __('Edit'),
                'icon' => 'edit',
                'icon_floating' => 'pencil-alt',
                'authorized' => Auth::user() != null && Auth::user()->can('update', $article),
            ],
            'share' => [
                'url' => 'javascript:;',
                'caption' => __('Share'),
                'icon' => 'share-alt',
                'authorized' => Auth::user() != null && Auth::user()->can('view', $article) && $article->public,
                'attributes' => [
                    'rel' => 'share-url',
                    'data-url' => route('kb.articles.show', $article),
                ],
            ],
            'pdf' => [
                'url' => route('kb.articles.pdf', $article),
                'caption' => __('PDF'),
                'icon' => 'file-pdf',
                'authorized' => Auth::user() != null && Auth::user()->can('view', $article),
            ],
            'back' => [
                'url' => $back_url,
                'caption' => __('Close'),
                'icon' => 'times-circle',
                'authorized' => Auth::user() != null && Auth::user()->can('viewAny', WikiArticle::class),
            ],
        ];
    }
}
