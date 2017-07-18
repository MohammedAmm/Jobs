@extends('layouts.app')
@section('styles')
		{!!Html::style('website/css/main.css')!!}  
@endsection
@section('scripts')
  {!! Html::script('website/js/jquery.min.js')!!}
  {!! Html::script('website/js/bootstrap.min.js')!!}
	  {!! Html::script('website/js/smoothscrolling.js')!!}
@endsection
@section('content')
<div class="jumbotron text-center searchsection">
<h1>{{trans('main.wmessage')}}</h2>
<br> 
<form class="form-inline center-mob" action="/search" method="GET">
    <div class="input-group form-group-lg" style="<?php if(\App::getLocale()=='ar') echo 'direction:rtl;'?>">
      
			@if(\App::getLocale()=='ar')
			<select class="form-control" id="sel3" name="nam" required>
				<option value="" selected disabled>{{trans('main.type')}}</option>
			
					
					@foreach($jobs as $nam)
							<option value="{{$nam->id}}">	@if(\Config::get('app.locale')=='ar')
							{{$nam->name_ar}}
						@else
						{{$nam->name}}
					@endif</option>
					@endforeach

			
      </select>
      <select class="form-control" id="sel2" name="adr" required>
        <option value="" selected disabled>{{trans('auth.address')}}</option>
      </select>
					<select class="form-control" id="sel1" required>
        <option value="" selected disabled>{{trans('main.governate')}}</option>
 				@foreach($cities as $cit)
					<option value="{{$cit->id}}">@if(\Config::get('app.locale')=='ar')
							{{$cit->city_ar}}
						@else
						{{$cit->city}}
					@endif</option>
				@endforeach

      </select>
  
			@else
			<select class="form-control" id="sel1" required>
        <option value="" selected disabled>{{trans('main.governate')}}</option>
 				@foreach($cities as $cit)
					<option value="{{$cit->id}}">@if(\Config::get('app.locale')=='ar')
							{{$cit->city_ar}}
						@else
						{{$cit->city}}
					@endif</option>
				@endforeach

      </select>
			<select class="form-control" id="sel2" name="adr" required>
        <option value="" selected disabled>{{trans('auth.address')}}</option>
            </select>
      <select class="form-control" id="sel3" name="nam" required>
				<option value="" selected disabled>{{trans('main.type')}}</option>
			
					
					@foreach($jobs as $nam)
							<option value="{{$nam->id}}">	@if(\Config::get('app.locale')=='ar')
							{{$nam->name_ar}}
						@else
						{{$nam->name}}
					@endif</option>
					@endforeach
					</select>
					@endif
      <div class="input-group-btn">
        <button type="submit" class="btn btn-lg" id="srch" style="<?php if(\App::getLocale()=='ar') echo ' border-top-right-radius: 0;
    border-bottom-right-radius: 0;border-top-left-radius: 6px;
    border-bottom-left-radius: 6px;'?>">{{trans('main.search')}}</button>
      </div>
    </div>
 </form>
 
	</div>

</div>
<!-- Container (Services Section) -->
<div id="services" class="container-fluid text-center services">
  <h2>{{strtoupper(trans('main.services'))}}</h2>
  <br>
  <div class="row">
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/carpenter.png" alt="hammer">
      <h4>{{trans('main.carpentry')}}</h4>
      <p>{{trans('main.m1')}}</p>
    </div>
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/plumber.png" alt="spanner">
      <h4>{{trans('main.plumbing')}}</h4>
      <p>{{trans('main.m2')}}</p>
    </div>
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/electrician.png" alt="screwdriver">
      <h4>{{trans('main.electrical')}}</h4>
      <p>{{trans('main.m3')}}</p>
    </div>
    </div>
  </div>
</div>

<!-- Container (About Section)
<div class="jumbotron container-fluid text-center">
	<h2>WHO WE ARE</h2>

	<p class="aboutp">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc sit amet lobortis lorem. Duis vel sem risus. Nam mollis dictum enim. Pellentesque non nunc id magna luctus consequat. Nam non efficitur mauris. Aenean mollis magna nunc, ac porttitor nibh accumsan id. Quisque accumsan ultricies risus, nec placerat nisi dictum vitae.</p>
</div>
-->

<!--Container (Testimonials) -->
<div id="about" class="container-fluid text-center testimonials">
	<h2>What our customers say</h2>
	<div id="myCarousel" class="carousel slide text-center" data-ride="carousel">
	  <!-- Indicators -->
	  <ol class="carousel-indicators">
	    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
	    <li data-target="#myCarousel" data-slide-to="1"></li>
	    <li data-target="#myCarousel" data-slide-to="2"></li>
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner slideanim" role="listbox">
	    <div class="item active">
	    <h4>"This company is the best. I am so happy with the result!"<br><span>Michael Roe, Vice President, Comment Box</span></h4>
	    </div>
	    <div class="item">
	      <h4>"One word... WOW!!"<br><span>John Doe, Salesman, Rep Inc</span></h4>
	    </div>
	    <div class="item">
	      <h4>"Could I... BE any more happy with this company?"<br><span>Chandler Bing, Actor, FriendsAlot</span></h4>
	    </div>
	  </div>

	  <!-- Left and right controls -->
	  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
	    <span class="sr-only">Next</span>
	  </a>
	</div>
</div>
<br><br><br>

<!-- Container (Download our App Section) -->
<div id="app" class="app container-fluid text-left">
	<div class="row">
	<div class="col-md-6 slideanim">
	<h2>Download our app</h2>
	<p>
	Aenean pretium egestas eros, vitae semper nulla volutpat vitae. Etiam tincidunt sapien id arcu varius vehicula.
	</p>
	<div>
	<a href="#" class="apple">Apple App Store</a>
	<a href="#" class="google">Google Play App Store</a>
	</div>
	</div>
	<div>
	<img class="col-md-6 img-responsive" alt="" src="/mob.large">
	</div>
	</div>
</div>
               
<script>
       $('#sel1').on('change',function(){
				 $.ajax({
					 url:'/addresses',
					 type:'get',
					 dataType:"json",
					 data:{
						 'id':$('#sel1').val()
					 },
					 success:function (data) {
						 $('#sel2').children().remove();
						 var addresses=data[0];
						 for (var i = 0; i < addresses.length; i++) {
							 var address = addresses[i];
							  $('<option/>',{
							 value:address.id,
							 text:{{(\Config::get('app.locale')=='en')?'address.name':'address.name_ar'}},
							 id:'removeMe',
						 }).appendTo('#sel2');				 
						 }
						//  $('#sel2').removeClass('hidden');

					 }
				 });
        });
    </script>
@endsection
