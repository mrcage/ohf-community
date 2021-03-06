@extends('layouts.app')

@section('title', __('Manage members'))

@section('content')

    {!! Form::model($role, ['route' => ['roles.updateMembers', $role], 'method' => 'put']) !!}

        <div class="mb-3">
            <div class="form-row">
                <div class="col-md">
                    {{ Form::bsText('name', null, [ 'readonly' ], __('Name')) }}
                </div>
            </div>
        </div>

        <div class="card-deck mb-3">

            {{-- Users --}}
            <div class="card shadow-sm">
                <div class="card-header">@lang('Users')</div>
                <div class="card-body columns-3">
                    {{ Form::bsCheckboxList('users[]', $users, $role->users()->orderBy('name')->get()->pluck('name', 'id')->keys()->toArray()) }}
                </div>
            </div>

        </div>

        <p>
            <x-form.bs-submit-button :label="__('Update')"/>
        </p>

    {!! Form::close() !!}

@endsection
