@extends('layouts.app')
@section('styles')
    	{!!Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
		{!!Html::style('website/css/main.css')!!} 
@endsection
@section('scripts')
  {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
@endsection
@section('content')
<div class="container" style="margin-top : 150px; margin-bottom: 320px;">
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

    <div class="row" style="<?php if(\App::getLocale()=='ar') echo 'direction:rtl;' ?>">
        <div class="col-md-10 col-md-offset-1">
            <img src="{{Storage::url(Auth::user()->worker->avatar)}}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px; <?php if(\App::getLocale()=='ar') echo 'float:right; margin-right:-25px; margin-left:25px; margin-bottom:25px;' ?>">
            <h2>{{ $user->name }}{{trans('main.myprofile')}}</h2>
            <a href="{{url('changepassword')}}">{{trans('main.changepassword')}}</a>
        </div>
            <div class="col-md-8 col-md-offset-3">
                {!! Form::model($worker, [
                    'method' => 'POST',
                    'action'=>['ProfileController@update_info',$worker->user_id],
                    'enctype' =>'multipart/form-data'
                ]) !!}
                 <div class="form-group">
                    {!! Form::label('avatar',trans('main.profilepic'), ['class' => 'control-label']) !!}
                    {!! Form::file('avatar', ['class' => 'form-control']) !!}                 
                </div>
                 <div class="form-group">
                {!! Form::label('job_id', trans('auth.job'), ['class' => 'control-label']) !!}
                {!! Form::select('job_id',$jobs, $worker->job_id, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                {!! Form::label('address_id', trans('auth.address'), ['class' => 'control-label']) !!}
                {!! Form::select('address_id', $addresses, $worker->address_id, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                {!! Form::label('phone',trans('auth.phonenumber'), ['class' => 'control-label']) !!}
                {!! Form::text('phone',null, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                    {!! Form::label('wage', trans('auth.wage'), ['class' => 'control-label']) !!}
                    {!! Form::text('wage', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit(trans('auth.update'), ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection