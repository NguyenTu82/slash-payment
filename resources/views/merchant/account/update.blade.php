@extends('merchant.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/merchant/css/account_manager_edit.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        .error {
            font-size: 100%;
        }
        .input-custom {
            width: inherit !important;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12 p-0">
                <div class="account bg-white mt-20">
                    @include('merchant.setting.navbar')
                </div>
                <div class="form__edit_account">
                    <form id="updateAccountForm"
                        action="{{ route('merchant.account.update.post', ['id' => $account->id]) }}" data-toggle="validator"
                        method="POST">
                        @csrf
                        <h3 class="title_edit_account">{{ __('common.setting.account.detail_account_title') }}</h3>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.accountID') }}
                            </label>
                            <div class="col col-md-10 form-item-ip">
                                <input readonly type="text" class="form-control" disabled id="input-uid" name="id"
                                    value="{{ "AC".formatAccountId($account->user_code) }}">
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.name') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <input type="text" class="form-control" id="input-name" name="name"
                                    value="{{ old('name') ?: $account->name }}">
                                <div class="note-pass">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.account_type') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form" id="merchant_role_id" name="merchant_role_id">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}"
                                                @if (old('merchant_role_id')) {
                                                    @if ($role->id == old('merchant_role_id')) selected @endif
                                            } @else @if ($role->id == $account->merchant_role_id) selected @endif @endif>
                                                @if (app()->getLocale() == 'en')
                                                    {{ $role->name }}
                                                @else
                                                    {{ $role->name_jp }}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.status') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form editable" id="status" name="status">
                                        @php
                                            use \App\Enums\MerchantUserStatus;
                                        @endphp
                                        <option value="{{MerchantUserStatus::VALID->value}}" @if (old('status') == MerchantUserStatus::VALID->value or $account->status == MerchantUserStatus::VALID->value) selected @endif>
                                            {{ __('common.status.valid') }}</option>
                                        <option value="{{MerchantUserStatus::INVALID->value}}" @if (old('status') == MerchantUserStatus::INVALID->value or $account->status == MerchantUserStatus::INVALID->value) selected @endif>
                                            {{ __('common.status.invalid') }}</option>
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.note') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <textarea class="form-control form-area-remarks" id="note" name="note" rows="5"
                                    placeholder="{{ __('common.account_management.placeholder_note') }}">{{ old('note') ?: $account->note }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.mail') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <input type="text" class="form-control @error('email') border-error @enderror"
                                    id="input-email" name="email"
                                    value="{{ old('email') ?: $account->email }}">
                                <div class="note-pass">
                                    @error('email')
                                        <p class="serve-error note-pass-error">{{ $errors->first('email') }}</p>
                                    @enderror
                                </div>

                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.password') }}
                            </label>
                            <div class="col col-md-10 pw-current-box form-item-ip form-note">
                                <input readonly type="password" class="form-control" disabled
                                    value="***********">
                                <div href="" class="note-pass popup-show">
                                    <p class="change-pass show-modal-change-pass ml-0" onclick="showChangePasswordModal()">
                                        {{ __('common.setting.profile.change_pass_btn') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.store') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note form-note-textarea">
                                <div class="form-control list-area-members">
                                    @if ($errors->any())
                                        @foreach (old('merchant_store_ids') as $key => $value)
                                            <p class="members-item">{{ $key }}</p>
                                            <div class="line-item"></div>
                                        @endforeach
                                    @else
                                        @foreach ($myStores as $store)
                                            <p class="members-item">{{ $store->name }}</p>
                                            <div class="line-item"></div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="note-pass note-pass-select">
                                    <input type="hidden" name="store_latest"
                                        value="{{ count($myStores) > 0 or (old('merchant_store_ids') ? $account->name : '') }}">
                                    <div>
                                        <p class="note-pass-error"></p>
                                    </div>
                                    <button type="button" class="btn form-select" data-toggle="modal"
                                        data-target="#selectMerchant">
                                        {{ __('merchant.setting.profile.choose_store') }}
                                    </button>

                                    <!-- Modal Select Merchant -->
                                    @include('common.modal.select_merchant', [
                                        'stores' => $merchantStores,
                                        'selectedStores' => old('merchant_store_ids') ?: $myStores->pluck('id')->all(),
                                    ])
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-sm-2 col-form-label label-custom"></label>
                            <div class="col col-md-7 button-action">
                                <button type="submit" class="btn form-save">
                                    {{ __('common.button.submit') }}
                                </button>
                                <button type="button" class="btn form-close">
                                    {{ __('common.button.back') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal confirm -->
                @include('common.modal.confirm', [
                    'class' => 'update-account',
                    'title' => __('common.account_management.title_result_modal_update'),
                    'description' => __('common.account_management.description_confirm_modal_update'),
                    'submit_btn' => __('common.button.submit'),
                ])

                @include('common.modal.password.confirm_change', [
                    'url' => route('merchant.account.change_password.post', ['id' => $account->id]),
                ])
                @include('common.modal.password.change', [
                    'id' => $account->id,
                ])
                @include('common.modal.password.success_change')
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            const MERCHANT_STORE = $('.merchant-item');
            const STORE_SELECTED = $('.list-area-members');
            const UPDATE_ACCOUNT_FORM = $('#updateAccountForm');
            const CONFIRM_UPDATE_PROFILE_MODAL = $(".update-account");
            const MERCHANT_SELECTED = $('.form-note-textarea');
            const CANCEL_UPDATE_ACCOUNT_BTN = $('.form-close');
            const UPDATE_ACCOUNT_BTN = $('.update-account-submit');

            // Show merchant name select to view
            MERCHANT_STORE.on('click', function() {
                STORE_SELECTED.children().remove();
                $('input[name=store_latest]').val('');
                $('input:checked').each(function() {
                    let name = $(this).data('name');
                    $('input[name=store_latest]').val(name);
                    STORE_SELECTED.append(
                        `<p class="members-item">${name}</p><div class="line-item"></div>`);
                });

                if ($('input:checked').length > 0) {
                    MERCHANT_SELECTED.find('.border-error').removeClass('border-error');
                    MERCHANT_SELECTED.find('.note-pass-error').html('');
                }
            });

            // update account
            UPDATE_ACCOUNT_BTN.on('click', function() {
                UPDATE_ACCOUNT_FORM[0].submit();
            });

            CANCEL_UPDATE_ACCOUNT_BTN.on('click', function() {
                window.location.href =
                    `{{ route('merchant.account.detail.get', ['id' => $account->id]) }}`;
            });

            // Validate form
            $(function() {
                $.validator.setDefaults({
                    ignore: []
                });

                UPDATE_ACCOUNT_FORM.validate({
                    // $(UPDATE_ACCOUNT_FORM).validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        merchant_role_id: {
                            required: true,
                        },
                        status: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        store_latest: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "{{ __('common.account_management.validation.name.required') }}",
                        },
                        merchant_role_id: {
                            required: "{{ __('common.account_management.validation.role.required') }}",
                        },
                        status: {
                            required: "{{ __('common.account_management.validation.status.required') }}",
                        },
                        email: {
                            required: "{{ __('common.account_management.validation.email.required') }}",
                            email: "{{ __('common.account_management.validation.email.invalid') }}",
                        },
                        store_latest: {
                            required: "",
                        },
                    },
                    errorElement: 'p',
                    errorPlacement: function(error, element) {
                        $(element).parent().parent().find('.serve-error').remove();
                        const name = $(element).attr('name');
                        if (name === 'store_latest') {
                            $('.list-area-members').addClass('border-error');
                            $(element).parent().find('.note-pass-error').html('')
                                .append(
                                    "{{ __('common.account_management.validation.merchant_store_ids.required') }}"
                                );
                        } else {
                            error.addClass('note-pass-error');
                            element.closest('.form-item-ip').find('.note-pass').append(error);
                        }
                    },
                    highlight: function(element) {
                        $(element).addClass('border-error');
                    },
                    unhighlight: function(element) {
                        $(element).parent().parent().find('.serve-error').remove();
                        $(element).removeClass('border-error');
                    },
                    submitHandler: function() {
                        $(CONFIRM_UPDATE_PROFILE_MODAL).modal('show');
                    }
                });

                // validate form change password
                CHANGE_PASSWORD_FORM_COMMON.validate({
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
            });
        });
    </script>
@endpush
