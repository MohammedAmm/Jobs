@extends('admin.layouts.app')
@section('title','addresss')
@section('content')
	<div class="well">
	<table class="table table-striped">
		<thead>
			<tr>
			<th>addresses</th>
			<th></th>
			<th></th>
			</tr>
		</thead>
		<tbody>
			<tr>

			@foreach($addresses as $address)
				<div class="row">
				<div class="col-md-6">
				<td>{{$address->name}}</td>
				<td>
					
					<a href="{{route('addresses.edit',$address->id)}}" class="btn btn-warning pull-right">Edit</a>
					</td>
					</div>
					<td>
					<div class="col-md-6 ">
			 			{!! Form::open([
				            'method' => 'DELETE',
				            'route' => ['addresses.destroy', $address->id]
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
	<a href="{{route('addresses.create')}}" class="btn btn-success pull-right">Add New address</a>
	<br>
	</div>
@endsection