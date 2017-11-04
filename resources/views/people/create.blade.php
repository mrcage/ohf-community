@extends('layouts.app')

@section('title', 'Register Person')

@section('buttons')
    <a href="{{ route( $closeRoute ) }}" class="btn btn-secondary d-none d-md-inline-block">@icon(times-circle) Cancel</a>
@endsection

@section('backLink', route( $closeRoute ))

@section('content')

    {!! Form::open(['route' => 'people.store']) !!}
		<div class="card mb-4">
			<div class="card-body">
				<div class="form-row">
					<div class="col-md">
                        {{ Form::bsText('name', null, [ 'required', 'autofocus' ]) }}
					</div>
					<div class="col-md">
                        {{ Form::bsText('family_name', null, [ 'required' ]) }}
					</div>
				</div>
				<div class="form-row">
					<div class="col-md">
                        {{ Form::bsNumber('case_no', null, [ ], 'Case Number') }}
					</div>
                    <div class="col-md">
                        {{ Form::bsText('medical_no', null, [], 'Medical Number') }}
                    </div>
                    <div class="col-md">
                        {{ Form::bsText('registration_no', null, [], 'Registration Number') }}
                    </div>
                    <div class="col-md">
                        {{ Form::bsText('section_card_no', null, [], 'Section Card Number') }}
                    </div>
				</div>
				<div class="form-row">
                    <div class="col-md">
                        {{ Form::bsText('nationality') }}
                    </div>
					<div class="col-md">
                        {{ Form::bsText('languages') }}
					</div>
					<div class="col-md">
                        {{ Form::bsText('skills') }}
					</div>
				</div>
                {{ Form::bsText('remarks') }}
			</div>
		</div>
        @if ( $closeRoute == 'bank.index' )
            <div class="card mb-4">
                <div class="card-body">
                    {{ Form::bsNumber('value', $transaction_value, [ 'style' => 'width:80px', 'min' => 0, 'max' => $transaction_value ], 'Transaction') }}
                </div>
            </div>
        @endif

		<p>
            {{ Form::bsSubmitButton('Register') }}
        </p>

    {!! Form::close() !!}
    
@endsection
