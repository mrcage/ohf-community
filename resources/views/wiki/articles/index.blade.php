@extends('layouts.app')

@section('title', __('wiki.articles'))

@section('content')

    @if( ! $articles->isEmpty() )
        <div>
            <h2>@lang('wiki.articles')</h2>
            <div class="columns-3">
                @foreach ($articles as $article)
                    <a href="{{ route('wiki.articles.show', $article) }}">{{ $article->title }}</a><br>
                @endforeach
            </div>
            {{ $articles->links() }}
            <p class="mt-2"><small>{{ trans_choice('wiki.num_articles_in_total', $articles->total(), [ 'num' => $articles->total() ]) }}</small></p>
        </div>
        <div>
            <h2 class="mt-2">@lang('app.tags')</h2>
            <div class="columns-3">
                @foreach ($tags as $tag)
                    @if($tag->wikiArticles()->count() > 0)
                    <a href="{{ route('wiki.articles.tag', $tag) }}">{{ $tag->name }}</a> ({{ $tag->wikiArticles()->count() }})
                    <br>
                    @endif
                @endforeach
            </div>
        </div>
    @else
        @component('components.alert.info')
            @lang('wiki.no_articles_found')
        @endcomponent
	@endif
	
@endsection
