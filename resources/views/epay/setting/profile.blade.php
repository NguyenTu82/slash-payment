@extends('epay.layouts.base', ['title' => __('common.setting.title')])
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/merchant/css/setting.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <style>
        .password-item {
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }
        .password-item .form-item-ip {
            padding: 0;
            max-width: unset;
        }
    </style>
@endpush

@php
    $userInfo = auth('epay')->user();
@endphp
@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-lg-12 pl-xl-0 pr-30">
                <div class="account bg-white mt-20">
                    @include('epay.setting.navbar')
                </div>

                {{-- tab content  --}}
                <div class="tab-content" id="nav-tabContent">
                    <div class="profile-box">
                        <form action="" method="POST" id="update-profile-form" class="">
                            <div class="row">
                                {{-- box left --}}
                                <div class="col-12">
                                    <h3 class="tab-content-title">{{ __('common.setting.profile.profile_info') }}</h3>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.account_id') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <input readonly type="text" class="form-control" id="input-uid"
                                                   value="{{ formatAccountId($userInfo->user_code) }}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.name') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <input readonly type="text" class="form-control editable" id="input-name"
                                                   name="name" value="{{ $userInfo->name }}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.account_type') }}
                                        </label>

                                        <div class="col-sm-9 form-item-ip">
                                            <select disabled class="form-control editable" id="my-role" name="role_id">
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}"
                                                        @if (old('role_id') == $role->id)
                                                            selected
                                                        @elseif ($userInfo->role_id == $role->id)
                                                            selected
                                                        @endif
                                                    >{{ $role->name_jp }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.note') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                      <textarea readonly class="form-control editable" id="input-note" rows="5"
                                              name="note">{{$userInfo->note}}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.login_mail') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <input readonly type="text" class="form-control" id="input-email"
                                                   name="email" value="{{ $userInfo->email }}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item mb-30">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('common.setting.profile.password') }}
                                        </label>
                                        <div class="col-sm-9 password-item">
                                            <div class="col-sm-9 pw-current-box form-item-ip pw-current-box-epay">
                                                <input readonly type="password" class="form-control" value="***********">
                                            </div>
                                            <div class="change-pw-box">
                                                <a href="#" onclick="showChangePasswordModal()">
                                                    {{ __('common.setting.profile.change_pass_btn') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom"></label>
                                        <div class="col-sm-9 pl-0">
                                            <button onclick="editProfile()"
                                                    type="button"
                                                    class="btn form-save"
                                                    id="edit-profile"> {{ __('auth.common.change_password.save_button') }}
                                            </button>
                                            <button onclick="confirmUpdateProfile()"
                                                    type="button"
                                                    class="btn form-save d-none"
                                                    id="confirm-update-profile"> {{ __('common.button.submit') }}
                                            </button>
                                            <button onclick="cancelUpdateProfile()"
                                                    type="button"
                                                    class="btn form-close d-none"
                                                    id="cancel-update-profile"> {{ __('auth.common.change_password.close_button') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('common.modal.password.change')
    @include('common.modal.password.confirm_change', [
        'url' => route('admin_epay.setting.profile.change_password')
    ])
    @include('common.modal.password.success_change')
    @include('epay.setting.modal.confirm_update_profile')
    @include('epay.setting.modal.success_update_profile')
@endsection

@push('script')
    <script>
        const MY_ROLE_ID = @json($userInfo->role_id);
        const ROLES = @json($roles);
        const ROLES_NAME = {
            'administrator': 'administrator',
            'operator': 'operator',
            'user': 'user'
        }
        const MY_ROLE = ROLES.find(item => {
            return item.id == MY_ROLE_ID
        })
        const MY_ROLE_NAME = MY_ROLE.name;

        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-update-profile-modal");
        const SUCCESS_UPDATE_PROFILE_MODAL = $("#success-update-profile-modal");
        const UPDATE_PROFILE_FORM = $("#update-profile-form");

        const EDIT_PROFILE_BTN = $("#edit-profile");
        const CONFIRM_UPDATE_PROFILE_BTN = $("#confirm-update-profile");
        const CANCEL_UPDATE_PROFILE_BTN = $("#cancel-update-profile");

        // Processes modals
        function confirmUpdateProfile(elm) {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                $(CONFIRM_UPDATE_PROFILE_MODAL).modal('show');
            }
        }
        // End processes modals

        // go to mode edit
        function editProfile() {
            $(".editable").attr("readonly", false).attr("disabled", false);
            $(EDIT_PROFILE_BTN).addClass('d-none');
            $(CONFIRM_UPDATE_PROFILE_BTN).removeClass('d-none');
            $(CANCEL_UPDATE_PROFILE_BTN).removeClass('d-none');
            if (MY_ROLE_NAME == ROLES_NAME.administrator) {
                $('#my-role').parent().find('button').removeClass("disabled");
            } else {
                $('#my-role').attr("disabled", true);
            }
        }

        function updateProfile() {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                let formData = $(UPDATE_PROFILE_FORM).serializeArray();
                $.ajax({
                    url: "{{ route('admin_epay.setting.profile.update_profile') }}",
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    data: formData
                }).done(function (response) {
                    if (response["status"]) {
                        $(SUCCESS_UPDATE_PROFILE_MODAL).modal('show');
                    }
                    setTimeout(function () {
                        window.location.reload()
                    }, 2000)
                }).fail(function (err) {
                    toastr.options.timeOut = 10000;
                    if (err.status === 422) {
                        let errors = err.responseJSON.errors;
                        let msg = '<ul>' + parseValidateMessage(errors) + '</ul>'
                        toastr.error(msg);
                    } else {
                        toastr.error(UPDATE_FAILED_MSG);
                    }
                }).always(function (xhr) {
                    $(CONFIRM_UPDATE_PROFILE_MODAL).modal('hide');
                });
            }
        }

        function cancelUpdateProfile() {
            window.location.reload()
        }

        $(function () {
            // add more rule
            $.validator.addMethod("checkStringNumber", function (value) {
                return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{6,15}$/.test(value);
            });

            // validate form change password
            $(CHANGE_PASSWORD_FORM_COMMON).validate({
                rules: {
                    password: {
                        required: true,
                        checkStringNumber: true,
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                },
                messages: {
                    password: {
                        required: "{{ __('auth.common.two_fa.verify_required') }}",
                        checkStringNumber: "{{ __('auth.common.change_password.new_pass_validate') }}"
                    },
                    password_confirmation: {
                        required: "{{ __('auth.common.two_fa.re_new_verify_required') }}",
                        equalTo: "{{ __('auth.common.change_password.pass_confirm_validate') }}"
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
                }
            });

            // validate form update profile
            $(UPDATE_PROFILE_FORM).validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    role_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "{{ __('admin_epay.setting.profile.validation.name.required') }}",
                    },
                    email: {
                        required: "{{ __('admin_epay.setting.profile.validation.email.required') }}",
                        email: "{{ __('admin_epay.setting.profile.validation.email.invalid') }}",
                    },
                    role_id: "{{ __('admin_epay.setting.profile.validation.role.required') }}",
                },
                errorElement: 'div',
                errorPlacement: function (error, element) {
                    error.addClass('col-sm-2 d-flex align-items-center');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $(UPDATE_PROFILE_FORM).valid();
        });
    </script>
@endpush
