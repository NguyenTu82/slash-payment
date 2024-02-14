@extends('merchant.layouts.auth.base', ['title' => __('auth.common.two_fa.resetting_password')])
@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/toastr/toastr.min.css') }}">
@endpush
@section('content')
    <div class="h-100">
        <div class="container box-auth">
            <div class="container-fluid">
                <div class="justify-content-center d-flex">
                    <img src="{{ asset('/dashboard/img/auth/logo.svg') }}"/>
                </div>
                <p class="login-box-msg mb-2 desc-page">{{ __('auth.common.two_fa.resetting_password') }}</p>
                <p class="text-center mb-4 desc-page-detail">
                    {{__('auth.common.forgot_password.title1')}}
                </p>

                <div class="card-body login-card-body">
                    <form action="{{ route('merchant.auth.forgot_pw_sendmail') }}" method="post" id="quickForm">
                        @csrf
                        <div class="form-group form-forgot-pass">
                            <label class="label-custom">{{ __('auth.common.two_fa.email_address') }}</label>
                            <div class=" mb-3">
                                <input type="text" name="email"
                                       class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}"

                                       value="{{ old('email') }}">

                                @error('email')
                                <span id="inputName-error" class="error invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <p class="desc-mail">{{__('auth.common.forgot_password.title2')}}</p>
                        <p class="mb-5 desc-mail">{{__('auth.common.forgot_password.title3')}}</p>
                        <div class="row">
                            <div class="col-12 justify-content-center d-flex mb-3">
                                <button type="submit"
                                        class="btn bg-primary btn-user btn-block background-button rounded-pill submit-btn">
                                    {{ __('auth.common.two_fa.send') }}
                                </button>
                            </div>
                        </div>
                    </form>

                    <p class="mb-1 help-block text-center mt-3 justify-content-center d-flex">
                        <button class="bnt-back-login btn-block btn-auth-custom rounded-pill">
                            <a href="{{route('merchant.auth.login') }}" class="form-check-label">
                                {{ __('auth.common.two_fa.back_login') }}
                            </a>
                        </button>
                    </p>

                    <!-- Intro shows only on mobile devices -->
                    <!-- @include('epay.layouts.auth.intro') -->
                </div>

                <div class="row copyright">
                    <div class="col-12">
                        <p class="text-center mt-3">2023 Copyrights © <span class="trademark">epay</span></p>
                        <p class="coppyright-produce">Produce by E-Money Hub Ltd</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="/dashboard/themes/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('dashboard/themes/plugins/toastr/toastr.min.js') }}"></script>
    <script>
        $(function () {
            $('#quickForm').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    }
                },
                messages: {
                    email: {
                        required: "{{ __('validation.common.email.required') }}",
                        email: "{{ __('validation.common.email.email') }}",
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
                },
                submitHandler: function() {
                    $('.submit-btn').prop("disabled", true);
                    $('#quickForm')[0].submit();
                }
            });
        });
    </script>
    <!--Change css base on height of screen-->
    <script>
        $(document).ready(function() {
          var screenHeight = $(window).height();
          console.log(screenHeight);
          if (screenHeight >= 944 & screenHeight<=1080) {
            var paddingValue = 89;
            var marginValue = 48;
          } else {
            var paddingValue = 10;
            var marginValue = 10;
          }

          $('.box-right .box-auth .container-fluid').css('padding-top', paddingValue + 'px', '!important');
          $('.box-right .box-auth .container-fluid .login-card-body .col-12').css('margin-top', marginValue + 'px');
        });
    </script>
@endpush
