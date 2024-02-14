<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{__('auth.common.two_fa.resetting_password')}}</title>
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
    {{-- <link rel="stylesheet" href="/dashboard/css/auth.css"> --}}
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

@include('merchant.layouts.auth.navbar')
<div class="row">
    <div class="box-right content-auth center-box t-85">
        <div class="h-100">
            <div class="container box-auth">
                <div class="container-fluid">
                    <div class="justify-content-center d-flex">
                        <img src="/dashboard/img/logo.svg"/>
                    </div>
                    <p class="login-box-msg desc-page">{{ __('auth.common.forgot_password.title') }}</p>

                    <div class="">
                        <div class="card-body login-card-body pt-3">
                            @if($status == "done")
                                <div class="justify-content-center d-flex">
                                    <img src="{{ asset('/dashboard/img/done.svg') }}"/>
                                </div>
                                <p class="login-box-msg mt-5">
                                    {{ __('auth.common.forgot_password.resetting_password_success') }}
                                </p>
                                <p class="mb-1 help-block text-center mt-3 justify-content-center d-flex">
                                    <button class="btn bg-primary btn-user btn-block background-button rounded-pill p-2">
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
                            @else

                                <form role="form" id="quickForm" method="POST"
                                      action="{{ route('merchant.auth.reset_password') }}">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ $email }}">
                                    <input type="hidden" name="token" value="{{ $token }}">
                                    <div class="form-group mb-4">
                                        <label class="label-custom"
                                               for="inputPassword label-login">{{ __('auth.common.two_fa.password_new') }}</label>
                                        <div class="mb-0">
                                            <input type="password"
                                                   class="form-control {{ $errors->has('password') ? ' has-danger' : '' }}"
                                                   id="inputPassword"
                                                   name="password">

                                            <small class="form-text text-muted">
                                                {{ __('validation.common.password_confirm.invalid') }}
                                            </small>

                                            @error('password')
                                            <span id="inputpassword-error"
                                                  class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <div class="form-group mb-3">
                                        <label class="label-custom"
                                               for="inputPasswordConfirm label-login">{{ __('auth.common.two_fa.password_confirm') }}</label>
                                        <div class=" mb-0">
                                            <input type="password"
                                                   class="form-control {{ $errors->has('password_confirmation') ? ' has-danger' : '' }}"
                                                   name="password_confirmation"
                                                   id="inputPasswordConfirm">

                                            <small class="form-text text-muted">
                                                {{ __('validation.common.password_confirm.not_match') }}
                                            </small>

                                            @error('password_confirmation')
                                            <span id="inputpassword-error"
                                                  class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 justify-content-center d-flex mt-3 mb-2">
                                            <button type="submit"
                                                    class="btn bg-primary btn-user btn-block background-button rounded-pill p-2">
                                                {{ __('auth.common.two_fa.send') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <p class="mb-1 help-block text-center mt-3 justify-content-center d-flex">
                                    <button class="btn bnt-back-login btn-block btn-auth-custom rounded-pill p-2">
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
                            @endif
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
<script src="/dashboard/themes/plugins/jquery-validation/jquery.validate.min.js"></script>
<script>
    $(function () {
        $.validator.addMethod("checkStringNumber", function (value) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/.test(value);
        });
        $('#quickForm').validate({
            rules: {
                password: {
                    required: true,
                    checkStringNumber: true,
                },
                password_confirmation: {
                    required: true,
                    equalTo: "#inputPassword"
                },
            },
            messages: {
                token: {
                    required: "{{ __('validation.common.token.required') }}",
                    numberic: "{{ __('validation.common.token.numeric') }}",
                },
                password: {
                    required: "{{ __('validation.common.password.required') }}",
                    checkStringNumber: "{{ __('validation.common.password_confirm.invalid') }}"
                },
                password_confirmation: {
                    required: "{{ __('validation.common.password_confirm.required') }}",
                    equalTo: "{{ __('validation.common.password_confirm.not_match') }}"
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
<script>
    $(function () {
        // toastr option
        toastr.options.escapeHtml = false;
        toastr.options.closeButton = true;
        toastr.options.closeDuration = 0;
        toastr.options.extendedTimeOut = 500;
        toastr.options.timeOut = 5000;
        toastr.options.tapToDismiss = false;
        toastr.options.positionClass = 'toast-top-right';
        @if (session('error'))
        toastr.error("{{ session('error') }}");
        @endif
    });
</script>
</body>
</html>
