@extends('layouts.app')

@section('title', __('library::library.edit_book'))

@section('content')
    {!! Form::model($book, ['route' => ['library.books.update', $book], 'method' => 'put']) !!}
        {{ Form::bsText('isbn', null, [ ], __('library::library.isbn')) }}
        {{ Form::bsText('title', null, [ 'required' ],  __('app.title')) }}
        {{ Form::bsText('author', null, [ ], __('library::library.author')) }}
        {{ Form::bsText('language', null, [ ], __('app.language')) }}
        {{ Form::bsSubmitButton(__('app.update')) }}
    {!! Form::close() !!}
@endsection