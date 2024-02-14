<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="/dashboard/img/favicon.svg">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/dashboard/themes/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="/dashboard/themes/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Toastr -->
    <!-- Theme style -->
    <link rel="stylesheet" href="/dashboard/themes/dist/css/adminlte.min.css">
    <!--sbadmin2-->
    <link rel="stylesheet" href="/dashboard/themes/dist_sbadmin2/css/sb-admin-2.min.css">
    <link rel="stylesheet" href="/dashboard/themes/dist_sbadmin2/css/sb-admin-2.css">
    <link rel="stylesheet" href="/dashboard/themes/dist_sbadmin2/scss/sb-admin-2.scss">
    <link rel="stylesheet" href="/dashboard/themes/plugins/toastr/toastr.min.css">
    <link rel="stylesheet" href="/dashboard/css/custom.css">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/auth/auth.css') }}">
    
    <!-- custom auth css -->
    @stack('css')
</head>
<body class="hold-transition background-login">

@include('merchant.layouts.auth.navbar')
<div class="row ">
    @yield('content')
</div>
<!-- jQuery -->
<script src="/dashboard/themes/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/dashboard/themes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Toastr -->
<script src="/dashboard/themes/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/dashboard/themes/dist/js/adminlte.min.js"></script>
<script src="/dashboard/themes/plugins/jquery-validation/jquery.validate.min.js"></script>
@stack('script')
<script>
    $(function () {
        // toastr option
        toastr.options.escapeHtml = false;
        toastr.options.closeButton = false;
        toastr.options.closeDuration = 0;
        toastr.options.extendedTimeOut = 500;
        toastr.options.timeOut = 4000;
        toastr.options.tapToDismiss = false;
        toastr.options.positionClass = 'toast-top-center custom-toast';
        @if (session()->has('error'))
            toastr.error("{{session()->get('error')}}");
        @endif
    });
</script>
</body>
</html>
