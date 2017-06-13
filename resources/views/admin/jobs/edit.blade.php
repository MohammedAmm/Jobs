@extends('admin.layouts.app')
@section('title','Job | Edit')
@section('content')
	{!! Form::model($job, [
    'method' => 'PATCH',
    'route' => ['jobs.update', $job->id]
	]) !!}
		{!! Form::label('name', 'Name:') !!}
		{!! Form::text('name', null, ['class'=>'form-control']) !!}
		{!! Form::submit('Submit', ['class'=>'btn btn-warning']) !!}
	{!! Form::close() !!}
@endsection