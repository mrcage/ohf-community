@extends('layouts.app')

@section('title', __('accounting.transactions'))

@section('content')
    <div id="accounting-app">
        <accounting-app>
            @lang('app.loading')
        </accounting-app>
    </div>
@endsection

@section('footer')
    @php
        $permissions = [
            'configure-accounting' => Gate::allows('configure-accounting'),
        ];
        $config = [
            'accounting.thumbnail_size' => config('accounting.thumbnail_size'),
        ];
    @endphp
    <script>
        window.Laravel.permissions = @json($permissions);
        window.Laravel.config = @json($config);
    </script>
    <script src="{{ asset('js/accounting.js') }}?v={{ $app_version }}"></script>
@endsection
