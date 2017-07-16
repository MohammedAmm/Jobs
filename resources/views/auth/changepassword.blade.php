@extends('layouts.app')
@section('styles')
	{!!Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}			
    	{!!Html::style('website/css/search.css')!!}
@endsection
@section('scripts')
  {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
@endsection
@section('content')
<div class="container" style="margin-top: 250px; margin-bottom:px;">
    <div class="row" style="<?php if(\App::getLocale()=='ar') echo 'direction:rtl'?>">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{trans('main.changepassword')}}</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/change') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('passwordold') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label <?php if(\App::getLocale()=='ar') echo 'pull-right'?>">{{trans('main.oldpassword')}}</label>

                            <div class="col-md-6 <?php if(\App::getLocale()=='ar') echo 'pull-left'?>">
                                <input id="password" type="password" class="form-control" name="passwordold" required>

                                @if ($errors->has('passwordold'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label <?php if(\App::getLocale()=='ar') echo 'pull-right'?>">{{trans('main.newpassword')}}</label>

                            <div class="col-md-6 ">
                                <input id="password" type="password" class="form-control <?php if(\App::getLocale()=='ar') echo 'pull-left'?>" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password-confirm" class="col-md-4 control-label <?php if(\App::getLocale()=='ar') echo 'pull-right'?>">{{trans('auth.confirmpassword')}}</label>

                            <div class="col-md-6 <?php if(\App::getLocale()=='ar') echo 'pull-left'?>">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                   {{trans('main.changepassword')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Success Message -->
        <div class="col-md-2 col-md-offset-8 <?php if(\App::getLocale()=='ar') echo 'pull-right'?>">
             @if(Session::has('password_message'))
                <div class="alert alert-success">
                    {{ Session::get('password_message') }}
                </div>
            @endif
            <!-- Error Message -->
            @if (Session::has('password_message_error'))
                 <div class="alert alert-danger">{{ Session::get('password_message_error') }}</div>
            @endif 
            </div>
        </div>     
</div>
</div>  
@endsection
