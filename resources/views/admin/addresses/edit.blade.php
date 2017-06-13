@extends('admin.layouts.app')
@section('title','address | Edit')
@section('content')
	{!! Form::model($address, [
    'method' => 'PATCH',
    'route' => ['addresses.update', $address->id]
	]) !!}
		{!! Form::label('name', 'Name:') !!}
		{!! Form::text('name', null, ['class'=>'form-control']) !!}
		{!! Form::submit('Submit', ['class'=>'btn btn-warning']) !!}
	{!! Form::close() !!}
@endsection