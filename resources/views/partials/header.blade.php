<header class="main-header">
    <a href="/" class="logo">
        <b>WS</b> : Wedding System
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-user"></i>
                        <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                                {!! Auth::user()->name !!}
                                <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                            </p>
                        </li>

                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="{!! url('/users/' . Auth::user()->id) !!}" class="btn btn-default btn-flat">
                                    <i class="fa fa-user"></i> Profile
                                </a>
                            </div>

                            <div class="pull-right">
                                <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i> Sign out
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>