<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Oil Mill</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">

    <!-- Jquery Ui -->
    <link href="{{ asset('css/jquery-ui.css') }}" rel="stylesheet" />

    <!-- Dropzone css -->
    <link href={{ asset('css/dropzone.css')}} rel="stylesheet" />

    <!--  Light Bootstrap Table core CSS    -->
    <link href={{ asset('css/navbar-fixed-side.css')}} rel="stylesheet"/>

    <!--     Fonts and icons     -->

    <link href='{{ asset('fonts/fonts.css') }}' rel='stylesheet' type='text/css'>
    <link href={{ asset('css/pe-icon-7-stroke.css')}} rel="stylesheet" />
    <link href={{ asset('css/tagit.ui-zendesk.css')}} rel="stylesheet" />
    <link href={{ asset('css/jquery.tagit.css')}} rel="stylesheet" />
    <link href="{{ asset('css/bootstrap-switch.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/ezpos.css') }}">
    <!-- Select2 -->
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('DataTables/datatables.min.css') }}"/>

    <link rel="stylesheet" href="{{ asset('css/AdminLTE.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skins/skin-blue.min.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">





</head>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <header class="main-header">
        <!-- Logo -->
        <a class="logo" href="{{ url('/') }}">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><img style="border-radius: 50px;padding:5px;" src="{{ asset('images/logo.png') }}" height="50px" width="50px"></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><img style="border-radius: 50px;padding:5px;" src="{{ asset('images/logo.png') }}" height="50px" width="50px"> <b>Oil Mill</b> Management</span>
        </a>

        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                <span class="sr-only">Toggle navigation</span>
            </a>

            <a href="" class="navbar-brand">Oil Mill</a>

            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="{{ asset('images/profile.png') }}" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>


                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header">
                                <img src="{{ asset('images/profile.png') }}" class="img-circle" alt="User Image">
                                <p>
                                    {{ Auth::user()->name }}
                                    <small>Member since {{ gmdate("F d, Y",strtotime(\Illuminate\Support\Facades\Auth::user()->created_at)) }}</small>
                                </p>

                                <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    {{--<a href="{{ route('edit_user',["user"=>\Illuminate\Support\Facades\Auth::User()->id]) }}" class="btn btn-default btn-flat">Profile</a>--}}
                                    <a href="#" class="btn btn-default btn-flat">Profile</a>
                                </div>

                                <div class="pull-right">
                                    <a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                                    <form id="logout-form" action="{{route('logout')}}" method="POST" style="display: none;">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> </form>
                                    {{--<a href="{{ route('change_settings') }}"><span class="hidden-xs"><i class="fa fa-cog fa-spin fa-fw margin-bottom"></i></span></a>--}}
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="{{ asset('images/profile.png') }}" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>{{ Auth::user()->name }}</p>
                    <p class="text-muted">Oil Mill</p>
                </div>
            </div>

            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu" data-widget="tree">
                <li><a href="{{ route('users.index') }}"><i class="fa fa-users" aria-hidden="true"></i><span>User</span></a></li>
                <li><a href="#"><i class="fa fa-list" aria-hidden="true"></i><span>Item Category</span></a></li>
                <li><a href="#"><i class="fa fa-product-hunt" aria-hidden="true"></i><span>Item</span></a></li>
                <li><a href="#"><i class="fa fa-address-book" aria-hidden="true"></i><span>Stock</span></a></li>
                <li><a href="#"><i class="fa fa-car" aria-hidden="true"></i><span>Vehicle</span></a></li>
                <li><a href="#"><i class="fa fa-money" aria-hidden="true"></i><span>Sale</span></a></li>
            </ul>
        </section>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                @yield('pageTitle')
            </h1>

            @yield('breadcrumbs')
        </section>

        <!-- Main content -->
        <section class="content">
            @yield('content')
        </section>
    </div>

    <footer class="main-footer">
        <div class="pull-right hidden-xs">
            <b>Version</b> 1.0.0
        </div>

        <strong>&copy; 2018-{{date('Y')}} <a href="http://banglasofttech.com">BanglaSoftTech</a></strong> All rights reserved.
    </footer>
</div> <!-- ./wrapper -->

<!-- Scripts -->
<!-- JS Scripts -->

<!--   Core JS Files   -->
<script src="{{ asset('js/jquery.min.js')  }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset('js/jquery-ui.min.js') }}" type="text/javascript" charset="utf-8"></script>
<script src="{{ asset("js/tag-it.js")}}" type="text/javascript" charset="utf-8"></script>
<script src={{ asset('js/bootstrap.min.js')}} type="text/javascript"></script>

<script src="{{asset('js/vue.min.js')}}"></script>
<script src="{{asset('js/axios.min.js')}}"></script>
<script src="{{asset('js/vue-toasted.min.js')}}"></script>
<script src="{{asset('js/vue-spinner.min.js')}}"></script>

<!-- Admin LTE -->
<script src="{{ asset('js/adminlte.js') }}"></script>

<!-- Chart JS -->
<script src = "{{asset('js/Chart.min.js')}}" type="text/javascript" charset="UTF-8"></script>


<!-- Data table -->
{{--<script type="text/javascript" src="{{ asset('DataTables/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset("DataTables/mark.min.js") }}"></script>
<script type="text/javascript" src="{{ asset("js/datatables.mark.js") }}"></script>
<!-- Select 2 -->
<script src="{{ asset('js/select2.min.js') }}"></script>--}}

<!-- Bootstrap DatePicker JS -->
{{--<script src={{ asset('js/bootstrap-datepicker.js')}} type="text/javascript"></script>



<!-- Token Input js -->
<script src={{ asset('js/jquery.tokeninput.js')}}></script>--}}

<!--  Checkbox, Radio & Switch Plugins -->
<script src={{ asset('js/bootstrap-checkbox-radio-switch.js')}}></script>

<!--  Dropzone ZS -->
<script src={{ asset('js/dropzone.js')}}></script>

<!--  Charts Plugin -->

<!--  Notifications Plugin    -->
<script src={{ asset('js/bootstrap-notify.js')}}></script>

<!-- Random Color -->
<script src={{ asset('js/randomColor.js')}}></script>


<script type="text/javascript">
    $(document).ready(function(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
</script>
@yield('additionalJS')

</body>
</html>
