@extends('layouts.app')

@section('title', __('app.report') . ': ' . __('reports.monthly_summary'))

@section('content')
    <div id="people-app">
        <monthly-summary-report-page>
            @lang('app.loading')
        </monthly-summary-report-page>
    </div>
@endsection

@push('footer')
    <script src="{{ mix('js/people.js') }}"></script>
@endpush
