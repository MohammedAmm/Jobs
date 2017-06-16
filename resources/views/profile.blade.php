@extends('layouts.app')
@section('content')
<div class="container" style="margin-top : 150px; margin-bottom: 320px;">
    @if($errors->any())
    <div class="alert alert-danger">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <img src="{{Storage::url(Auth::user()->worker->avatar)}}" style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;">
            <h2>{{ $user->name }}'s Profile</h2>
            <a href="{{url('changepassword')}}">change password</a>
        </div>
            <div class="col-md-8 col-md-offset-3">
                {!! Form::model($worker, [
                    'method' => 'POST',
                    'action'=>['ProfileController@update_info',$worker->user_id],
                    'enctype' =>'multipart/form-data'
                ]) !!}
                 <div class="form-group">
                    {!! Form::label('avatar', 'Update Ur Photo', ['class' => 'control-label']) !!}
                    {!! Form::file('avatar', ['class' => 'form-control']) !!}                 
                </div>
                 <div class="form-group">
                {!! Form::label('job_id', 'Job:', ['class' => 'control-label']) !!}
                {!! Form::select('job_id', $jobs, $worker->job_id, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                {!! Form::label('address_id', 'Address:', ['class' => 'control-label']) !!}
                {!! Form::select('address_id', $addresses, $worker->address_id, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                {!! Form::label('phone', 'PhoneNumber:', ['class' => 'control-label']) !!}
                {!! Form::text('phone',null, ['class' => 'form-control']) !!}
                 
                </div>
                <div class="form-group">
                    {!! Form::label('wage', 'Wage: EGP/h', ['class' => 'control-label']) !!}
                    {!! Form::text('wage', null, ['class' => 'form-control']) !!}
                </div>

                {!! Form::submit('Update Task', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}



        </div>
    </div>
</div>
@endsection