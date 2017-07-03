@extends('layouts.app')
@section('styles')
		{!!Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
		{!!Html::style('website/css/profile.css')!!}  
@endsection
@section('scripts')
  {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
  	{!! Html::script('website/js/bootstrap-rating-input.min.js')!!}
@endsection
@section('content')
<div class="wrapper">
  <div class="container-fluid">
  <div class="rectangleL"></div>
  <div class="rectangleR"></div>
  <div class="profile-left container-fluid">
    <img src="{{Storage::url($worker->avatar)}}" alt="" class="img-responsive">
    <div style="margin-top:50px;">
      <h4>Phone: <span>{{$worker->phone}}</span></h4>
      <h4>Age: <span>25</span></h4>
      <h4>Address: <span>{{$worker->address->name}}, {{$worker->address->city->city}}</span></h4>
    </div>
  </div>

  <div class="profile-right">
    <h4 style="color:#3a629a; font-size:30px; display:inline; font-family:Arial;">{{$worker->user->name}}</h4>
    <img src="/location.jpg" alt="" style="display:inline; padding-left:50px; margin-top:-5px;">
    <h4 style="color:#a4a4a4; font-size:15px; display:inline; padding:5px;">{{$worker->address->city->city}}</h4>
    <h4 style="color:#1cb9ec; font-size:20px;">{{$worker->job->name}}</h4>
    <h4 style="color:#a4a4a4; font-size:20px; margin-top:40px;">Rating</h4>
    <div class="stars">
			<input type="number" name="your_awesome_parameter" value="{{(int)$worker->rate}}" data-inline data-readonly id="some_id" class="rating" />
			<span>({{$worker->no_rates}})</span>
			</div>
    
	<h4 style="display:inline; margin-left:250px; color:#3a629a; font-size:30px; font-family:monospace; font-weight:600;">{{$worker->wage}} EGP/HR</h4>
    <hr style="height:1.5px;background-color:#a4a4a4;">
    <h4 style="font-size:30px;color:#1c4c8d; font-family:arial; margin-top:30px; margin-bottom:15px">Reviews</h4>
    @foreach($worker->ratings as $rat)
    <div>
      <h4 style="font-size: 23px; font-family:Arial;">{{$rat->user->name}} on {{$rat->created_at->format('d M Y')}}</h4>
      <div class="stars">
			<input type="number" name="your_awesome_parameter" value="{{(int)$rat->ratings}}" data-inline data-readonly id="some_id" class="rating" />
			</div>
      <p style="font-size: 16px;">{{$rat->comment}}</p>
    </div>
    @endforeach
	@if($canRate)
			{!! Form::open(['method'=>'post', 'route' => 'ratings.store']) !!}
			<input type="hidden" name="id" value="{{ $worker->user_id }}"/>
			<div class="stars">
				<input type="number" name="rate" value="" data-inline id="some_id" class="rating" />
			</div>
			{!! Form::submit('Submit', []) !!}
			{!! Form::close() !!}		
		@endif
  </div>


</div>
</div>		

@endsection