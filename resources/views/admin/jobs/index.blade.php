@extends('admin.layouts.app')
@section('title','Jobs')
@section('content')
	<div class="well">
	<table class="table table-striped">
		<thead>
			<tr>
			<th>Jobs</th>
			<th>Name_ar</th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>

			@foreach($jobs as $job)
				<div class="row">
				<div class="col-md-6">
				<td>{{$job->name}}</td>
				<td>{{$job->name_ar}}</td>
				<td>
					
					<a href="{{route('jobs.edit',$job->id)}}" class="btn btn-warning pull-right">Edit</a>
					</td>
					</div>
					<td>
					<div class="col-md-6 ">
			 			{!! Form::open([
				            'method' => 'DELETE',
				            'route' => ['jobs.destroy', $job->id]
				        ]) !!}
			            {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
			        {!! Form::close() !!}				
			        </td>
			        </div>
			        </div> 
			</tr>
		
		@endforeach
		</tbody>	
	</table>
	<a href="{{route('jobs.create')}}" class="btn btn-success pull-right">Add New Job</a>
	<br>
	</div>
@endsection