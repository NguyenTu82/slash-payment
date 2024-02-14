@extends('epay.layouts.auth.base', ['title' => __('auth.common.two_fa.create_account')])
@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/toastr/toastr.min.css') }}">
@endpush
@section('content')
    <div class="container">
        <div class="container-fluid">
            <div class="justify-content-center d-flex mt-5">
                <img src="{{ asset('/dashboard/img/logo.svg') }}" />
            </div>
            <p class="login-box-msg title-login mt-2 mb-5">{{ __('auth.common.two_fa.admin_account_registration') }}</p>
            <!-- /.login-logo -->
            <div class="">
                <div class="card-body login-card-body">
                    <form role="form" id="quickForm" method="POST" action="{{ route('admin_epay.auth.verify') }}">
                        @csrf
                        <input type="hidden" name="id" value="{{ $admin['id'] }}">
                        <input type="hidden" name="email" value="{{ $admin['email'] }}">
                        <div class="form-group custom-form-auth">
                            <label for="inputMail label-login">{{ __('auth.common.two_fa.email_address') }}</label>
                            <div class=" mb-3 custom-form-auth">
                                <input type="email" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                value="{{ $admin['email'] }}" disabled>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group custom-form-auth">
                            <label for="inputPassword label-login">{{ __('auth.common.login.password') }}</label>
                            <div class=" mb-3 custom-form-auth">
                                <input type="password" class="form-control {{ $errors->has('password') ? ' has-danger' : '' }}"
                                    name="password" id="inputPassword" placeholder="{{ __('auth.common.login.password_placeholder') }}">
                            </div>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" style="display: block;" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group mb-3 custom-form-auth">
                            <label for="inputPasswordConfirm label-login">{{ __('auth.common.two_fa.re_enter_password') }}</label>
                            <div class=" mb-3">
                                <input type="password"
                                    class="form-control {{ $errors->has('password_confirm') ? ' has-danger' : '' }}"
                                    name="password_confirm" placeholder="{{ __('auth.common.two_fa.re_enter_password_placeholder') }}" id="inputPasswordConfirm">
                            </div>
                        </div>
                        <div class='col-12 justify-content-center d-flex mt-5 mb-3'>
                            <button type="submit" class="btn bg-primary btn-block btn-auth-custom custom-form-auth rounded-pill p-2">{{ __('auth.common.two_fa.register_button') }}</button>
                        </div>
                    </form>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
    <!-- /.login-box -->
@endsection
@section('js')
    <script>
        $(function() {
            $.validator.addMethod("checkStringNumber", function(value) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/.test(value);
            });
            $('#quickForm').validate({
                rules: {
                    password: {
                        required: true,
                        checkStringNumber: true,
                    },
                    password_confirm: {
                        required: true,
                        equalTo: "#inputPassword"
                    },
                },
                messages: {
                    password: {
                        required: "{{ __('validation.common.password.required') }}",
                        checkStringNumber: "{{ __('validation.common.password_confirm.invalid') }}"
                    },
                    password_confirm: {
                        required: "{{ __('validation.common.password_confirm.required') }}",
                        equalTo: "{{ __('validation.common.password_confirm.not_match') }}"
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
    <script>
        $(function() {
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
@endsection
