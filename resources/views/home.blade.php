@extends('layouts.app')

@section('content')
<div class="jumbotron text-center searchsection" style="margin-top: 80px;">
<h1>Company Name</h1>
<br> 
<form action="/search" method="POST">
		{{csrf_field()}}
		<select name="nam" class="btn-lg">
			@foreach($jobs as $nam)
				<option value="{{$nam->id}}">{{$nam->name}}</option>
			@endforeach
		</select>
		<select name="adr" class="btn-lg">
			@foreach($addresses as $adr)
				<option value="{{$adr->id}}">{{$adr->name}}</option>
			@endforeach
		</select>
		<button type="submit" class="btn btn-lg btn-primary">Search</button>
	
</form>
</div>
<!-- Container (Services Section) -->
<div id="services" class="container-fluid text-center services">
  <h2>SERVICES</h2>
  <br>
  <div class="row">
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/carpenter.png" alt="hammer">
      <h4>Carpentry</h4>
      <p>Compnay name helps install and build a variety of customized carpentry projects</p>
    </div>
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/plumber.png" alt="spanner">
      <h4>Plumbing</h4>
      <p>Trusted and reliable, Compnay name offers plumbing services for your kitchen, bathroom and more</p>
    </div>
    <div class="col-md-4">
      <img class="tools" src="website/img/tools/electrician.png" alt="screwdriver">
      <h4>Electrical</h4>
      <p>Compnay name Connection provides electricians to handle all of your electrical repair and installation needs</p>
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
	<img class="col-md-6 img-responsive" alt="" src="https://d3nevzfk7ii3be.cloudfront.net/igi/MqGZWCWTTRYMR5a5.large">
	</div>
	</div>
</div>

@endsection
