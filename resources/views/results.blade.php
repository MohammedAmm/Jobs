@extends('layouts.app')

@section('content')
<div class="text-center searchsection" style="margin-top:100px;">
				<h1>Results</h1> 
				<div class="row">
				@forelse($results as $object)
			 		<a href="{{route('profile', $object->user->id)}}" class="btn btn-lg"><img src="{{Storage::url($object->user->worker->avatar)}}" style="width:60px; height:60px; float:left; border-radius:50%; margin-right:25px;">{{$object->user->name}}
			 		<br>
			 		<br>
			 		<small>{{$object->user->worker->wage}}EGP/H</small>
			 		</a>

			 		@if($object->user->worker->averageRating()==null)
			 		0
					@endif
					{{$object->user->worker->averageRating()}}
			 		 by {{$object->user->worker->totalRatings()}}
					@empty
					<h2>There is no workers in ur area!..</h2>

				@endforelse
				
	</div>
</div>
@endsection
