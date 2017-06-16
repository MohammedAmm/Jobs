@extends('layouts.app')
@section('content')
		<br>
		<br>
		<br>
		<br>
		<br>
		<br>
		<h1 class="text-center">{{$worker->phone}}</h1>
		<h2 class="text-center">Wage:{{$worker->wage}} EGP</h2>
		<b>Rating</b>
		{{$worker->averageRating()}} by <b>{{$worker->totalRatings()}} users</b>
		
		@if($canRate)
			{!! Form::open(['method'=>'post', 'route' => 'ratings.store']) !!}
			<input type="hidden" name="id" value="{{ $worker->user_id }}"/>
			<select name="rate">
			<option value="5">5</option>
			<option value="4">4</option>
			<option value="3">3</option>
			<option value="2">2</option>
			<option value="1">1</option>
			</select>
			{!! Form::submit('Submit', []) !!}
			{!! Form::close() !!}		
		@endif
@endsection