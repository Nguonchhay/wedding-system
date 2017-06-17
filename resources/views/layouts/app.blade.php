<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Wedding Management System</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="{!! asset('theme/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/css/font-awesome.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/css/AdminLTE.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/css/_all-skins.min.css') !!}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{!! asset('theme/css/ionicons.min.css') !!}">

    <!-- Custom Style -->
    <link rel="stylesheet" href="{!! asset('/css/reasei.min.css') !!}">
</head>

<body class="skin-blue sidebar-mini">
@if (!Auth::guest())
    <div class="wrapper">
        <header class="main-header">
            <a href="#" class="logo">
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
                               <span class="hidden-xs">{!! Auth::user()->name !!}</span>
                                <i class="fa fa-angle-down"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="http://infyom.com/images/logo/blue_logo_150x150.jpg"
                                         class="img-circle" alt="User Image"/>
                                    <p>
                                        {!! Auth::user()->name !!}
                                        <small>Member since {!! Auth::user()->created_at->format('M. Y') !!}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sign out
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

        @include('layouts.sidebar')

        <div class="content-wrapper">
            @yield('content')
        </div>

        <footer class="main-footer" style="max-height: 100px;text-align: center">
            <strong>Copyright © {{ date('Y') }} <a href="http://www.reasei.com" target="_blank">REASEI</a>.</strong> All rights reserved.
        </footer>

    </div>
@else
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{!! url('/') !!}">
                    Wedding Management System
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="{!! url('/home') !!}">Home</a></li>
                </ul>

                <ul class="nav navbar-nav navbar-right">
                    <li><a href="{!! url('/login') !!}">Login</a></li>
                    <li><a href="{!! url('/register') !!}">Register</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- jQuery 2.1.4 -->
    <script src="{!! asset('/theme/js/jquery.min.js') !!}"></script>
    <script src="{!! asset('/theme/js/bootstrap.min.js') !!}"></script>
    <script src="{!! asset('/theme/js/select2.min.js') !!}"></script>
    <script src="{!! asset('/theme/js/icheck.min.js') !!}"></script>

    <!-- AdminLTE App -->
    <script src="{!! asset('/theme/js/app.min.js') !!}"></script>

    <!-- Custom Script -->
    <script src="{!! asset('/js/reasei.min.js') !!}"></script>
</body>
</html>