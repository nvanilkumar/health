<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>{{ (@$title)?$title:"" }}</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.7 -->
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">  
        <link rel="stylesheet" href="{{ asset('/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/plugincss/select2.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/dataTables.bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/jquery.datetimepicker.css') }}">
        <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- Google Font -->
        <script type="text/javascript" src="{{ asset('/js/jquery-2.1.1.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('/js/pluginjs/Chart.js') }}"></script>
        <script src="{{ asset('/js/pluginjs/fastclick.js') }}"></script>
        <script src="{{ asset('/js/pluginjs/adminlte.js') }}"></script>
        <script src="{{ asset('/js/pluginjs/demo.js') }}"></script>
        <style>
            #chartdiv {
                width	: 100%;
                height	: 500px;
            }
 
       </style>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>N</b>CD</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"> <img src="{{ asset('/images/main_logo.png') }}" alt="health"  style=" height: 55px;"/></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                     <span class="logo-lg"> </span>
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>
                    
                    <div class="navbar-custom-menu">
                         <img src="{{ asset('/images/jarkhand_logo.jpg') }}" alt="health" style=" height: 51px;" />
                        <a href="{{action('UserController@logout')}}" class="btn" 
                           style=" padding: 15px 20px;" data-toggle="tooltip" title="SignOut"> 
                            <i class="fa fa-power-off" aria-hidden="true" style="color:#eeeeee; font-size:18px;"></i>
                        </a>

                       
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        <li><a href="{{ action('UserController@dashboard') }}"><i class="fa fa-pie-chart"></i> <span>Dashboard</span></a></li>
                        <li><a href="{{ action('UserController@householdView') }}"><i class="fa fa-window-maximize"></i> <span>Household</span></a></li>
                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-area-chart"></i> <span>Analytics</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ action('UserController@analyticsView',['default']) }}"><i class="fa fa-circle-o"></i>Screening</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['doctor']) }}"><i class="fa fa-user-md"></i>Followup</a></li>
                                <li><a href="{{ action('UserController@diseaseView') }}"><i class="fa fa-user-md"></i>Diseases</a></li>
                                
                            </ul>
                        </li>
                        <li><a href="{{ action('UserController@getPatientsView') }}"><i class="fa fa-user-o"></i> <span>Patients</span></a></li>
                        <li><a href="{{ action('UserController@reportsView') }}"><i class="fa fa-book"></i> <span>Reports</span></a></li>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            @yield('content')
            <!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">

                </div>
                <strong>Copyright &copy; <a href="#">Login</a>.</strong> All rights
                reserved.
            </footer>



            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->



        <script>
            $(function () {
                var current = location.pathname;
//                console.log(current);
                $('li a').each(function () {
                    var $this = $(this);
                    // if the current path is like this link, make it active
                    if ($this.attr('href').indexOf(current) !== -1) {
                        
                        $this.parent().addClass('active');
                    }
                    if (($this.attr('href').indexOf("analytics") !== -1) && $this.attr('href').indexOf(current) !== -1) {
                        
                        $this.parent().parent().parent().addClass('active');
                    }
                })
            })
        </script>    

    </body>
</html>
