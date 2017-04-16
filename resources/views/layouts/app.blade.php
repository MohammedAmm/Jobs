<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  {!!Html::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css')!!}
  {!!Html::style('website/css/main.css')!!}
  {!!Html::style('https://fonts.googleapis.com/css?family=Montserrat')!!}
  {!!Html::style('https://fonts.googleapis.com/css?family=Lato')!!}

  {!! Html::script('https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js')!!}
  {!! Html::script('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js')!!}
  {!! Html::script('website/js/smoothscrolling.js')!!}
</head>
<body id="home" data-spy="scroll" data-target=".navbar" data-offset="150">

<!--Container (navbar) -->
@include('partials._nav')
<!-- Modal -->
@include('partials._modal')
                
    @if (Session::has('message'))
     <div class="alert alert-info">{{ Session::get('message') }}</div>
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
    });@endif
    }  
    
        $('#my_role').on('change',function(){
            if( $(this).val()==="1"){
                $("#me_role").show()
            }
            else{
                $("#me_role").hide()
            }
        });
    </script>
    </body>
</html>
