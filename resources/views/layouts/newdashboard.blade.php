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
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Admin</b>LTE</span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </a>

                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">


                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!--              <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image">-->
                                    <span class="hidden-xs">Bhanu B</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                      <!--                <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">-->

                                        <p>
                                            Bhanu B 

                                        </p>
                                    </li>
                                    <!-- Menu Body -->

                                    <!-- Menu Footer-->
                                    <li class="user-footer">

                                        <div class="pull-right">
                                            <a href="{{action('UserController@logout')}}" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->

                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">MAIN NAVIGATION</li>
                        <li><a href="{{ action('UserController@dashboard') }}"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                        <li><a href="{{ action('UserController@householdView') }}"><i class="fa fa-window-maximize"></i> <span>Household</span></a></li>
                        <li class="treeview">
                            <a href="">
                                <i class="fa fa-area-chart"></i> <span>Analytics</span>
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ action('UserController@analyticsView',['default']) }}"><i class="fa fa-circle-o"></i>NCD Summary</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['hbp'])  }}"><i class="fa fa-circle-o"></i>High Blood Pressure</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['diag'])  }}"><i class="fa fa-circle-o"></i>Diabetes</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['cancer'])  }}"><i class="fa fa-circle-o"></i>Cancer</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['copd'])  }}"><i class="fa fa-circle-o"></i>COPD</a></li>
                                <li><a href="{{ action('UserController@analyticsView',['cvd'])  }}"><i class="fa fa-circle-o"></i>CVD (High Risk)</a></li>
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
