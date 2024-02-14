
@extends('epay.layouts.auth.base', ['title' => __('auth.common.two_fa.create_account')])
@section('content')
    <div class="container">
        <div class="container-fluid">
            <div class="justify-content-center d-flex mt-5">
                <img src="{{ asset('/dashboard/img/logo.svg') }}" />
            </div>
            <p class="login-box-msg mt-2 mb-5">{{ __('auth.common.two_fa.title_verify_success') }}</p>
            <!-- /.login-logo -->
            <div class="">
                <div class="card-body login-card-body">

                    <div class="">
                        <div class="card-body">
                            <p class="login-box-msg"></p>
                            <div class="mb-1 help-block text-center">
                                <label class="form-check-label">{{ __('auth.common.two_fa.content_verify_success') }}</label>
                            </div>
                            <!-- /.social-auth-links -->
                            <p class="justify-content-center d-flex mt-5 mb-3">
                                <a href="{{ route('admin_epay.auth.login') }}" class="btn bg-primary btn-block btn-auth-custom rounded-pill p-2">{{ __('auth.common.forgot_password.forgot_success_button') }}</a>
                            </p>
                        </div>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
    </div>
@endsection
