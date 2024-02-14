@extends('merchant.layouts.auth.register_base', ['title' => __('auth.common.register.title')])
@push('css')
    <link rel="stylesheet" href="/dashboard/css/reset_password.css">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/auth/auth.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="/dashboard/css/register.css">
    <style>
        .t-85 {
            top: 85px;
        }
        .footer-custom {
            margin-top: 70px;
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
                    <p class="login-box-msg desc-page">
                        {{ __('auth.common.register.title') }}
                    </p>

                    <div class="">
                        <div class="card-body login-card-body">
                            <form role="form" id="quickForm" method="POST"
                                action="{{ route('merchant.auth.register.store.post') }}">
                                @csrf
                                <div class="form-group mb-15">
                                    <label class="label-custom">
                                        {{ __('common.setting.account.mail') }}*
                                    </label>
                                    <div class="mb-0">
                                        <input type="email"
                                            class="form-control {{ $errors->has('email') ? ' border-error' : '' }}"
                                            id="inputEmail" name="email" placeholder="" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-15">
                                    <label class="label-custom">
                                        {{ __('common.register.username') }}*
                                    </label>
                                    <div class="mb-0">
                                        <input type="text"
                                            class="form-control {{ $errors->has('name') ? ' border-error' : '' }}"
                                            id="inputName" name="name" placeholder="" value="{{ old('name') }}">
                                    </div>
                                </div>

                                <div class="form-group mb-15">
                                    <label class="label-custom" for="inputPassword label-login">
                                        {{ __('common.setting.account.password') }}*
                                    </label>
                                    <div class="mb-0">
                                        <input type="password" class="form-control" id="inputPassword" name="password"
                                            placeholder="" value="{{ old('password') }}">

                                        <small class="form-text text-muted">
                                            {{ __('validation.common.password_confirm.invalid') }}
                                        </small>
                                    </div>
                                </div>

                                <div class="form-group mb-15">
                                    <label class="label-custom" for="inputPasswordConfirm label-login">
                                        {{ __('common.setting.account.confirm_password_2') }}*
                                    </label>
                                    <div class=" mb-0">
                                        <input type="password" class="form-control" name="password_confirm" placeholder=""
                                            id="inputPasswordConfirm" value="{{ old('password_confirm') }}">

                                        <small class="form-text text-muted">
                                            {{ __('validation.common.password_confirm.not_match') }}
                                        </small>
                                    </div>
                                </div>

                                <div class=" row-option-select">
                                    <div class=" option-checkbox-remember">
                                        <div class="icheck-primary">
                                            <input type="checkbox" id="agree_checkbox" name="agree_checkbox"
                                                class="border-error" {{ old('agree_checkbox') ? 'checked' : '' }} />
                                            <label for="agree_checkbox" class="remember">
                                                @if (app()->getLocale() == 'en')
                                                    {{ __('auth.common.register.agree') }}
                                                @endif
                                                <a target="_blank" href="#"> {{ __('auth.common.register.terms_of_service') }} </a>
                                                {{ __('auth.common.register.and') }}
                                                <a target="_blank" href="#"> {{ __('auth.common.register.privacy_policy') }} </a>
                                                @if (app()->getLocale() !== 'en')
                                                    {{ __('auth.common.register.agree') }}
                                                @endif
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 justify-content-center d-flex mt-30 mb-30">
                                    <button type="submit"
                                        class="btn bg-primary btn-user btn-block background-button rounded-pill p-2"
                                        id="register-btn">
                                        {{ __('auth.common.register.submit') }}
                                    </button>
                                </div>
                            </form>

                            <p class="mb-1 help-block text-center mt-3 justify-content-center d-flex">
                                <button class="btn bnt-back-login btn-block btn-auth-custom rounded-pill p-2">
                                    <a href="{{ route('merchant.auth.login') }}" class="form-check-label">
                                        {{ __('auth.common.two_fa.back_login') }}
                                    </a>
                                </button>
                            </p>

                            <div class="footer-custom">
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

    @include('common.modal.merchant_store_validate', [
        'title' => __('入力チェックのエラー'),
        'submit_btn' => __('admin_epay.merchant.common.rewrite'),
    ])
@endsection

@push('script')
    <script type="text/javascript">
        const REGISTER_FORM = $("#quickForm");
        const SUBMIT_BTN = $("#register-btn");

        $('.btn-yes').on('click', function() {
            $('#merchant-validate-modal').modal('hide');
        });

        @if (session()->has('error'))
            SUBMIT_BTN.prop("disabled", false);
        @endif

        $.validator.addMethod("checkStringNumber", function(value) {
            return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/.test(value);
        });

        REGISTER_FORM.validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                name: {
                    required: true,
                },
                password: {
                    required: true,
                    checkStringNumber: true
                },
                password_confirm: {
                    required: true,
                    equalTo: "#inputPassword"
                },
                agree_checkbox: {
                    required: true,
                },
            },
            messages: {
                email: {
                    required: "{{ __('common.account_management.validation.email.required') }}",
                    email: "{{ __('common.account_management.validation.email.invalid') }}",
                },
                name: {
                    required: "{{ __('common.register.validation_name_required') }}",
                },
                password: {
                    required: "{{ __('common.account_management.validation.password.required') }}",
                    checkStringNumber: "{{ __('auth.common.two_fa.verify_check_string') }}"
                },
                password_confirm: {
                    required: "{{ __('common.account_management.validation.password_confirm.required') }}",
                    equalTo: "{{ __('auth.common.two_fa.verify_equal_to') }}"
                },
                agree_checkbox: {
                    required: "{{ __('common.account_management.validation.agree_checkbox.required') }}",
                },
            },
            errorElement: 'p',
            errorPlacement: function(error, element) {
                const name = $(element).attr('name');
                $(`#${name}-error`).find('.error').remove();
                $(`#${name}-error`).append(error);
            },
            highlight: function(element) {
                $(element).addClass('border-error');
            },
            unhighlight: function(element) {
                const name = $(element).attr('name');
                $(`#${name}-error`).find('.error').remove();
                $(element).removeClass('border-error');

            },
            submitHandler: function() {
                SUBMIT_BTN.prop("disabled", true);
                REGISTER_FORM[0].submit();
            },
            invalidHandler: function(event, validator) {
                $('#merchant-validate-modal').modal('show')
                $('.modal-backdrop').show();
            }
        });
    </script>
@endpush
