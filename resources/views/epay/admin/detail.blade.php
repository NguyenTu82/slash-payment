@extends('epay.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/account_manager_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <style>
        .error {
            font-size: 100%;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12 p-0">
                <div class="account bg-white mt-20">
                    @include('epay.setting.navbar')
                </div>

                <div class="form-create-account">
                    <form action="" method="POST" id="update-profile-form" class="fomr-create">
                        <h3 class="title_edit_account">
                            {{ __('common.setting.account.account_info') }}
                        </h3>
                        {{-- account_id --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.account_id') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <input type="text" class="form-control" id="input-uid" disabled
                                    value="{{ formatAccountId($adminUser->user_code) }}">
                            </div>
                        </div>

                        {{-- name --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom" id="nameLabel">
                                {{ __('common.setting.profile.name') }}
                            </label>
                            <div class="col col-md-10  form-item-ip form-note">
                                <input type="text" class="form-control editable" disabled id="input-name"
                                    name="name" value="{{ $adminUser->name }}">
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        {{-- type --}}
                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.account_type') }}
                            </label>
                            <div class="col col-md-10 form-item-ip">
                                <div class="select_info">
                                    <select class="form-control select_form editable" disabled name="role_id">
                                        @foreach ($dataRoles as $role)
                                            <option value="{{ $role->id }}"
                                                @if (old('role_id') == $role->id) selected
                                                        @elseif ($adminUser->role_id == $role->id)
                                                            selected @endif>
                                                {{ $role->name_jp }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- status --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.status') }}
                            </label>
                            <div class="col col-md-10 form-item-ip">
                                <div class="select_info">
                                    <select class="form-control select_form editable" disabled
                                        name="status">
                                        @php
                                            use App\Enums\AdminAccountStatus;
                                        @endphp
                                        <option value="0" @if ($adminUser->status == AdminAccountStatus::INVALID->value) selected @endif>無効
                                        </option>
                                        <option value="1" @if ($adminUser->status == AdminAccountStatus::VALID->value) selected @endif>有効
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- note --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.note') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <textarea class="form-control form-area-remarks editable" id="input-note" name="note" disabled rows="5"
                                    >{{ $adminUser->note }}</textarea>
                            </div>
                        </div>

                        {{-- email --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom" id="emailLabel">
                                {{ __('common.setting.profile.login_mail') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <input type="text" class="form-control editable" disabled id="input-email"
                                    name="email" value="{{ $adminUser->email }}">
                                <div class="note-pass" id="unique-email"></div>
                            </div>
                        </div>

                        {{-- password --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom" id="passwordLabel">
                                {{ __('common.setting.profile.password') }}
                            </label>
                            <div class="col col-md-10 pw-current-box form-item-ip form-note align-items-end">
                                <input readonly type="password" class="form-control" disabled
                                    value="***********">
                                <div href="" class="note-pass popup-show">
                                    <p onclick="showChangePasswordModal()" class="change-pass show-modal-change-pass ml-0"
                                        data-toggle="modal">
                                        {{ __('common.setting.profile.change_pass_btn') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- button --}}
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 button-action ml-0">
                                <div class="btn-edit-cancel d-flex">
                                    <button onclick="editProfile()" type="button" class="btn form-save rule rule_epay_account_edit" id="edit-profile">
                                        {{ __('common.button.edit') }}
                                    </button>
                                    <button onclick="confirmUpdateProfile()" type="button" class="btn form-save d-none"
                                        id="confirm-update-profile"> {{ __('common.button.submit') }}
                                    </button>
                                    <button onclick="cancelEdit()" type="button" class="btn form-close d-none"
                                        id="cancel-update-profile">
                                        {{ __('common.button.cancel') }}
                                    </button>
                                    <button onclick="goBack()" type="button" class="btn form-close" id="go-back">
                                        {{ __('common.button.back') }}
                                    </button>
                                </div>
                                <button onclick="showModalDeleteAccount()" type="button" class="btn btn-delete-account rule rule_epay_account_delete"
                                    id="delete-account"> {{ __('common.button.delete') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('common.modal.confirm', [
        'title' => __('common.account_management.title_result_modal_update'),
        'description' => __('common.account_management.description_confirm_modal_update'),
        'submit_btn' => __('common.button.submit'),
    ])

    @include('common.modal.result', getPopupInfo('update_merchant_user_success'))

    @include('epay.setting.modal.confirm_delete_account', [
        'url' => route('admin_epay.account.remove_account.post'),
        'id' => $adminUser->id,
    ])
    @include('common.modal.password.confirm_change', [
        'url' => route('admin_epay.account.change_password.post'),
        'id' => $adminUser->id,
    ])
    @include('common.modal.password.change', [
        'id' => $adminUser->id,
    ])

    @include('common.modal.password.success_change')
@endsection

@push('script')
    <script>
        const UPDATE_SUCCESSFUL_MSG = "{{ __('common.messages.update_successful') }}";
        const UPDATE_FAILED_MSG = "{{ __('common.messages.update_failed') }}";
        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-modal");
        const SUCCESS_UPDATE_PROFILE_MODAL = $("#result-modal");
        const UPDATE_PROFILE_FORM = $("#update-profile-form");
        const CONFIRM_DELETE_ACCOUNT_MODAL = $("#confirm-delete-account-modal");
        const EDIT_PROFILE_BTN = $("#edit-profile");
        const CONFIRM_UPDATE_PROFILE_BTN = $("#confirm-update-profile");
        const CANCEL_UPDATE_PROFILE_BTN = $("#cancel-update-profile");
        const DELETE_ACCOUNT_BTN = $("#delete-account");
        const GO_BACK_BTN = $("#go-back");

        function showModalDeleteAccount() {
            $(CONFIRM_DELETE_ACCOUNT_MODAL).modal('show');
        }

        function confirmUpdateProfile() {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                $(CONFIRM_UPDATE_PROFILE_MODAL).modal('show');
            }
        }

        function goBack() {
            window.location.href = '{{ route('admin_epay.account.index.get') }}';
        }

        function cancelEdit() {
            window.location.reload()
        }

        function editProfile() {
            $(".editable").attr("disabled", false).parent().find('button').removeClass("disabled");
            $(EDIT_PROFILE_BTN).css('cssText', 'display: none !important;');
            $(CONFIRM_UPDATE_PROFILE_BTN).removeClass('d-none');
            $(CANCEL_UPDATE_PROFILE_BTN).removeClass('d-none');
            $(GO_BACK_BTN).addClass('d-none');
            $(DELETE_ACCOUNT_BTN).addClass('d-none');
            $('#emailLabel').html("{{ __('common.setting.account.mail_require') }}");
            $('#nameLabel').html("{{ __('common.setting.account.name_require') }}");
            $('#passwordLabel').html("{{ __('common.setting.account.password_require') }}");

        }

        // 確認ボタン押すと編集進む
        $('#submit-form').on('click', function() {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                updateProfile();
            }
        });

        function updateProfile() {
            let url = "{{ route('admin_epay.account.update_profile.post') }}" + '/' + "{{ $adminUser->id }}";
            if ($(UPDATE_PROFILE_FORM).valid()) {
                let formData = $(UPDATE_PROFILE_FORM).serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    data: formData
                }).done(function(response) {
                    $(SUCCESS_UPDATE_PROFILE_MODAL).modal('show');
                    $(".editable").attr("disabled", true).parent().find('button').addClass("disabled");
                    $(EDIT_PROFILE_BTN).removeClass('d-none');
                    $(CONFIRM_UPDATE_PROFILE_BTN).addClass('d-none');
                    $(CANCEL_UPDATE_PROFILE_BTN).addClass('d-none');
                    $(GO_BACK_BTN).removeClass('d-none');
                    $(DELETE_ACCOUNT_BTN).removeClass('d-none');
                }).fail(function(err) {
                    toastr.options.timeOut = 10000;
                    if (err.status === 422) {
                        const mesErr = err?.responseJSON?.errors?.email?.[0];
                        if (mesErr) {
                            let element =
                                `<p id="input-email-error" class="error note-pass-error"> ${mesErr} </p>`
                            $('#unique-email').html(element);
                            $('#input-email').addClass('is-invalid');
                        }
                    } else {
                        toastr.error(UPDATE_FAILED_MSG);
                    }
                }).always(function(xhr) {
                    $(CONFIRM_UPDATE_PROFILE_MODAL).modal('hide');
                });
            }
        }

        function cancelUpdateProfile() {
            window.location.reload()
        }

        $(function() {
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
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });

            // validate form update profile
            $(UPDATE_PROFILE_FORM).validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    name: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "{{ __('admin_epay.setting.profile.validation.email.required') }}",
                        email: "{{ __('admin_epay.setting.profile.validation.email.invalid') }}",
                    },
                    name: {
                        required: "{{ __('admin_epay.setting.profile.validation.name.required') }}",
                    },
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    error.addClass('note-pass-error');
                    element.closest('.form-item-ip').find('.note-pass').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            $(UPDATE_PROFILE_FORM).valid();
        });
    </script>
@endpush
