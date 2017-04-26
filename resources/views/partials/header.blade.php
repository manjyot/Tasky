<nav class="navbar navbar-inverse navbar-static-top">
  <div class="container container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="{{ url('/') }}"><span class="glyphicon glyphicon-tasks"></span> Tasky</a>
    </div>
    @if(Auth::check())
    <ul class="nav navbar-nav">

        @if(Auth::user()->hasRole('User'))
            @if(Route::current()->getName() == 'tasks.index')
                <li class="active">
            @else
                <li>
            @endif
                    <a href="{{ url('tasks') }}">My Tasks</a>
                </li> 
        @else
            @if(Route::current()->getName() == 'tasks.index')
                <li class="active">
            @else
                <li>
            @endif
                    <a href="{{ url('tasks') }}">All Tasks</a>
                </li> 
        @endif
    </ul>  
    @endif  
    <ul class="nav navbar-nav navbar-right">
        @if(!Auth::check())
        <li><a href="{{ url('register') }}"><span class="glyphicon glyphicon-user"></span> Register</a></li>
        <li><a href="{{ url('login') }}"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
        @else
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#"><span class="glyphicon glyphicon-user"></span> {{ Auth::user()->name }}
            <span class="caret"></span></a>
            <ul class="dropdown-menu">
                @if(Auth::user()->hasRole('Admin'))
                    <li><a href="{{ url('admin') }}"><span class="glyphicon glyphicon-list"></span> Admin Panel</a></li>
                @endif
                <li><a href="{{ url('logout') }}"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
            </ul>
        </li>
        @endif
    </ul>
  </div>
</nav>