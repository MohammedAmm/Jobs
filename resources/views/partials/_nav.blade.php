
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="{{url('/')}}"><img class="img-responsive logo" src="/logo.png"alt="Logo"></a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#home">{{trans('main.home')}}</a></li>
        <li><a href="#services">{{trans('main.services')}}</a></li>
        <li><a href="#about">{{trans('main.about')}}</a></li>
        <li><a href="#app">{{trans('main.app')}}</a></li>
       
        @if (Auth::guest())
             <li><button class="btn" href="#signup" data-toggle="modal" data-target=".bs-modal-sm">{{trans('auth.signin')}} / {{trans('auth.register')}}</button></li>
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
                      <a href="{{url('/myprofile')}}">{{trans('main.profile')}}</a>
                    @else
                      <a href="{{url('/changepassword')}}">{{trans('main.changepassword')}}</a>
                    @endif
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                            {{trans('main.logout')}}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    
                    </li>
                </ul>
            </li>
        @endif
         <li><a href="{{url('locale')}}" >{{trans('main.version')}}</a></li>
      </ul>
    </div>
  </div>
</nav>
