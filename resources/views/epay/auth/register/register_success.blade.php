@extends('epay.layouts.auth.register_base', ['title' => __('auth.common.register.success_register_title')])
@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/auth/auth.css') }}">
    <style>
        .t-85 {
            top: 85px;
        }
        .mt-12 {
            margin-top: 12px;
        }
        .mt-150 {
            margin-top: 150px;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="box-right content-auth center-box t-85">
            <div class="h-100">
                <div class="container box-auth">
                    <div class="container-fluid">
                        <div class="justify-content-center d-flex">
                            <img src="/dashboard/img/logo.svg" />
                        </div>
                        <p class="login-box-msg desc-page mt-12">
                            {{ __('auth.common.register.success_register_title') }}
                        </p>

                        <div class="">
                            <div class="card-body login-card-body pt-3">
                                <div class="justify-content-center d-flex">
                                    <img src="{{ asset('/dashboard/img/done.svg') }}" />
                                </div>
                                <p class="login-box-msg mt-5">
                                    {{ __('auth.common.register.success_register_des') }}
                                </p>
                                <p class="help-block text-center justify-content-center d-flex mt-150">
                                    <button class="btn bg-primary btn-user btn-block background-button rounded-pill p-2">
                                        <a href="{{ route('admin_epay.auth.login') }}" class="form-check-label">
                                            {{ __('auth.common.two_fa.back_login') }}
                                        </a>
                                    </button>
                                </p>

                                <div class="row copyright">
                                    <div class="col-12">
                                        <p class="text-center mt-3">2023 Copyrights © <span class="trademark">epay</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
