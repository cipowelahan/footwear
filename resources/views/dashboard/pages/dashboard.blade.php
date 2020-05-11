@extends('dashboard.layout')

@section('content')
<div id="dashboard" class="content-wrapper">
</div>
@endsection

@section('extra-js')
<script>
    $(function() {
        routeMenu('get', "{{url('dashboard/main')}}")
    })
</script>
@endsection