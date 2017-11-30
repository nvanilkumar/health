@extends('layouts.stafflogin')

@section('content')

 <div class="login-box">
  <div class="login-logo">
     <b>Admin</b>LTE 
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body" id="login-page">
    <p class="login-box-msg">Sign in to start your session</p>
 
      <div class="form-group has-feedback">
        <input type="email" class="form-control" placeholder="Email" id="username" autocomplete="off">
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" autocomplete="off" id="password" class="validate">
         
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        <span class="error" id="errorMessage"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">

        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat" id="login-link">Sign In</button>
        </div>
        <!-- /.col -->
      </div>
 



  </div>
  <!-- /.login-box-body -->
</div>
<script>
    
    var loginApiUrl = "./login";
    var token="{{ csrf_token() }}";
</script>
<script type="text/javascript" src="{{ asset('/js/login.js') }}"></script>

@endsection

