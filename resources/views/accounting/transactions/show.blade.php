@extends('layouts.app', ['wide_layout' => false])

@section('title', __('Show transaction'))

@section('content')

    @include('accounting.transactions.snippet')

    <p class="mt-3">
        @isset($prev_id)
            <a href="{{ route('accounting.transactions.show', $prev_id) }}" class="btn btn-sm btn-secondary">
                &lsaquo; Previous
            </a>
        @endisset
        @isset($next_id)
            <a href="{{ route('accounting.transactions.show', $next_id) }}" class="btn btn-sm btn-secondary">
                Next &rsaquo;
            </a>
        @endisset
    </p>

@endsection

@push('footer')
    <script>
        @include('accounting.transactions.controlled')
    </script>
@endpush

