
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#home">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#home">HOME</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#app">APP</a></li>
        @if (Auth::guest())
             <li><button class="btn" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">Sign In / Register</button></li>
        @else
            @if(Auth::user()->role_id==1)
            <img src="{{Storage::url(Auth::user()->worker->avatar)}}" style="width:30px; height:30px; float:left; border-radius:50%; margin-top:13px;">
            @endif
            <li class="dropdown">

                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                    {{ Auth::user()->name }}  <span class="caret"></span>
                </a>
                    
                <ul class="dropdown-menu" role="menu">
                    <li>
                    @if(Auth::user()->role_id==1)
                      <a href="{{url('/myprofile')}}">Profile</a>
                    @else
                      <a href="{{url('/changepassword')}}">Change password</a>
                    @endif
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    
                    </li>
                </ul>
            </li>
        @endif

      </ul>
    </div>
  </div>
</nav>
