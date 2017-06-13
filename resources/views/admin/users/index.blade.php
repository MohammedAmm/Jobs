@extends('admin.layouts.app')
@section('title','Users')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
          Control Users
          <small>advanced tables</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/adminpanel')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="{{url('/adminpanel/users')}}">Tables</a></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Users</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>UserName</th>
                  <th>E-Mail</th>
                  <th>Admin</th>
                  <th></th>
                  <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                  <td>{{$user->name}}</td>
                  <td>{{$user->email}}
                  </td>
                  @if($user->admin)
                  <td>Yes</td>
                  <td></td>
                  <td></td>
                  @else
                  <td>No</td>
                  <td>
                      {{Form::open(['method'=>'PATCH','route'=>['users.update',$user->id]])}}
                          {{Form::submit('To Admin',['class'=>'btn btn-success btn-sm'])}}
                      {{Form::close()}}
                  </td>
                  <td>
                  {{ Form::open(array('url' => 'adminpanel/users/' . $user->id)) }}
                          {{ Form::hidden('_method', 'DELETE') }}
                          {{ Form::submit('Delete', array('class' => 'btn btn-danger btn-sm')) }}
                       {{ Form::close() }}
                  </td>

                  @endif
                  
                </tr>
               @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->



@endsection
