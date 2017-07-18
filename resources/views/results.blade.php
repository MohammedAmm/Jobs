@extends('layouts.app')
@section('styles')		
	{!!Html::style('website/css/search.css')!!}
@endsection
@section('scripts')
   {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
  	{!! Html::script('website/js/bootstrap-rating-input.min.js')!!}
@endsection

@section('content')
<div class="container-fluid" style="<?php if(\App::getLocale()=='ar') echo 'direction:rtl;' ?>">
  <div class="container-fluid cards">
    <h1 style="<?php if(\App::getLocale()=='ar') echo 'margin-right:20.5%' ?>">{{trans('main.searchresults')}}</h1>
	@forelse($results as $object)
    @if(($object->user->verified))
    <div class="card">
        <img src="{{Storage::url($object->user->worker->avatar)}}" alt="" class="img-responsive">
        <h4 id="name">{{$object->user->name}}</h4>
        <div class="revstr <?php if(\App::getLocale()=='ar') echo 'pull-left' ?>">
          <div class="stars" style="<?php if(\App::getLocale()=='ar') echo 'margin-right:-11.5%' ?>">
          <input type="number" name="your_awesome_parameter" value="{{(int)$object->user->worker->rate}}" data-inline data-readonly id="some_id" class="rating" /></div>
          <span id="noreviews">({{$object->user->worker->no_rates}})</span>
        </div>
        <h4 id="job" style="<?php if(\App::getLocale()=='ar') echo 'margin-right:11.5%' ?>">
            @if(\App::getLocale()=='en')
                {{$object->user->worker->job->name}}
            @else
                {{$object->user->worker->job->name_ar}}
            @endif
        </h4>
        <a id="profilebutton" class="btn <?php if(\App::getLocale()=='ar') echo ''?>" style="<?php if(\App::getLocale()=='ar') echo 'margin-right:11%;' ?>" href="{{route('profile', $object->user->id)}}" id="profilebutton">{{trans('main.view')}}</a>
        <h4 id="wage" style="<?php if(\App::getLocale()=='ar') echo 'float:left;'?>">{{$object->user->worker->wage}}{{trans('main.money')}}</h4>
    </div>
    @endif
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
