@extends('admin.layouts.app')
@section('title','address | Edit')
@section('content')
	{!! Form::model($address, [
    'method' => 'PATCH',
    'route' => ['addresses.update', $address->id]
	]) !!}
		{!! Form::label('name', 'Name:') !!}
		{!! Form::text('name', null, ['class'=>'form-control']) !!}
		{!! Form::label('name_ar', 'Name_ar:') !!}
		{!! Form::text('name_ar', null, ['class'=>'form-control']) !!}
        <br>
		{!!Form::select('city_id',$cities,$address->city_id,[])!!}
		<br>
		<br>
		{!! Form::submit('Submit', ['class'=>'btn btn-warning']) !!}
	{!! Form::close() !!}
@endsection