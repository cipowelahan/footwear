<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="keyword" content="">
  <meta name="author" content="">

  <title>ENDAR FOOT WEAR - Dashboard</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="shortcut icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/bootstrap-datepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/ionicons.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/AdminLTE.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/loading.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/summernote.min.css')}}">
  <link rel="stylesheet" href="{{asset('public/assets/dashboard/css/fileinput.min.css')}}">

</head>
<body class="hold-transition skin-blue fixed sidebar-mini">

<div class="wrapper">
  @include('dashboard.components.navigation')
  @include('dashboard.components.sidebar')

  <div id="loader" class="loading">Loader</div>

  @yield('content')

  @include('dashboard.components.footer')

</div>
<!-- ./wrapper -->

<script src="{{asset('public/assets/dashboard/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/fastclick.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/select2.full.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/adminlte.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/notify.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/bootbox.all.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/summernote.min.js')}}"></script>
<script src="{{asset('public/assets/dashboard/js/fileinput.min.js')}}"></script>
<script>
  function routeMenu(method, url, data = null, cb_success = null, cb_error = null) {
    let success, error
    
    loader('show')

    if (typeof cb_success === 'function') {
      success = cb_success
    }
    else {
      success = function(result) {
        $('#dashboard').html(result);
        loader('hide')
      }
    }
    
    if (typeof cb_error === 'function') {
      error = cb_error
    }
    else {
      error = function(error) {
        if (error.status == 422) {
          loader('hide')
          notification(error.responseText, 'error')
        }
        else if (error.status == 401) {
          location.reload(true)
        }
        else {
          routeMenu('post', '{{url('dashboard/error')}}', {
            _token: '{{csrf_token()}}',
            messages: error.responseJSON.message,
            title: error.statusText
          })
          notification(error.statusText, 'error')
        }
      }
    }

    $.ajax({
      method: method,
      url: url,
      data: data,
      success: success,
      error: error
    });
  }

  function loader(text) {
    $('#loader')[text]()
  }

  function notification(text, status) {
    $.notify(text, status, {
      autoHide: true,
      autoHideDelay: 2000,
    })
  }

  $(function() {
    $(`[route="menu"]`).each(function(index, element) {
      $(element).click(function(e) {
        e.preventDefault();
        routeMenu('get', $(this).attr('href'))
      });
    });
  })
</script>
@yield('extra-js')

</body>
</html>
