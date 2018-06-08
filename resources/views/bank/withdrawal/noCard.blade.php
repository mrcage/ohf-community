@extends('bank.layout')

@section('title', __('people.bank'))

@section('wrapped-content')
    <div id="bank-container">

    @component('components.alert.warning')
        Card not registered.
    @endcomponent

    {{ Form::open(['route' => 'bank.registerCardAsPerson']) }}
        {{ Form::hidden('card_no', $cardNo) }}
        <div class="row">
            <div class="col-md">
                {{ Form::bsSubmitButton(__('app.register')) }}
            </div>
            <div class="col-md text-right">
                <button class="btn btn-secondary btn" type="button" id="scan-id-button">@icon(qrcode)<span class="d-none d-sm-inline"> @lang('people.scan_another_card')</span></button> 
                <a class="btn btn-secondary btn" href="{{ route('bank.withdrawal') }}">@icon(search) @lang('people.search_persons')</a>
            </div>        
        </div>

    {{ Form::close() }}

    </div>
@endsection

@section('script')
    var csrfToken = '{{ csrf_token() }}';
    var handoutCouponUrl = '{{ route('bank.handoutCoupon') }}';
    var undoHandoutCouponUrl = '{{ route('bank.undoHandoutCoupon') }}';
    var updateGenderUrl = '{{ route('bank.updateGender') }}';
    var updateDateOfBirthUrl = '{{ route('bank.updateDateOfBirth') }}';
    var updateNationalityUrl = '{{ route('bank.updateNationality') }}';
    var registerCardUrl = '{{ route('bank.registerCard') }}';
    var undoLabel = '@lang('app.undo')';
@endsection

@section('footer')
    <script src="{{ asset('js/bank.js') }}?v={{ $app_version }}"></script>
@endsection