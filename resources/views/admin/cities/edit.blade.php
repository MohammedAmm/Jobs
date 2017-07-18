@extends('admin.layouts.app')
@section('title','city | Edit')
@section('content')
	{!! Form::model($cit, [
    'method' => 'PATCH',
    'route' => ['cities.update', $cit->id]
	]) !!}
		{!! Form::label('city', 'Name:') !!}
		{!! Form::text('city', null, ['class'=>'form-control']) !!}
		<br>
			{!! Form::label('city_ar', 'Name_ar') !!}
			{!! Form::text('city_ar', null, ['class'=>'form-control']) !!}
		{!! Form::submit('Submit', ['class'=>'btn btn-warning']) !!}
	{!! Form::close() !!}
@endsection