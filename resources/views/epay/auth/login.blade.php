@extends('epay.layouts.auth.base', ['title' => __('auth.common.login.login')])
@push('script')
  <script src="{{ asset('dashboard/themes/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script>
    $(function () {
      $('#quickForm').validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            password: {
                required: true,
            },
        },
        messages: {
            email: {
                required: "{{ __('validation.common.email.required') }}",
                email: "{{ __('validation.common.email.format') }}",
            },
            password:{
                required: "{{ __('validation.common.password.required') }}",
            }
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            const name = $(element).attr('name');
            if (name=="email"){
                $('#inputemail-error').hide()
            }
            if (name=="password"){
                $('#inputpassword-error').hide()
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
        }
      });
    });

    $('.login-submit').on('click', function() {
        $(this).prop("disabled", true);
        $('#quickForm')[0].submit();
    });
</script>
@endpush

@section('content')
    <div class="h-100">
        <div class="container box-auth">
            <div class="container-fluid">
                <div class="justify-content-center d-flex">
                    <img src="/dashboard/img/logo.svg" />
                </div>
                <p class="text-center mb-5 desc-page">
                    {{__('auth.common.login.login-display')}}
                </p>

                <form
                    class="login-form"
                    action="{{ route('admin_epay.auth.login') }}"
                    method="post"
                    id="quickForm"
                >
                    @csrf

                    <label class="label-custom">{{__('auth.common.login.email')}}</label>
                    <div class="form-group">
                        <input
                            type="email"
                            name="email"
                            class="form-control @if (Session::has('email-error')) is-invalid @endif"
                            value="@if (Session::has('email-error') || Session::has('password-error')) {{Session::get('email')}} @endif"
                        />
                        @if (Session::has('email-error'))
                        <span id="inputemail-error" class="error invalid-feedback">{{ Session::get('email-error') }}</span>
                        @endif
                    </div>

                    <label class="label-custom">{{__('auth.common.login.password')}}</label>
                    <div class="form-group">
                        <input
                            type="password"
                            name="password"
                            class="form-control @if (Session::has('password-error')) is-invalid @endif"
                            value="@if (Session::has('email-error') || Session::has('password-error')) {{Session::get('password')}} @endif"
                        />
                        @if (Session::has('password-error'))
                        <span id="inputpassword-error" class="error invalid-feedback">{{ Session::get('password-error') }}</span>
                        @endif
                    </div>

                    <div class="row row-option-select">
                        <div class="item-option-select option-checkbox-remember">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember" name="remember" value="1"/>
                                <label
                                    for="remember"
                                    class="remember"
                                >
                                    {{__('auth.common.login.remember_me')}}
                                </label>
                            </div>
                        </div>
                        <div class="item-option-select option-forgot-password">
                            <p class="mb-1 forgot-password">
                                <a
                                    href="{{ route('admin_epay.auth.forgot_password') }}"
                                >{{__('auth.common.login.forgot_password')}}</a
                                >
                            </p>
                        </div>
                    </div>

                    <div class=" action-login justify-content-center d-flex mt-5">
                        <button
                            type="button"
                            class="btn bg-primary btn-user btn-block background-button rounded-pill login-submit"
                        >
                            {{__('auth.common.login.login')}}
                        </button>
                    </div>

                </form>

                <!-- Intro shows only on mobile devices -->
                <!-- @include('epay.layouts.auth.intro') -->

                <div class="row copyright">
                    <div class="col-12">
                        <p class="text-center mt-3">
                            2023 Copyrights ©
                            <span class="trademark">epay</span>
                        </p>
                        <p class="coppyright-produce">Produce by E-Money Hub Ltd</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
