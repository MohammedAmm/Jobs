<!DOCTYPE html>
<html lang="<?php if(\App::getLocale()=='en') echo 'en'?><?php if(\App::getLocale()=='ar') echo 'ar'?>"  >
<head>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
    {!!Html::style('website/css/bootstrap.min.css')!!}
 
  @yield('styles')
  

    @yield('scripts')

  {!! Html::script('website/js/smoothscrolling.js')!!}

  
</head>
<body id="home" data-spy="scroll" data-target=".navbar" data-offset="150" >
<div class="wrapper">
<!--Container (navbar) -->
  @include('partials._nav')
<!-- Modal -->
  <div <div style="<?php if(\Config::get('app.locale')=='ar')echo 'direction:rtl;'?>"> >
  @include('partials._modal')
   </div>             
    @if (Session::has('message'))
     <div class="alert alert-danger" style="margin-top:50px; magin-bottom:-50px;  <?php if(\App::getLocale()=='ar') echo 'text-align:right;'?>">{{ Session::get('message') }}</div>
    @endif 
    <!-- Message -->
  @if(Session::has('flash_message'))
      <div class="alert alert-success " style="margin-top:50px; magin-bottom:-50px;  <?php if(\App::getLocale()=='ar') echo 'text-align:right;'?>">
          {{ Session::get('flash_message') }}
      </div>
  @endif 
    @yield('content')

    <!-- <footer -->
    <footer class="container-fluid text-center">
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
    </div>
    </body>

</html>
