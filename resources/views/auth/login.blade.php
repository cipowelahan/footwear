<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Login</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/AdminLTE.min.css')}}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <img src="{{asset('public/assets/image/endar.png')}}" alt="" width="160" height="86">
    <br>
    {{-- ENDAR FOOT WEAR --}}
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">

    @if ($errors->any())
    <div class="alert alert-danger">
    <h4>Error</h4>
    @foreach($errors->all() as $error)
    {{$error}} <br>
    @endforeach
    </div>
    @endif

    @if (session('must-login'))
    <div class="alert alert-warning">Silahkan Login</div>
    @endif

    <form action="{{route('login')}}" method="post">
      {{csrf_field()}}
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Username" name="username">
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
      </div>
      <div class="row">
        <div class="col-xs-8">
          {{-- <a href="{{route('homepage')}}">Ke Beranda</a> --}}
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Login</button>
        </div>
      </div>
    </form>

  </div>
</div>
<script src="{{asset('public/assets/dashboard/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap.min.js')}}"></script>
</body>
</html>
