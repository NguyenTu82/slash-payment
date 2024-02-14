<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{__('admin_epay.merchant.common.success_register')}}</title>
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
    <!-- <link rel="stylesheet" href="/dashboard/css/auth.css"> -->
    <link rel="stylesheet" href="/dashboard/css/reset_password.css">
    <link rel="stylesheet" href="/dashboard/css/custom.css">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/auth/auth.css') }}">
    <style>
        .t-85 {
            top: 85px;
        }
    </style>
    <!-- custom auth css -->
    @stack('css')
</head>
<body class="hold-transition background-login">

@include('epay.layouts.auth.navbar')
<div class="row ">
    <div class="box-right content-auth center-box t-85">
        <div class="h-100">
            <div class="container box-auth">
                <div class="container-fluid">
                    <div class="justify-content-center d-flex">
                        <img class="logo-epay-screen-success" src="/dashboard/img/logo.svg"/>
                    </div>
                    <p class="login-box-msg desc-page">{{ __('admin_epay.merchant.common.merchant_create_success_title') }}</p>

                    <div class="">
                        <div class="card-body login-card-body">
                                <div class="justify-content-center img-success d-flex">
                                    <img class="img-done-success" src="{{ asset('/dashboard/img/done.svg') }}"/>
                                </div>
                                <p class="login-box-msg note-changepass-success">
                                    {{ __('admin_epay.merchant.common.merchant_create_success_description') }}
                                </p>
                                <p class="mb-1 help-block text-center button-success justify-content-center d-flex">
                                    <button class="btn bg-primary btn-user btn-block background-button rounded-pill">
                                        <a href="{{route('merchant.auth.login') }}" class="form-check-label">
                                            {{ __('auth.common.two_fa.back_login') }}
                                        </a>
                                    </button>
                                </p>

                                <div class="row copyright">
                                    <div class="col-12">
                                        <p class="text-center mt-3">2023 Copyrights © <span
                                                class="trademark">epay</span></p>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery -->
<script src="/dashboard/themes/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="/dashboard/themes/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Toastr -->
<script src="/dashboard/themes/plugins/toastr/toastr.min.js"></script>
<!-- AdminLTE App -->
<script src="/dashboard/themes/dist/js/adminlte.min.js"></script>
</body>
</html>
