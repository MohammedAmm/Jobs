<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!!Html::style('https://fonts.googleapis.com/css?family=Montserrat')!!}
  {!!Html::style('https://fonts.googleapis.com/css?family=Lato')!!}
  @yield('styles')
  

    @yield('scripts')

  {!! Html::script('website/js/smoothscrolling.js')!!}

  
</head>
<body id="home" data-spy="scroll" data-target=".navbar" data-offset="150">
  
<!--Container (navbar) -->
  @include('partials._nav')

<!-- Modal -->
  @include('partials._modal')
                
    @if (Session::has('message'))
     <div class="alert alert-danger" style="margin-top:150px;">{{ Session::get('message') }}</div>
    @endif 
    <!-- Message -->
  @if(Session::has('flash_message'))
      <div class="alert alert-success" style="margin-top:150px;">
          {{ Session::get('flash_message') }}
      </div>
  @endif 
    @yield('content')

    <!-- <footer -->
    <footer class="container-fluid text-center" style=" bottom:0; width:100%">
	  <a href="#home" title="To Top">
	    <span class="glyphicon glyphicon-chevron-up"></span>
	  </a>
	  <p>© 2017 All Rights Reserved Terms of Use and Privacy Policy</p> 
	</footer>
    <!-- Scripts -->
    <script>
    @if (!empty(Session::get('error_code')) && Session::get('error_code') == 5) {
      $(function() {
        $('.bs-modal-sm').modal('show');
    });
      @endif
     
    </script>
    <script>
       $('#my_role').on('change',function(){
            if( $(this).val()==="1"){
                $("#me_role").show();
            }
            else{
                $("#me_role").hide();
            }
        });
    </script>
    </body>
</html>
