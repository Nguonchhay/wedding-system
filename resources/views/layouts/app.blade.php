<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Wedding Management System</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{!! asset('theme/bootstrap/css/bootstrap.min.css') !!}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{!! asset('theme/plugins/daterangepicker/daterangepicker.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/datepicker/datepicker3.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/iCheck/all.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/colorpicker/bootstrap-colorpicker.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/timepicker/bootstrap-timepicker.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/select2/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/plugins/datatables/dataTables.bootstrap.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/dist/css/AdminLTE.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('theme/dist/css/skins/_all-skins.min.css') !!}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

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

    <script src="{!! asset('theme/plugins/jQuery/jquery-2.2.3.min.js') !!}"></script>
    <script src="{!! asset('theme/bootstrap/js/bootstrap.min.js') !!}"></script>

    <script src="{!! asset('theme/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datatables/dataTables.bootstrap.min.js') !!}"></script>

    <script src="{!! asset('theme/plugins/select2/select2.full.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/input-mask/jquery.inputmask.js') !!}"></script>
    <script src="{!! asset('theme/plugins/input-mask/jquery.inputmask.date.extensions.js') !!}"></script>
    <script src="{!! asset('theme/plugins/input-mask/jquery.inputmask.extensions.js') !!}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{!! asset('theme/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('theme/plugins/datepicker/bootstrap-datepicker.js') !!}"></script>
    <script src="{!! asset('theme/plugins/colorpicker/bootstrap-colorpicker.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/timepicker/bootstrap-timepicker.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/slimScroll/jquery.slimscroll.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/iCheck/icheck.min.js') !!}"></script>
    <script src="{!! asset('theme/plugins/fastclick/fastclick.js') !!}"></script>
    <script src="{!! asset('theme/dist/js/app.min.js') !!}"></script>
    <script src="{!! asset('theme/dist/js/demo.js') !!}"></script>

    <!-- CKEditor -->
    <script>
        var route_prefix = "{{ url(config('lfm.prefix')) }}";
    </script>

    <script src="{!! asset('/vendor/unisharp/laravel-ckeditor/ckeditor.js') !!}"></script>
    <script src="{!! asset('/vendor/unisharp/laravel-ckeditor/adapters/jquery.js') !!}"></script>
    <script>
        $('.textarea-aloha').ckeditor({
            height: 100,
            filebrowserImageBrowseUrl: route_prefix + '?type=Images',
            filebrowserImageUploadUrl: route_prefix + '/upload?type=Images&_token={{csrf_token()}}',
            filebrowserBrowseUrl: route_prefix + '?type=Files',
            filebrowserUploadUrl: route_prefix + '/upload?type=Files&_token={{csrf_token()}}'
        });
    </script>

    <script>
        {!! \File::get(base_path('vendor/unisharp/laravel-filemanager/public/js/lfm.js')) !!}
    </script>
    <script>
        $('#lfm').filemanager('image', {prefix: route_prefix});
    </script>

    <!-- Custom Script -->
    <script src="{!! asset('/js/reasei.min.js') !!}"></script>
</body>
</html>