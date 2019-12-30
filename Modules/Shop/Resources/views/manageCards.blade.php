@extends('layouts.app')

@section('title', __('shop::shop.shop'))

@section('content')

    <div id="shop-app">
        @php
            $lang_arr = lang_arr([
                'app.date',
                'app.actions',
                'shop::shop.no_suitable_cards_found',
                'shop::shop.delete_cards',
                'shop::shop.non_redeemed_cards'
            ]);
        @endphp
        <shop-card-manager
            summary-url="{{ route('shop.summary') }}"
            delete-url="{{ route('shop.deleteNonRedeemed') }}"
            :lang='@json($lang_arr)'
        ></shop-card-manager>
    </div>

@endsection

@section('script')
    var scannerDialogTitle = '@lang('people::people.qr_code_scanner')';
    var scannerDialogWaitMessage = '@lang('app.please_wait')';
@endsection

@section('footer')
    <script src="{{ asset('js/shop.js') }}?v={{ $app_version }}"></script>
@endsection