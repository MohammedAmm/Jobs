@extends('layouts.app')
@section('styles')
	{!!Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}			
	{!!Html::style('website/css/search.css')!!}
@endsection
@section('scripts')
	{!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')!!}
	{!! Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')!!}	
	{!! Html::script('website/js/bootstrap-rating-input.min.js')!!}
@endsection

@section('content')
<div class="container-fluid">
  <div class="container-fluid cards">
    <h1>Search Results:</h1>
	@forelse($results as $object)
    <div class="card">
        <img src="{{Storage::url($object->user->worker->avatar)}}" alt="" class="img-responsive">
        <h4 id="name">{{$object->user->name}}</h4>
        <div class="revstr">
          <div class="stars">
          <input type="number" name="your_awesome_parameter" value="{{(int)$object->user->worker->rate}}" data-inline data-readonly id="some_id" class="rating" /></div>
          <span id="noreviews">({{$object->user->worker->no_rates}})</span>
        </div>
        <h4 id="job">{{$object->user->worker->job->name}}</h4>
        <a id="profilebutton" class="btn" href="{{route('profile', $object->user->id)}}" id="profilebutton">View Profile</a>
        <h4 id="wage">{{$object->user->worker->wage}}EGP/HR</h4>
    </div>

	@empty
		<h2 class="text-center">There is no workers in ur area!..</h2>
	@endforelse
	<div class="text-center">
			{!! $results->appends(Request::only(['adr','nam']))->links(); !!}
	</div>
</div>
</div>
</div>
@endsection
