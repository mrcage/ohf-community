@extends('layouts.app')

@section('title', __('accounting.accounting'))

@section('content')

    @if(! $transactions->isEmpty())
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th colspan="2" class="fit text-center @if(isset($filter['receipt_no']) || isset($filter['no_receipt'])) text-info @endif"><span class="d-none d-sm-inline">@lang('accounting.receipt') </span>#</th>
                        <th class="fit @if(isset($filter['date_start']) || isset($filter['date_end']) || isset($filter['month'])) text-info @endisset">@lang('app.date')</th>
                        <th class="fit d-table-cell d-sm-none text-right">@lang('app.amount')</th>
                        <th class="fit d-none d-sm-table-cell text-right @if(isset($filter['type']) && $filter['type']=='income') text-info @endisset">@lang('accounting.income')</th>
                        <th class="fit d-none d-sm-table-cell text-right @if(isset($filter['type']) && $filter['type']=='spending') text-info @endisset">@lang('accounting.spending')</th>
                        @if($intermediate_balances !== null)
                            <th class="fit text-right">@lang('accounting.intermediate_balance')</th>
                        @endif
                        <th class="@isset($filter['category']) text-info @endisset">@lang('app.category')</th>
                        @if($secondary_categories !== null)
                            <th class="@isset($filter['secondary_category']) text-info @endisset">@lang('app.secondary_category')</th>
                        @endif
                        <th class="@isset($filter['project']) text-info @endisset">@lang('app.project')</th>
                        @if($locations !== null)
                            <th class="@isset($filter['location']) text-info @endisset">@lang('app.location')</th>
                        @endif
                        @if($cost_centers !== null)
                            <th class="@isset($filter['cost_center']) text-info @endisset">@lang('accounting.cost_center')</th>
                        @endif
                        <th class="d-none d-sm-table-cell @isset($filter['description']) text-info @endisset">@lang('app.description')</th>
                        @if($has_suppliers)
                            <th class="d-none d-sm-table-cell @isset($filter['supplier']) text-info @endisset">@lang('accounting.supplier')</th>
                        @endif
                        <th class="d-none d-sm-table-cell @isset($filter['attendee']) text-info @endisset">@lang('accounting.attendee')</th>
                        <th class="fit d-none d-md-table-cell @isset($filter['today']) text-info @endisset">@lang('app.registered')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td class="fit text-center cursor-pointer @if(empty($transaction->receipt_pictures) && isset($transaction->receipt_no)) table-warning receipt-picture-missing @else table-success @endif" data-transaction-id="{{ $transaction->id }}">
                                @isset($transaction->receipt_no)
                                    @if(filled($transaction->receipt_pictures))
                                        @php
                                            $urls = collect($transaction->receipt_pictures)
                                                ->filter(fn ($picture) => Storage::exists($picture))
                                                ->map(fn ($picture) => [ 'url' => Storage::url($picture), 'image' => Str::startsWith(Storage::mimeType($picture), 'image/')]);
                                            if ($urls->filter(fn ($data) => $data['image'])->isNotEmpty()) {
                                                $icon = $urls->count() > 1 ? 'images' : 'image';
                                            } else {
                                                $icon = 'file';
                                            }
                                        @endphp
                                        @if(filled($urls))
                                            <x-icon :icon="$icon" :data-urls='$urls->toJson()' class="lightbox" />
                                        @endif
                                    @else
                                        <x-icon icon="upload" />
                                    @endif
                                @endisset
                            </td>
                            <td class="fit text-right" >
                                {{ $transaction->receipt_no }}
                            </td>
                            <td class="fit">
                                <a href="{{ route('accounting.transactions.show', $transaction) }}">
                                    {{ $transaction->date }}
                                </a>
                            </td>
                            <td class="fit d-table-cell d-sm-none text-right @if($transaction->type == 'income') text-success @elseif($transaction->type == 'spending') text-danger @endif">{{ number_format($transaction->amount, 2) }}</td>
                            <td class="fit d-none d-sm-table-cell text-right text-success">@if($transaction->type == 'income') {{ number_format($transaction->amount, 2) }}@endif</td>
                            <td class="fit d-none d-sm-table-cell text-right text-danger">@if($transaction->type == 'spending') {{ number_format($transaction->amount, 2) }}@endif</td>
                            @if($intermediate_balances !== null)
                                <td class="fit text-right">{{ number_format($intermediate_balances[$transaction->id], 2) }}</td>
                            @endif
                            <td>{{ $transaction->category }}</td>
                            @if($secondary_categories !== null)
                                <td>{{ $transaction->secondary_category }}</td>
                            @endif
                            <td>{{ $transaction->project }}</td>
                            @if($locations !== null)
                                <td>{{ $transaction->location }}</td>
                            @endif
                            @if($cost_centers !== null)
                                <td>{{ $transaction->cost_center }}</td>
                            @endif
                            <td class="d-none d-sm-table-cell">{{ $transaction->description }}</td>
                            @if($has_suppliers)
                                <td class="d-none d-sm-table-cell">
                                    @isset($transaction->supplier)
                                        @can('view', $transaction->supplier)
                                            <a href="{{ route('accounting.suppliers.show', $transaction->supplier) }}">
                                                {{ $transaction->supplier->name }}
                                            </a>
                                        @else
                                            {{ $transaction->supplier->name }}
                                        @endcan
                                    @endisset
                                </td>
                            @endif
                            <td class="d-none d-sm-table-cell">{{ $transaction->attendee }}</td>
                            @php
                                $audit = $transaction->audits()->first();
                            @endphp
                            <td class="fit d-none d-md-table-cell">{{ $transaction->created_at }} @if(isset($audit) && isset($audit->getMetadata()['user_name']))({{ $audit->getMetadata()['user_name'] }})@endif</td>
                        </tr>
                    @endforeach
                </tbody>
                @if(count($filter) > 0)
                    @php
                        $sum_income = $transactions->where('type', 'income')->sum('amount');
                        $sum_spending = $transactions->where('type', 'spending')->sum('amount');
                    @endphp
                    @if($sum_income > 0 || $sum_spending > 0)
                        <tr>
                            <td colspan="2" rowspan="2" class="align-middle">@lang('app.total')</td>
                            <td class="text-right d-none d-sm-table-cell">
                                <u class="text-success">{{ number_format($sum_income, 2) }}</u>
                            </td>
                            <td class="text-right d-none d-sm-table-cell">
                                <u class="text-danger">{{ number_format($sum_spending, 2) }}</u>
                            </td>
                            <td class="text-right d-table-cell d-sm-none">
                                @if($sum_income > 0)<u class="text-success">{{ number_format($sum_income, 2) }}</u><br>@endif
                                @if($sum_spending > 0)<u class="text-danger">{{ number_format($sum_spending, 2) }}</u>@endif
                                <u>{{ number_format($sum_income - $sum_spending, 2) }}</u>
                            </td>
                            <td colspan="6" rowspan="2"></td>
                        </tr>
                        <tr class="d-none d-sm-table-row">
                            <td colspan="2" class="text-center"><u>{{ number_format($sum_income - $sum_spending, 2) }}</u></td>
                        </tr>
                    @endif
                @endif
            </table>
        </div>
        <div style="overflow-x: auto">
            {{ $transactions->appends($filter)->links() }}
        </div>
    @else
        <x-alert type="info">
            @lang('accounting.no_transactions_found')
        </x-alert>
    @endif
@endsection
