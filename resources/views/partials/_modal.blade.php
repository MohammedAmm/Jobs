<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" data-toggle="tab">{{trans('auth.signin')}}</a></li>
              <li class=""><a href="#signup" data-toggle="tab">{{trans('auth.register')}}</a></li>
            </ul>
        </div>
      <div class="modal-body">
        <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="signin">
            <form class="form-horizontal" role="form" method="POST" action="{{ route('login') }}" id="loginForm">
                        {{ csrf_field() }}
            <fieldset>

            <!-- Sign In Form -->
            <!-- Text input-->
            <div class="control-group">
              <label class="control-label" for="email">{{trans('auth.email')}}:</label>
              <div class="control-group" id="email-div">
                <input required="" id="email" name="email" type="text" class="form-control" placeholder="{{trans('auth.email')}}" class="input-medium" value="{{ old('email') }}" required autofocus>
                {{-- <div id="form-errors-email" class="has-error"></div> --}}
                            <span class="help-block">
                                <strong id="form-errors-email"></strong>
                            </span>
              </div>
            </div>

            <!-- Password input-->
            <div class="control-group" id="password-div">
              <label class="control-label" for="password">{{trans('auth.password')}}:</label>
              <div class="controls">
                <input required="" id="password" name="password" class="form-control" type="password" placeholder="********" class="input-medium" required>
              </div>
               <span class="help-block">
                                <strong id="form-errors-password"></strong>
                            </span>
            </div>
            <div class="control-group" id="login-errors">
                            <span class="help-block">
                                <strong id="form-login-errors"></strong>
                            </span>
                        </div>
            <!-- Multiple Checkboxes (inline) -->
            <div class="control-group">
              <div class="span6">
                    <label style="margin-top: 5px; ">
                        <input type="checkbox" name="remember" style="margin-top: 5px;"{{ old('remember') ? 'checked' : '' }}> {{trans('auth.remember')}}
                    </label>
                </div>
            </div>
            <br>
            <!-- Button -->
            <div class="control-group">
              <button type="submit" class="btn btn-primary btn-sm">
                                    {{trans('auth.signin')}}
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}" >
                                    {{trans('auth.forgot')}}
                                </a>
            </div>
            </fieldset>
            </form>
        </div>
        <!--Sign up form -->
        <div class="tab-pane fade" id="signup">   
    
             <div class="alert alert-info hidden" id="removeMessage">{{trans('main.message')}}</div> 
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" id="registerForm">
            {{ csrf_field() }}

            <div class="control-group" id="register-name">
                <div class="">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="{{trans('auth.name')}}" required autofocus><span class=
                            "help-block"><strong id="register-errors-name"></strong></span>
                </div>
            </div>

            <div class="control-group" id="register-email">
                <div class="">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="{{trans('auth.email')}}" required><span class="help-block"><strong id="register-errors-email"></strong></span>
                </div>
            </div>


            <div class="control-group" >
                <label for="role_id" class=" control-label">{{trans('auth.role')}}</label>

                <div class="">
                    <select name="role_id" class="form-control" id="my_role">
                        @foreach(\App\Role::all() as $role)
                        <option value='{{$role->id}}'>
                        @if(\Config::get('app.locale')=='ar')
                            {{$role->name_ar}}
                        @else
                            {{$role->name}}
                        @endif                
                        </option>
                        @endforeach
                    </select>

                 
                </div>
            </div>
            <div id="me_role">
                <div class="control-group">
                    <label for="job_id" class=" control-label">{{trans('auth.job')}}</label>

                    <div class="">
                        <select name="job_id" class="form-control">
                            @foreach(\App\Job::all() as $job)
                                <option value='{{$job->id}}'> @if(\Config::get('app.locale')=='ar')
                            {{$job->name_ar}}
                        @else
                            {{$job->name}}
                        @endif          </option>
                            @endforeach
                        </select>

                       
                    </div>
                </div>
                <div class="control-group" id="register-age">
                    <div class="" style="margin-top:10px;">
                        <input type="age" name="age" class="form-control" placeholder="{{trans('auth.age')}}">
                        <span class=
                            "help-block"><strong id="register-errors-age"></strong></span>
                    </div>
                </div>
                <div class="control-group" id="register-phone">
                    <div class="" >
                        <input type="phone" name="phone" class="form-control" placeholder="{{trans('auth.phonenumber')}}">
                        <span class=
                            "help-block"><strong id="register-errors-phone"></strong></span>
                    </div>
                </div>
                 <div class="control-group" id="register-wage">
                    <div class="">
                        <input type="wage" name="wage" class="form-control" placeholder="{{trans('auth.wage')}}">
                        <span class=
                            "help-block"><strong id="register-errors-wage"></strong></span>
                    </div>
                </div>

                <div class="control-group" >
                    <label for="address_id" class=" control-label">{{trans('auth.address')}}</label>

                    <div class="">
                        <select name="address_id" class="form-control">
                             {{$make=0}}
                            @foreach(\App\Address::orderBy('city_id','asc')->get() as $address)
                                
                               @if(!($make==$address->city_id))
                                {{$make=$address->city_id}}
                                {!! '<optgroup style="font-size:10px;" label='!!}
                                @if(\Config::get('app.locale')=='en')
                                  {{   $address->city->city}}
                                @else
                                    {{   $address->city->city_ar}}
                                @endif
                                {!!'></optgroup>'!!};    
                               
                               @endif
                                <option value='{{$address->id}}'>
                                @if(\Config::get('app.locale')=='en')
                                    {{$address->name}}
                                @else
                                    {{$address->name_ar}}
                                @endif                
                            </option>                               
                            @endforeach                          
                        </select>        
                    </div>
                </div>
            </div>

            <div class="control-group" id="register-password">
                <label for="password" class=" control-label">{{trans('auth.password')}}</label>

                <div class="">
                    <input id="password" type="password" class="form-control" name="password" placeholder="********" required>
                    <span class="help-block"><strong id="register-errors-password"></strong></span>
                </div>
            </div>

            <div class="control-group" style="margin-top:-10px;">
                <label for="password-confirm" class=" control-label">{{trans('auth.confirmpassword')}}</label>

                <div class="">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="********" required>
                     <span class=
                            "help-block"><strong id="form-errors-password-confirm"></strong></span>
                </div>
            </div>
             <div class="control-group" id="login-errors">
                            <span class="help-block"><strong id="form-login-errors"></strong></span>
                        </div>
            <br>
            <div class="control-group" style="margin-top:-15px;">
                <div class=" col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{trans('auth.register')}}
                    </button>
                </div>
            </div>
        </form>
                    
            </div>
    </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('auth.close')}}</button>
        </center>
      </div>
    </div>
  </div>
