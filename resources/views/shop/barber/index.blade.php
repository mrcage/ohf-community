@extends('layouts.app')

@section('title', __('shop.barber_shop'))

@section('content')
    @isset($list)
        @if(count($list) > 0)
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="fit text-right">#</th>
                            <th>@lang('people.person')</th>
                            <th class="fit"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $item)
                            @php
                                $person = $item['person'];
                            @endphp
                            <tr>
                                <td class="fit text-right align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    @if(optional($person->helper)->isActive)
                                        <strong class="text-warning">{{ strtoupper(__('people.helper')) }}</strong>
                                    @endif
                                    @can('view', $person)
                                        <a href="{{ route('people.show', $person) }}" target="_blank">
                                    @endcan
                                        @include('people.person-label', [ 'person' => $person ])
                                    @can('view', $person)
                                        </a>
                                    @endcan
                                </td>
                                <td class="fit align-middle">
                                    @if($item['redeemed'] != null)
                                        {{ $item['redeemed']->format('H:i') }}
                                    @else
                                        <button type="button" 
                                            class="btn btn-primary btn-sm checkin-button" 
                                            data-person-id="{{ $person->id }}"
                                            data-person-name="{{ $person->fullName }}">
                                                @icon(check)<span class="d-none d-sm-inline"> @lang('shop.check_in')</span>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            @component('components.alert.warning')
                @lang('shop.no_persons_registered_today')
            @endcomponent
        @endif
    @else
        @component('components.alert.warning')
            @lang('app.not_configured')
        @endcomponent
    @endisset
@endsection

@section('script')
    var csrfToken = '{{ csrf_token() }}';
    var checkinUrl = '{{ route('shop.barber.checkin') }}';
    var scannerDialogTitle = '@lang('people.qr_code_scanner')';
    var scannerDialogWaitMessage = '@lang('app.please_wait')';
    var checkInConfirmationMessage = '@lang('shop.confirm_checkin_of_person')';
@endsection

@section('footer')
    <script src="{{ asset('js/bank.js') }}?v={{ $app_version }}"></script>
@endsection
