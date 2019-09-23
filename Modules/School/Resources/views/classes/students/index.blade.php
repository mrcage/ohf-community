@extends('layouts.app')

@section('title', __('school::students.students'))

@section('content')

    <h3>{{ $class->name }}</h3>
    <p>
        <strong>@lang('school::classes.teacher'):</strong> {{ $class->teacher_name }}<br>
        <strong>@lang('app.period'):</strong> {{ $class->start_date->toDateString() }} - {{ $class->end_date->toDateString() }}<br>
        <strong>@lang('school::classes.room'):</strong> {{ $class->room_name }}<br>
        <strong>@lang('app.capacity'):</strong> {{ $class->students()->count() }} / {{ $class->capacity }}
    </p>
    @if( ! $class->students->isEmpty() )
        <div class="table-responsive">
            <table class="table table-sm table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th class="">@lang('app.name')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($class->students as $student)
                        <tr>
                            <td>
                                @can('view', $student)
                                    <a href="{{ route('people.show', $student) }}">
                                @endcan
                                @include('people::person-label', ['person'=> $student])
                                @can('view', $student)
                                    </a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        @component('components.alert.info')
            @lang('school::students.no_students_registered_in_class')
        @endcomponent
    @endif

@endsection
