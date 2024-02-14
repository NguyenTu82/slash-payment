
@extends('epay.layouts.auth.base', ['title' => __('auth.common.forgot_password.title')])
@section('content')
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('dashboard/themes/img/logo.png') }}" alt="">
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('auth.common.forgot_password.title') }}</p>
                <div class="">
                    <div class="card-body">
                        <p class="login-box-msg"></p>
                        <div class="mb-1 help-block text-center">
                            <label class="form-check-label">{{ __('auth.common.forgot_password.forgot_success_label') }}</label>
                        </div>
                        <!-- /.social-auth-links -->
                        <p class="mb-1 help-block text-center mt-5">
                            <a href="{{ route('admin_epay.auth.login') }}" class="btn btn-primary btn-block btn-auth-custom">{{ __('auth.common.forgot_password.forgot_success_button') }}</a>
                        </p>
                    </div>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
        <!-- /.login-box -->
    @endsection
