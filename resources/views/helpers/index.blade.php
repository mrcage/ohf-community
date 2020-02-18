@extends('layouts.app')

@section('title', __('helpers.helpers'))

@section('content')

    <div class="row">

        {{-- Scopes --}}
        <div class="col-md-auto text-nowrap" style="overflow-x: auto">
            <div class="btn-group btn-group-sm mb-3" role="group" aria-label="Scopes">
                @foreach($scopes as $scope)
                    <a href="{{ $scope['url'] }}" class="btn @if($scope['active']) btn-dark @else btn-secondary @endif">{{ $scope['label'] }}</a>
                @endforeach
            </div>
        </div>


        {{-- Groupings --}}
        <div class="col-md-auto text-right text-nowrap" style="overflow-x: auto">
            <div class="btn-group btn-group-sm mb-3" role="group" aria-label="Groupings">
                @foreach($groupings as $grouping)
                    <a href="{{ $grouping['url'] }}" class="btn @if($grouping['active']) btn-dark @else btn-secondary @endif">{{ $grouping['label'] }}</a>
                @endforeach
                @if($groupings->where('active', true)->count() > 0)
                    <a href="{{ route('people.helpers.index') }}?grouping=" class="btn btn-secondary">@icon(times)</a>
                @endif
            </div>
        </div>

        {{-- Displays --}}
        <div class="col-md-auto">
            <div class="btn-group btn-group-sm mb-3" role="group" aria-label="Displays">
                @foreach($displays as $display)
                    <a href="{{ $display['url'] }}" class="btn @if($display['active']) btn-dark @else btn-secondary @endif" title="{{ $display['label'] }}">@icon({{ $display['icon'] }})</a>
                @endforeach
            </div>
        </div>
    </div>

    @if(isset($groups) && $data->filter(function($d){ return count($d) > 0; })->count() > 0)
        @if($selected_display == 'list')
            @component('helpers.table', ['fields' => $fields])
                @foreach($groups as $group)
                    @if($data[$loop->index]->count() > 0)
                        <tr class="table-secondary">
                            <th colspan="{{ $fields->count() }}">{{ $group }} <small>({{ $data[$loop->index]->count() }})</small></th>
                        </tr>
                        @include('helpers.tablebody', ['data' => $data[$loop->index]])
                    @endif
                @endforeach
            @endcomponent
        @elseif($selected_display == 'grid')
            @foreach($groups as $group)
                @if($data[$loop->index]->count() > 0)
                <h4 class="mb-3">{{ $group }} <small>({{ $data[$loop->index]->count() }})</small></h4>
                @include('helpers.grid', ['data' => $data[$loop->index]])
                @endif
            @endforeach
        @endif
    @elseif(!isset($groups) && !$data->isEmpty() )
        @if($selected_display == 'list')
            @component('helpers.table', ['fields' => $fields])
                @include('helpers.tablebody')
            @endcomponent
        @elseif($selected_display == 'grid')
            @include('helpers.grid')
        @endif
        <p><small>@lang('app.n_results_found', [ 'num' => $data->count() ])</small></p>
    @else
        @component('components.alert.info')
            @lang('people.no_helpers_found')
        @endcomponent
    @endif

@endsection