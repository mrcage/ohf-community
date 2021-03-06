@extends('layouts.app')

@section('title', __('Summary') . ' - ' . __('All wallets'))

@section('content')

    <div class="row">
        <div class="col-md">
            <h4 class="mb-4">{{ $heading }}</h4>
        </div>
        <div class="col-xl-auto col-md">
            <div class="row">
                @if(sizeof($months) > 0)
                    <div class="col-xl col-sm-6">
                        {{ Form::bsSelect('monthrange', $months, $currentRange, [ 'id' => 'monthrange', 'placeholder' => '- ' . __('by month') . ' -' ], '') }}
                    </div>
                @endif
                @if(sizeof($years) > 0)
                    <div class="col-xl col-sm-6">
                        {{ Form::bsSelect('yearrange', $years, $currentRange, [ 'id' => 'yearrange', 'placeholder' => '- ' . __('by year') . ' -' ], '') }}
                    </div>
                @endif
                @if(sizeof($projects) > 0)
                    <div class="col-xl col-sm-6">
                        {{ Form::bsSelect('project', collect($projects)->mapWithKeys(fn ($e) => [ $e => $e ]), $currentProject, [ 'id' => 'project', 'placeholder' => '- ' . __('All projects') . ' -' ], '') }}
                    </div>
                @endif
                @if(sizeof($locations) > 0)
                    <div class="col-xl col-sm-6">
                        {{ Form::bsSelect('location', collect($locations)->mapWithKeys(fn ($e) => [ $e => $e ]), $currentLocation, [ 'id' => 'location', 'placeholder' => '- ' . __('All locations') . ' -' ], '') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">

        {{-- Summary by wallet --}}
        <div class="col-md-12 col-xl-6">
            <div class="card shadow-sm mb-4 table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="card-header">
                        <th></th>
                        <th class="text-right">@lang('Income')</th>
                        <th class="text-right">@lang('Spending')</th>
                        <th class="text-right">@lang('Fees')</th>
                        <th class="text-right">@lang('Difference')</th>
                        <th class="text-right">@lang('Wallet')</th>
                    </thead>
                    <tbody>
                        @foreach($wallets as $w)
                            <tr>
                                <td>
                                    @can('viewAny', App\Models\Accounting\Wallet::class)
                                        <a href="{{ route('accounting.transactions.index', $w['wallet']) }}">
                                    @endcan
                                        {{ $w['wallet']->name }}
                                    @can('viewAny', App\Models\Accounting\MoneyTransaction::class)
                                        </a>
                                    @endcan
                                </td>
                                <td class="text-right">{{ number_format($w['income'], 2) }}</td>
                                <td class="text-right">{{ number_format($w['spending'], 2) }}</td>
                                <td class="text-right">{{ number_format($w['fees'], 2) }}</td>
                                <td class="text-right {{ $w['income'] > $w['spending'] ? 'text-success' : 'text-danger' }}">{{ number_format($w['income'] - $w['spending'], 2) }}</td>
                                <td class="text-right {{ $w['amount'] > 0 ? 'text-success' : 'text-danger' }}">{{ number_format($w['amount'], 2) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><b>@lang('Sum across all wallets')</b></td>
                            <td class="text-right"><b>{{ number_format($income, 2) }}</b></td>
                            <td class="text-right"><b>{{ number_format($spending, 2) }}</b></td>
                            <td class="text-right"><b>{{ number_format($fees, 2) }}</b></td>
                            <td class="text-right {{ $income > $spending ? 'text-success' : 'text-danger' }}"><b>{{ number_format($income - $spending, 2) }}</b></td>
                            <td class="text-right {{ $wallet_amount > 0 ? 'text-success' : 'text-danger' }}"><b>{{ number_format($wallet_amount, 2) }}</b></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Revenue by categories --}}
        <div class="col-md col-xl-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">@lang('Categories')</div>
                <table class="table table-strsiped mb-0">
                    <tbody>
                        @if(count($revenueByCategory) > 0)
                            @foreach($revenueByCategory as $v)
                                <tr>
                                    <td>{{ $v['name'] }}</td>
                                    <td class="text-right {{ $v['amount'] > 0 ? 'text-success' : 'text-danger' }}">{{ number_format($v['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td><em>@lang('No data available in the selected time range.')</em></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        @if($revenueBySecondaryCategory !== null)
            {{-- Revenue by secondary category --}}
            <div class="col-md col-xl-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header">@lang('Secondary Categories')</div>
                    <table class="table mb-0">
                        <tbody>
                            @if(count($revenueBySecondaryCategory) > 0)
                                @foreach($revenueBySecondaryCategory as $v)
                                    <tr>
                                        <td>
                                            @isset($v['name'])
                                                {{ $v['name'] }}
                                            @else
                                                <em>@lang('No Secondary Category')</em>
                                            @endif
                                        </td>
                                        <td class="text-right {{ $v['amount'] > 0 ? 'text-success' : 'text-danger' }}">{{ number_format($v['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td><em>@lang('No data available in the selected time range.')</em></td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Revenue by project --}}
        <div class="col-md col-xl-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header">@lang('Projects')</div>
                <table class="table mb-0">
                    <tbody>
                        @if(count($revenueByProject) > 0)
                            @foreach($revenueByProject as $v)
                                <tr>
                                    <td>
                                        @isset($v['name'])
                                            {{ $v['name'] }}
                                        @else
                                            <em>@lang('No project')</em>
                                        @endif
                                    </td>
                                    <td class="text-right {{ $v['amount'] > 0 ? 'text-success' : 'text-danger' }}">{{ number_format($v['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td><em>@lang('No data available in the selected time range.')</em></td></tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('footer')
    <script>
        $(function () {
            $('#monthrange').on('change', function () {
                var val = $(this).val();
                var month = ''
                var year = ''
                if (val != '') {
                    var arr = val.split('-');
                    month = parseInt(arr[1]);
                    year = arr[0]
                }
                document.location = '{{ route('accounting.transactions.globalSummary') }}?month=' + month + '&year=' + year;
            });
            $('#yearrange').on('change', function () {
                var val = $(this).val();
                document.location = '{{ route('accounting.transactions.globalSummary') }}?year=' + val;
            });
            $('#project').on('change', function () {
                var val = $(this).val();
                document.location = '{{ route('accounting.transactions.globalSummary') }}?project=' + val;
            });
            $('#location').on('change', function () {
                var val = $(this).val();
                document.location = '{{ route('accounting.transactions.globalSummary') }}?location=' + val;
            });
        });
    </script>
@endpush
