@extends('epay.layouts.base', ['title' => __('common.setting.title')])
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/create_account.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <style>
        .error {
            font-size: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12 create-new-account p-0">
                <div class="account bg-white mt-20">
                    @include('epay.setting.navbar')
                </div>
                <div class="form-create-account" id="form-create">
                    <form class="fomr-create" action="{{ route('admin_epay.account.store.post') }}" method="POST" id="create-account-form">
                        @csrf
                        <h3 class="title-create-account">{{ __('common.setting.account.create_account_title') }}</h3>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.name') }}
                            </label>
                            <div class="col-sm-7 form-item-ip form-note">
                                <input type="text" class="form-control" id="name" name="name"
                                    value="{{ old('name') }}">
                                <div class="note-pass"></div>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.role') }}
                            </label>
                            <div class="col-sm-7 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form" id="input-role" name="role_id">
                                        <option value=""></option>
                                        @foreach ($roles as $role)
                                            @if (session()->get('website_language') == 'en')
                                                <option value="{{ $role->id }}" @if (old('role_id') == $role->id) selected @endif>
                                                    {{ $role->name }}</option>
                                            @else
                                                <option
                                                    value="{{ $role->id }}" @if (old('role_id') == $role->id) selected @endif>
                                                    {{ $role->name_jp }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.status') }}
                            </label>
                            <div class="col-sm-7 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form" id="input-status" name="status" disabled>
                                        @php
                                            use \App\Enums\AdminAccountStatus;
                                        @endphp
                                        <option value="{{AdminAccountStatus::VALID->value}}" selected >{{__('common.status.valid')}}</option>
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.note') }}
                            </label>
                            <div class="col-sm-7 form-item-ip form-note">
                                <textarea class="form-control form-area-remarks" id="input-note" name="note" rows="5">{{ old('note') }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.mail') }}
                            </label>
                            <div class="col-sm-7 form-item-ip form-note">
                                <div>
                                    <input type="text" class="form-control @error('email') border-error @enderror" id="input-email" name="email" value="{{ old('email') }}">
                                </div>
                                <div class="note-pass">
                                    @error('email')
                                        <p class="serve-error note-pass-error">{{$errors->first('email')}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item form-note-error-pass">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.password') }}
                            </label>
                            <div class="col-sm-7 pw-current-box form-item-ip form-note form-note-error">
                                <div>
                                    <input type="password" class="form-control" id="password" name="password">
                                    <p class="noti-input">
                                        {{ __('admin_epay.setting.account_management.password_description') }}</p>
                                </div>
                                <div class="note-pass note-pass-err"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item form-note-error-pass">
                            <label for="" class="col-sm-2 col-form-label label-custom">
                                {{ __('common.setting.account.confirm_password') }}
                            </label>
                            <div class="col-sm-7 pw-current-box form-item-ip form-note form-note-error">
                                <div>
                                    <input type="password" class="form-control" id="password-confirmation" name="password_confirm">
                                    <p class="noti-input">
                                        {{ __('admin_epay.setting.account_management.confirm_password_description') }}
                                    </p>
                                </div>
                                <div class="note-pass note-pass-err"></div>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom"></label>
                            <div class="col-sm-7 button-action">
                                <button type="submit" class="btn form-save" id="create-account">{{ __('common.button.create') }}</button>
                                <a href="{{ route('admin_epay.account.index.get') }}">
                                    <button type="button" class="btn form-close">{{ __('common.button.cancel') }}</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('common.modal.confirm', [
        'title' => __('admin_epay.setting.account_management.title_confirm_modal_create'),
        'description' => __('admin_epay.setting.account_management.description_confirm_modal_create'),
        'submit_btn' => __('common.button.create'),
    ])

@endsection

@push('script')
    <script type="text/javascript">
        const CREATE_ACCOUNT_FORM = $("#create-account-form");
        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-modal");
        const UPDATE_FAILED_MSG = "{{ __('common.messages.update_failed') }}";

        SUBMIT_BUTTON_COMMON.on('click', function () {
            CREATE_ACCOUNT_FORM[0].submit();
        });

        $('select').on('change', function(e) {
            $(this).valid();
        });

        // validate form
        $(CREATE_ACCOUNT_FORM).validate({
            rules: {
                name: {
                    required: true,
                },
                role_id: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                    checkStringNumber: true,
                },
                password_confirm: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                name: {
                    required: "{{ __('admin_epay.setting.account_management.validation.name.required') }}",
                },
                role_id: {
                    required: "{{ __('admin_epay.setting.account_management.validation.role.required') }}",
                },
                email: {
                    required: "{{ __('admin_epay.setting.account_management.validation.email.required') }}",
                    email: "{{ __('admin_epay.setting.profile.validation.email.invalid') }}",
                },
                password: {
                    required: "{{ __('admin_epay.setting.account_management.validation.password.required') }}",
                    checkStringNumber: "{{ __('auth.common.two_fa.verify_check_string') }}"
                },
                password_confirm: {
                    required: "{{ __('admin_epay.setting.account_management.validation.password_confirm.required') }}",
                    equalTo: "{{ __('auth.common.two_fa.verify_equal_to') }}"
                },
            },
            errorElement: 'p',
            errorPlacement: function(error, element) {
                $(element).parent().parent().find('.serve-error').remove();
                error.addClass('note-pass-error');
                element.closest('.form-item-ip').find('.note-pass').append(error);
            },
            highlight: function(element) {
                if ($(element)[0].tagName === 'SELECT') {
                    $(element).parent().parent().addClass('border-error');
                } else {
                    $(element).addClass('border-error');
                }
            },
            unhighlight: function(element) {
                $(element).parent().parent().find('.serve-error').remove();
                if ($(element)[0].tagName === 'SELECT') {
                    $(element).parent().parent().removeClass('border-error');
                } else {
                    $(element).removeClass('border-error');
                }
            },
            submitHandler: function() {
                CONFIRM_UPDATE_PROFILE_MODAL.modal('show');
            }
        });
    </script>
@endpush
