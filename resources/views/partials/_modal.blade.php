<div class="modal fade bs-modal-sm" id="myModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <br>
        <div class="bs-example bs-example-tabs">
            <ul id="myTab" class="nav nav-tabs">
              <li class="active"><a href="#signin" data-toggle="tab">Sign In</a></li>
              <li class=""><a href="#signup" data-toggle="tab">Register</a></li>
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
              <label class="control-label" for="email">E-mail:</label>
              <div class="control-group" id="email-div">
                <input required="" id="email" name="email" type="text" class="form-control" placeholder="E-mail" class="input-medium" value="{{ old('email') }}" required autofocus>
                {{-- <div id="form-errors-email" class="has-error"></div> --}}
                            <span class="help-block">
                                <strong id="form-errors-email"></strong>
                            </span>
                            <span class="help-block small">Your email</span>
              </div>
            </div>

            <!-- Password input-->
            <div class="control-group" id="password-div">
              <label class="control-label" for="password">Password:</label>
              <div class="controls">
                <input required="" id="password" name="password" class="form-control" type="password" placeholder="********" class="input-medium" required>
              </div>
               <span class="help-block">
                                <strong id="form-errors-password"></strong>
                            </span>
                            <span class="help-block small">Your strong password</span>
            </div>
            <div class="control-group" id="login-errors">
                            <span class="help-block">
                                <strong id="form-login-errors"></strong>
                            </span>
                        </div>
            <!-- Multiple Checkboxes (inline) -->
            <div class="control-group">
              <div class="checkbox">
                    <label style="margin-top: 5px;">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                    </label>
                </div>
            </div>
            <br>
            <!-- Button -->
            <div class="control-group">
              <button type="submit" class="btn btn-primary btn-sm">
                                    Login
                                </button>

                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    Forgot Your Password?
                                </a>
            </div>
            </fieldset>
            </form>
        </div>
        <!--Sign up form -->
        <div class="tab-pane fade" id="signup">    
        <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}" id="registerForm">
            {{ csrf_field() }}

            <div class="control-group" id="register-name">
                <label for="name" class=" control-label">Name</label>

                <div class="">
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus><span class=
                            "help-block"><strong id="register-errors-name"></strong></span> <span class="help-block small">Your name</span>
                </div>
            </div>

            <div class="control-group" id="register-email">
                <label for="email" class=" control-label">E-Mail Address</label>

                <div class="">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required><span class="help-block"><strong id="register-errors-email"></strong></span> <span class=
                            "help-block small">Your email</span>
                </div>
            </div>


            <div class="control-group" >
                <label for="role_id" class=" control-label">Role</label>

                <div class="">
                    <select name="role_id" class="form-control" id="my_role">
                        @foreach(\App\Role::all() as $role)
                        <option value='{{$role->id}}'>{{$role->name}}</option>

                        @endforeach
                    </select>

                 
                </div>
            </div>
            <div id="me_role">
                <div class="control-group">
                    <label for="job_id" class=" control-label">Job</label>

                    <div class="">
                        <select name="job_id" class="form-control">
                            @foreach(\App\Job::all() as $job)
                                <option value='{{$job->id}}'>{{$job->name}}</option>

                            @endforeach
                        </select>

                       
                    </div>
                </div>
                <div class="control-group">
                    <label for="phone" class=" control-label">PhoneNumber</label>

                    <div class="">
                        <input type="phone" name="phone" class="form-control">
                    </div>
                </div>

                <div class="control-group">
                    <label for="address_id" class=" control-label">Address</label>

                    <div class="">
                        <select name="address_id" class="form-control">
                            @foreach(\App\Address::all() as $address)
                                <option value='{{$address->id}}'>{{$address->name}}</option>

                            @endforeach
                        </select>

                    
                    </div>
                </div>
            </div>

            <div class="control-group" id="register-password">
                <label for="password" class=" control-label">Password</label>

                <div class="">
                    <input id="password" type="password" class="form-control" name="password" required>
                    <span class="help-block"><strong id="register-errors-password"></strong></span> <span class=
                            "help-block small">Your strong password</span>
                </div>
            </div>

            <div class="control-group">
                <label for="password-confirm" class=" control-label">Confirm Password</label>

                <div class="">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                     <span class=
                            "help-block"><strong id="form-errors-password-confirm"></strong></span>
                </div>
            </div>
             <div class="control-group" id="login-errors">
                            <span class="help-block"><strong id="form-login-errors"></strong></span>
                        </div>
            <br>
            <div class="control-group">
                <div class=" col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Register
                    </button>
                </div>
            </div>
        </form>
                    
            </div>
    </div>
      </div>
      <div class="modal-footer">
      <center>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
            $("#register-name").removeClass("has-error");
            $("#register-email").removeClass("has-error");
            $("#register-password").removeClass("has-error");

            $.ajax({
                url:'/register',
                type:'POST',
                data:formData,
                success:function(data){
                    $('#registerModal').modal( 'hide' );
                    location.reload(true);
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
                }
            });
        });
    });
</script>