@extends('layouts.app')

@section('content')
<div class="text-center searchsection">
<h1>Results</h1> 

			@forelse($results as $object)
	 		<a href="{{route('profile', $object->user->id)}}" class="btn btn-lg">{{$object->user->name}}</a>
			@empty
			<h2>There is no workers in ur area!..</h2>
			@endforelse
			
	
</div>

@endsection
