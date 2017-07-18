@extends('admin.layouts.app')
@section('title','Create')

@section('content')
	<div class="row">
		<div class="well">
			
		{!! Form::open(['route'=>'jobs.store','method'=>'POST']) !!}
			{!! Form::label('name', 'Name') !!}
			{!! Form::text('name', null, ['class'=>'form-control']) !!}
			{!! Form::label('name_ar', 'Name_ar') !!}
			{!! Form::text('name_ar', null, ['class'=>'form-control']) !!}
			<br>
			{!! Form::submit('Add', ['class'=>'btn btn-success']) !!}
		{!! Form::close() !!}
				
		</div>
		
	</div>
	

@endsection