@extends('epay.layouts.auth.base', ['title' => __('auth.common.two_fa.resetting_password')])
@push('css')
    <link rel="stylesheet" href="/dashboard/themes/plugins/toastr/toastr.min.css">
@endpush
@section('content')
    <div class="h-100">
        <div class="container box-auth">
            <div class="container-fluid">
                <div class="justify-content-center d-flex mt-5">
                    <img src="/dashboard/img/logo.svg"/>
                </div>
                <p class="text-center mt-3 mb-4 desc-page">
                    {{ __('auth.common.forgot_password.resetting_password_confirm_0') }}
                </p>

                <div class="">
                    <div class="">
                        <p class="text-center mb-0 pb-0 desc-page-detail">
                            {{ __('auth.common.forgot_password.resetting_password_confirm_1') }}
                        </p>
                        <p class="text-center mb-5 pb-0 desc-page-detail">
                            {{ __('auth.common.forgot_password.resetting_password_confirm_2') }}
                        </p>
                        <div class="container more-guide">
                            <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_3') }}</p>
                            <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_4') }}</p>
                            <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_5') }}</p>
                            <p class="mb-5">{{ __('auth.common.forgot_password.resetting_password_confirm_6') }}</p>
                        </div>

                        <p class="mb-1 help-block text-center mt-5 justify-content-center d-flex">
                            <button class="btn bg-primary btn-user btn-block background-button rounded-pill p-2">
                                <a href="{{route('admin_epay.auth.login') }}" class="form-check-label">
                                    {{ __('auth.common.login.back') }}
                                </a>
                            </button>
                        </p>

                        <p class="mb-1 help-block text-center mt-3 justify-content-center d-flex">
                            <button class="btn bnt-back-login btn-block btn-auth-custom rounded-pill p-2">
                                <a href="{{route('admin_epay.auth.login') }}" class="form-check-label">
                                    {{ __('auth.common.two_fa.back_login') }}
                                </a>
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
