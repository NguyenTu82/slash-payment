@extends('merchant.layouts.auth.register_base', ['title' => __('auth.common.register.confirm_register_title')])
@push('css')
    <style>
        .t-85 {
            top: 85px;
        }
        .mt-12 {
            margin-top: 12px;
        }
        .mb-215 {
            margin-bottom: 215px !important;
        }
    </style>
@endpush

@section('content')
    <div class="box-right content-auth center-box t-85">
        <div class="h-100">
            <div class="container box-auth">
                <div class="container-fluid">
                    <div class="justify-content-center d-flex">
                        <img src="/dashboard/img/logo.svg" />
                    </div>
                    <p class="text-center desc-page mt-12 mb-30">
                        {{ __('auth.common.register.confirm_register_title') }}
                    </p>

                    <div class="">
                        <div class="">
                            <p class="text-center mb-0 pb-0 desc-page-detail ">
                                {{ __('auth.common.register.confirm_register_des1') }}
                            </p>
                            <p class="text-center mb-50 pb-0 desc-page-detail">
                                {{ __('auth.common.register.confirm_register_des2') }}
                            </p>
                            <div class="container more-guide mb-215">
                                <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_3') }}</p>
                                <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_4') }}</p>
                                <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_5') }}</p>
                                <p class="mb-0">{{ __('auth.common.forgot_password.resetting_password_confirm_6') }}</p>
                            </div>

                            <p class="mb-1 help-block text-center justify-content-center d-flex">
                                <button class="btn bg-primary btn-user btn-block background-button rounded-pill p-2">
                                    <a href="{{ route('merchant.auth.login') }}" class="form-check-label">
                                        {{ __('auth.common.two_fa.back_login') }}
                                    </a>
                                </button>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
