@extends('merchant.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/merchant/css/account_manager_detail.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12 p-0">
                <div class="account bg-white mt-20">
                    @include('merchant.setting.navbar')
                </div>
                <div class="form__edit_account">
                    <h3 class="title_edit_account">{{ __('common.setting.account.detail_account_title') }}</h3>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.account.accountID') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <input disabled type="text" class="form-control" id="input-uid"
                                value="{{ "AC".formatAccountId($account->user_code) }}">
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.account.name') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <input disabled type="text" class="form-control editable" id="input-name"
                                name="name" value="{{ $account->name }}">
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.profile.account_type') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <div class="select_info">
                                <select disabled class="form-control select_form editable" name="role_id">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            @if ($role->id == $account->merchant_role_id) selected @endif>
                                            @if (app()->getLocale() == 'en')
                                                {{ $role->name }}
                                            @else
                                                {{ $role->name_jp }}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.account.status') }}
                        </label>

                        <div class="col col-md-10 form-item-ip">
                            <div class="select_info">
                                <select disabled class="form-control select_form" name="role_id">
                                    <option value="1" @if ($account->status == '0') selected @endif>{{__('common.status.invalid')}}</option>
                                    <option value="2" @if ($account->status == '1') selected @endif>{{__('common.status.valid')}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.profile.note') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <textarea disabled class="form-control form-area-remarks editable" id="input-note" name="note" rows="5"
                                value="{{ $account->note }}">{{ $account->note }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.account.mail') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <input disabled type="text" class="form-control editable" id="input-email"
                                name="email" value="{{ $account->email }}">
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.profile.password') }}
                        </label>
                        <div class="col col-md-10 pw-current-box form-item-ip form-note">
                            <div class="password-input">
                                <input disabled type="password" class="form-control"
                                    value="***********">
                                <div href="" class="note-pass popup-show">
                                    <p class="change-pass show-modal-change-pass" onclick="showChangePasswordModal()">
                                        {{ __('common.setting.profile.change_pass_btn') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('common.setting.profile.store') }}
                        </label>
                        <div class="col col-md-10 form-item-ip">
                            <div disabled class="form-control list-area-members list-area-members-disabled editable">
                                @foreach ($myStores as $store)
                                    <p class="members-item">{{ $store->name }}</p>
                                    <div class="line-item"></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row form-item">
                    <label for="" class="col col-md-2 col-form-label label-custom"></label>
                    <div class="col col-md-10 button-action">
                        <div class="btn-edit-cancel">
                            <a class="rule rule_merchant_account_edit" href="{{ route('merchant.account.edit.get', ['id' => $account->id]) }}">
                                <button type="button" class="btn form-save" id="edit-account">
                                    {{ __('common.button.edit') }}
                                </button>
                            </a>
                            <a href="{{ route('merchant.account.index.get') }}">
                                <button onclick="returnEditAccount()" type="button" class="btn form-close"
                                    id="return-edit-account"> {{ __('common.button.back') }}
                                </button>
                            </a>
                        </div>
                        <button data-toggle="modal" data-target="#confirm-modal-delete" type="button"
                            class="btn btn-delete-account rule rule_merchant_account_delete" id="delete-account"> {{ __('common.button.delete') }}
                        </button>
                    </div>
                </div>

                {{-- modal confirm  --}}
                @include('common.modal.confirm_delete', [
                    'title' => __('common.account_management.title_result_modal_delete'),
                    'description' => __('common.account_management.description_confirm_modal_delete'),
                    'url' => route('merchant.account.delete.get', ['id' => object_get($account, 'id')]),
                    'id' => 'confirm-modal-delete'
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
    <script>
        const CHANGE_PASSWORD_MODAL = $("#change-password-modal");
        const CONFIRM_CHANGE_PASSWORD_MODAL = $("#confirm-modal");
        const CHANGE_PASSWORD_FORM = $("#change-password-form");
        $(function() {
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
        });
    </script>
@endpush
