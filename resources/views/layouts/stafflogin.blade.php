<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title> Log in </title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="{{ asset('/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/AdminLTE.min.css') }}">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon" />
        <script type="text/javascript" src="{{ asset('/js/jquery-2.1.1.min.js') }}"></script>
        <script>
var mtcBaseUrl = "<?php echo url('/'); ?>";
        </script>
        <style>
            #white-background{
                background: #fff !important;
            }
            .loginPageStrip{
                background: #7f4992;
                height: 60px;
            }
            .login-box-body{
                background: #7f4992;
                box-shadow: 1px 3px 6px rgba(0, 0, 0, 0.12), 1px 2px 4px rgba(0, 0, 0, 0.24);
                border-radius: 2px;
            }
            .hoverable {
                -webkit-transition: -webkit-box-shadow .25s;
                transition: -webkit-box-shadow .25s;
                transition: box-shadow .25s;
                transition: box-shadow .25s, -webkit-box-shadow .25s;
            }
            .hoverable:hover {
                -webkit-box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                box-shadow: 0 8px 17px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
            }
            .login-box-msg{
                color: #fff;
                font-size: 15px;
                font-weight: 500;
            }
            .login-box-body .btn{
                background: #7f4992;
                color: #fff;
                border: 1px solid #fff;
                border-radius: 4px;
            }
            .login-box-body .form-control{
                border-radius: 2px;
            }
        </style>

    </head>
    <body class="hold-transition login-page" id="white-background">

        @yield('content')
    </body>
</html>
