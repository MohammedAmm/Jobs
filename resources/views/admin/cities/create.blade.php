@extends('admin.layouts.app')
@section('title','Create')

@section('content')
	<div class="row">
		<div class="well">
			
		{!! Form::open(['route'=>'cities.store','method'=>'POST']) !!}
			{!! Form::label('city', 'Name') !!}
			{!! Form::text('city', null, ['class'=>'form-control']) !!}
			<br>
			{!! Form::submit('Add', ['class'=>'btn btn-success']) !!}
		{!! Form::close() !!}
				
		</div>
		
	</div>
	

@endsection