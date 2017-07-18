@extends('layouts.app')
@section('styles')
		{!!Html::style('website/css/profile.css')!!}  
@endsection
@section('scripts')
  {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
  	{!! Html::script('website/js/bootstrap-rating-input.min.js')!!}
@endsection
@section('content')

 <!-- Modal -->
  <div class="modal fade" id="reviewModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{$worker->user->name}}</h4>
        </div>
        <div class="modal-body">
        {!! Form::open(['method'=>'post', 'route' => 'ratings.store']) !!}
            <input type="hidden" name="id" value="{{ $worker->user_id }}"/>
            <div class="stars" required>
              <input type="number" name="rate" id="some_id" class="rating"/>
            </div>
            <div class="form-group">
                <label for="comment">Comment:</label>
                <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea>
		        </div>
            {!! Form::submit('Submit', ['class'=>'btn btn-success']) !!}
        {!! Form::close() !!}		
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<div class="container-fluid content" style="<?php if(\Config::get('app.locale')=='ar')echo 'direction:rtl;'?>">
  <div class="rectangleL"></div>
  <div class="rectangleR"></div>
  <div class="profile-left container-fluid" style="<?php if(\Config::get('app.locale')=='ar')echo 'margin-right:160px;'?>">
    <img src="{{Storage::url($worker->avatar)}}" alt="" class="img-responsive" >
    <div style="margin-top:110px;">
      <h4>{{trans('auth.phonenumber')}}: <span>{{$worker->phone}}</span></h4>
      <h4>{{trans('auth.age')}}: <span>{{$worker->age}}</span></h4>
      <h4>{{trans('auth.address')}}: <span>
                        @if(\Config::get('app.locale')=='ar')
                            {{$worker->address->name_ar}}
                        @else
                            {{$worker->address->name}}
                        @endif             ,  @if(\Config::get('app.locale')=='ar')
                            {{$worker->address->city->city_ar}}
                        @else
                            {{$worker->address->city->city}}
                        @endif           </span></h4>
    </div>
  </div>

  <div class="profile-right"style="<?php if(\Config::get('app.locale')=='ar')echo 'margin-right:-150px;'?>">
    <h4 style="color:#3a629a; font-size:30px; display:inline; font-family:Arial;">{{$worker->user->name}}</h4>
    <img src="/location.jpg" alt="" style="display:inline; padding-left:50px; margin-top:-5px; <?php if(\Config::get('app.locale')=='ar')echo 'margin-right:50px; margin-left:-50px;'?>">
    <h4 style="color:#a4a4a4; font-size:15px; display:inline; padding:5px;"> @if(\Config::get('app.locale')=='ar')
                            {{$worker->address->city->city_ar}}
                        @else
                            {{$worker->address->city->city}}
                        @endif           </h4>
    <h4 style="color:#1cb9ec; font-size:20px;"> @if(\Config::get('app.locale')=='ar')
                            {{$worker->job->name_ar}}
                        @else
                            {{$worker->job->name}}
                        @endif           </h4>
    <h4 style="color:#a4a4a4; font-size:20px; margin-top:40px;">{{trans('main.rate')}}</h4>
    <div class="stars">
			<input type="number" name="your_awesome_parameter" value="{{(int)$worker->rate}}" data-inline data-readonly id="some_id" class="rating" />
			<span>({{$worker->no_rates}})</span>
	
	<h4 style="display:inline; margin-left:250px; color:#3a629a; font-size:30px; font-family:monospace; font-weight:600; <?php if(\Config::get('app.locale')=='ar')echo 'margin-right:225px'?>">{{$worker->wage}} {{trans('main.money')}} </h4>
    <hr style="height:1.5px;background-color:#a4a4a4;">
    <h4 style="font-size:30px;color:#1c4c8d; font-family:arial; margin-top:30px; margin-bottom:15px; display:inline; " >{{trans('main.comment')}}</h4>
    @if($canRate)	
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#reviewModal" style="display:inline;"></button>
		@endif
    @foreach($worker->ratings as $rat)
    <div>
      <h4 style="font-size: 23px; font-family:Arial;">{{$rat->user->name}}</h4>
      <div class="stars">
			<input type="number" name="your_awesome_parameter" value="{{(int)$rat->ratings}}" data-inline data-readonly id="some_id" class="rating" /><small style="font-size:12px;"> @if(\App::getLocale()=='en'){{$rat->created_at->diffForHumans()}}
      @else
      {{\Carbon\Carbon::setLocale('ar')}}
        {{ltrim(Carbon\Carbon::parse($rat->created_at,'Africa/Cairo')->diffForHumans(),'%1')}}
      @endif
      
      </small>
			</div>
      <p style="font-size: 16px;">{{$rat->comment}}</p>
    </div>
    @endforeach
  </div>
  </div>
</div>		
</div>
@endsection