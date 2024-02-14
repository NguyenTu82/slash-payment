<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ $title }}</title>
    <link rel="icon" type="image/x-icon" href="/dashboard/img/favicon.svg">

    <!-- Google Font: Source Sans Pro -->
    <link
        rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
    />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- I check bootstrap -->
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Toa str -->
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/toastr/toastr.min.css') }}">
    <!--Sb admin2-->
    <link rel="stylesheet" href="{{ asset('dashboard/themes/dist_sbadmin2/css/sb-admin-2.min.css') }}">

    <!--Custom css-->
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/auth/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">
    <style>
        #toast-container .toast.toast{
            height: 85px !important;
        }
    </style>

    @stack('css')
</head>
<body class="hold-transition background-login">
<!-- Navbar -->
@include('merchant.layouts.auth.navbar')
<!-- /.navbar -->

<!-- Main content -->
<div class="row screen-login">
    <div class="box-left">
        <div class="container mt-5">
            <h3 class="color-white mb-5 font35">
                {{__('auth.common.login.title1')}}
            </h3>
            <h3 class="color-white mb-2 font30">
                {{__('auth.common.login.title2')}}
            </h3>
            <img class="auth-logo mb-5" src="{{ asset('dashboard/img/logo.svg') }}" alt=""/>
            <p class="color-white font16">
                {{__('auth.common.login.title3')}}
            </p>
            <p class="color-white font16">
                {{__('auth.common.login.title4')}}
            </p>
            <p class="color-white font16">
                {{__('auth.common.login.title5')}}
            </p>
        </div>
        <div class="box-text-produce">
            <p class="text-produce">Produce by E-Money Hub Ltd</p>
        </div>
    </div>

    <div class="box-right content-auth">
        @yield('content')
    </div>
</div>

<!-- jQuery -->
<script src="{{ asset('dashboard/themes/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('dashboard/themes/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- Toa str -->
<script src="{{ asset('dashboard/themes/plugins/toastr/toastr.min.js') }}"></script>
<!-- jQuery validation -->
<script src="{{ asset('dashboard/themes/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

<script>
    $(function () {
        // init toa str
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
@stack('script')
</body>
</html>

