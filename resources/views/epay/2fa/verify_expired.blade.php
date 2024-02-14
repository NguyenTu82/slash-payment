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
            <p class="login-box-msg p-0 mt-5">{{ $error }}</p>
            <p class="justify-content-center d-flex mt-2 mb-3">
                <a href="{{ route('admin_epay.auth.login') }}" class="btn bg-primary btn-block btn-auth-custom rounded-pill p-2">{{ __('auth.common.forgot_password.forgot_success_button') }}</a>
            </p>
        </div>
    </div>
@endsection