</div>

<script>
    $(document).ready(function(){
        var loginForm = $("#loginForm");
        loginForm.submit(function(e) {
            e.preventDefault();
            var formData = loginForm.serialize();
            $('#form-errors-email').html("");
            $('#form-errors-password').html("");
            $('#form-login-errors').html("");
            $("#email-div").removeClass("has-error");
            $("#password-div").removeClass("has-error");
            $("#login-errors").removeClass("has-error");
            $.ajax({
                url: '/login',
                type: 'POST',
                data: formData,
                success: function(data) {
                    $('#loginModal').modal('hide');
                    location.reload(true);
                },
                error: function(data) {
                    console.log(data.responseText);
                    var obj = jQuery.parseJSON(data.responseText);
                    if (obj.email) {
                        $("#email-div").addClass("has-error");
                        $('#form-errors-email').html(obj.email);
                    }
                    if (obj.password) {
                        $("#password-div").addClass("has-error");
                        $('#form-errors-password').html(obj.password);
                    }
                    if (obj.error) {
                        $("#login-errors").addClass("has-error");
                        $('#form-login-errors').html(obj.error);
                    }
                }
            });
        });
        var registerForm = $("#registerForm");
        registerForm.submit(function(e){
            e.preventDefault();
            var formData = registerForm.serialize();
            $( '#register-errors-name' ).html( "" );
            $( '#register-errors-email' ).html( "" );
            $( '#register-errors-password' ).html( "" );
            $( '#register-errors-phone' ).html( "" );
            $( '#register-errors-age' ).html( "" );            
            $( '#register-errors-wage' ).html( "" );
            $("#register-name").removeClass("has-error");
            $("#register-email").removeClass("has-error");
            $("#register-password").removeClass("has-error");
            $("#register-phone").removeClass("has-error");
            $("#register-age").removeClass("has-error");            
            $("#register-wage").removeClass("has-error");
            $.ajax({
                url:'/register',
                type:'POST',
                data:formData,
                success:function(data){
                    registerForm.addClass('hidden');
                    $('#removeMessage').removeClass('hidden');
                  //  location.reload(true);
                },
                error: function (data) {
                    console.log(data.responseText);
                    var obj = jQuery.parseJSON( data.responseText );
                   if(obj.name){
                        $("#register-name").addClass("has-error");
                        $( '#register-errors-name' ).html( obj.name );
                    }
                    if(obj.email){
                        $("#register-email").addClass("has-error");
                        $( '#register-errors-email' ).html( obj.email );
                    }
                    if(obj.password){
                        $("#register-password").addClass("has-error");
                        $( '#register-errors-password' ).html( obj.password );
                    }
                    if(obj.age){
                        $("#register-age").addClass("has-error");
                        $( '#register-errors-age' ).html( obj.age );
                    }
                    if(obj.phone){
                        $("#register-phone").addClass("has-error");
                        $( '#register-errors-phone' ).html( obj.phone );
                    }
                    if(obj.wage){
                        $("#register-wage").addClass("has-error");
                        $( '#register-errors-wage' ).html( obj.wage );
                    }
                }
            });
        });
    });
</script>
