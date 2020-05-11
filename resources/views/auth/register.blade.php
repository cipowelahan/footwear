<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Register</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/AdminLTE.min.css')}}">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    Register
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

    <form action="{{route('register')}}" method="post">
      {{csrf_field()}}
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Nama" name="nama" value="{{old('nama')}}">
      </div>
      <div class="form-group">
        <select name="kelamin" class="form-control">
          <option value="L">Laki - Laki</option>
          <option value="P">Perempuan</option>
        </select>
      </div>
      <div class="form-group">
        <input type="email" class="form-control" placeholder="Email" name="email" value="{{old('email')}}">
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" name="password">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Nama Perusahaan" name="nama_perusahaan" value="{{old('nama_perusahaan')}}">
      </div>
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Kontak" name="kontak" value="{{old('kontak')}}">
      </div>
      <div class="row">
        <div class="col-xs-8">
          <a href="{{route('login')}}">Masuk Sistem</a>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block">Daftar</button>
        </div>
      </div>
    </form>

  </div>
</div>
<script src="{{asset('public/assets/dashboard/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap.min.js')}}"></script>
</body>
</html>
