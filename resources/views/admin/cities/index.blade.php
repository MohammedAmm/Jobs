@extends('admin.layouts.app')
@section('title','cities')
@section('content')
	<div class="well">
	<table class="table table-striped">
		<thead>
			<tr>
			<th>Cities</th>
			<th></th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>

			@foreach($cities as $cit)
				<div class="row">
				<div class="col-md-6">
				<td>{{$cit->city}}</td>
				<td>
					
					<a href="{{route('cities.edit',$cit->id)}}" class="btn btn-warning pull-right">Edit</a>
					</td>
					</div>
					<td>
					<div class="col-md-6 ">
			 			{!! Form::open([
				            'method' => 'DELETE',
				            'route' => ['cities.destroy', $cit->id]
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
	<a href="{{route('cities.create')}}" class="btn btn-success pull-right">Add New Cities</a>
	<br>
	</div>
@endsection