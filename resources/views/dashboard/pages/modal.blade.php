<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Modal Awal</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap-datepicker.min.css')}}">
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

    <p class="text-center">
      <strong>MASUKKAN MODAL AWAL</strong>
    </p>

    <form action="{{route('dashboard.modal')}}" method="post">
      {{csrf_field()}}
      <div class="form-group">
        <label for="tanggal">Tanggal</label>
        <input id="tanggal" name="tanggal" class="form-control" type="text" autocomplete="off">
      </div>
      <div class="form-group has-feedback">
        <label for="modal">Modal Awal</label>
        <input type="text" class="form-control number-input" placeholder="Modal Awal" name="modal" value="0">
      </div>
      <div class="row">
        <div class="col-xs-8">
          {{-- <a href="{{route('homepage')}}">Ke Beranda</a> --}}
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
        </div>
      </div>
    </form>

  </div>
</div>
<script src="{{asset('public/assets/dashboard/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap-datepicker.min.js')}}"></script>
<script>

  $(function() {
    $('#tanggal').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', new Date())

    $('.number-input').keyup(function(event) {
      var selection = window.getSelection().toString();
      if (selection !== '') {
          return
      }

      if ( $.inArray( event.keyCode, [38,40,37,39] ) !== -1 ) {
          return
      }

      var $this = $(this)
      var input = $this.val()

      input = input.replace(/[\D\s\._\-]+/g, "")
      input = input ? parseInt( input, 10 ) : 0

      $this.val(function() {
          return (input === 0) ? "0" : input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
      })
    })

  })

</script>
</body>
</html>
