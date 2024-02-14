@extends('merchant.layouts.base', ['title' => __('common.setting.profile.profile_info')])
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('css/select.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
     <link rel="stylesheet" href="{{ asset('dashboard/merchant/css/setting.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_profile.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_payeeInformation.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">

    <style>
        #content {
            background-color: #FFFFFF;
        }
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: #000;
        }
        .password-item {
            padding: 0;
            display: flex;
            flex-wrap: wrap;
        }
        .password-item .form-item-ip {
            padding: 0;
            max-width: unset;
        }
        .form-note-textarea {
            max-width: 500px;
        }
        .change-store-box {
            display: flex;
            align-items: end;
        }
        .select-option-button {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap:wrap;
            gap:15px 0;
        }
        .select-option-button select ,.select-option-button .form-control.editable  {
            max-width: 330px !important;
            width: 100%;
        }
        .setting-page .change-pw-box {
            margin-left: 0;
            max-width: 500px;
            width: 100%;
            display: flex;
            justify-content: end;
            margin-top: 4px;
        }
        .merchants-view {
            padding: 0;
        }
        .background-popup {
            background-color: rgba(0, 0, 0, 0.5);
        }
        @media only screen and (max-width: 1200px) {
            .merchants-view {
                flex-wrap: wrap;
                gap: 10px;
            }
            .change-store-box {
                padding-left: 0;
                display: block;
            }
        }
        @media only screen and (max-width: 576px) {
            .setting-page .profile-box .form-item-ip {
                flex-basis: unset;
            }
        }
    </style>
@endpush

@php
    $myStores = $allMerchantStores;
    $myStoresIds = $myStores->pluck('id')->toArray();
    $allMerchantStoreIds = $myStoresIds;
@endphp

@section('content')
    <div class="setting-page page-white">
        <div class="row">
                <div class="col-md-12 pl-0">
                    <div class="account bg-white mt-20 pr-30">
                        @include('merchant.setting.navbar')
                    </div>

                    {{-- tab content  --}}
                    <div class="tab-content pr-30" id="nav-tabContent">
                        {{-- profile-box--}}
                        <div class="profile-box">
                            <form action="" method="POST" id="update-profile-form" class="">
                                <div class="row">
                                    {{-- box left --}}
                                    <div class="col-lg-12 col-xl-6">
                                        <h3 class="tab-content-title">{{ __('common.setting.profile.profile_info') }}</h3>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.account_id') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <input readonly
                                                       type="text"
                                                       class="form-control"
                                                       id="input-uid"
                                                       value="{{ "AC".formatAccountId($profileInfo->user_code) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.name') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <input
                                                    readonly
                                                    type="text"
                                                    class="form-control editable"
                                                    id="input-name"
                                                    name="name"
                                                    value="{{ $profileInfo->name }}">
                                                <!-- <span class="error invalid-feedback d-block">アカウント名を入力して下さい</span> -->
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.account_type') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <select
                                                    disabled
                                                    class="form-control editable"
                                                    id="my-role"
                                                    name="merchant_role_id">
                                                    @foreach ($roles as $role)
                                                        <option value="{{ $role->id }}"
                                                                @if (old('role_id') == $role->id)
                                                                    selected
                                                                @elseif ($profileInfo->merchant_role_id == $role->id)
                                                                    selected
                                                            @endif
                                                        >
                                                            @if(app()->getLocale() == 'en')
                                                                {{$role->name}}
                                                            @else
                                                                {{$role->name_jp}}
                                                            @endif
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.note') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <textarea readonly
                                                          class="form-control editable"
                                                          id="input-note"
                                                          rows="5"

                                                          name="note"
                                                >{{$profileInfo->note}}</textarea>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.login_mail') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <input
                                                    readonly
                                                    type="text"
                                                    class="form-control"
                                                    id="input-email"

                                                    name="email"
                                                    value="{{ $profileInfo->email }}">
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('common.setting.profile.password') }}
                                            </label>
                                            <div class="col-lg-9 password-item">
                                                <div class="col-lg-9 pw-current-box form-item-ip">
                                                    <input
                                                        readonly
                                                        type="password"
                                                        class="form-control"

                                                        value="***********">
                                                </div>
                                                <div class="change-pw-box">
                                                    <a href="#" onclick="showChangePasswordModal()">
                                                        {{ __('common.setting.profile.change_pass_btn') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item mb-30">
                                            <label for="" class="col-lg-3 col-form-label label-custom">
                                                {{ __('merchant.setting.profile.stores') }}
                                            </label>
                                            <div class="col-lg-9 d-flex pl-0 merchants-view">
                                                <div class="form-item-ip form-note form-note-textarea">
                                                    <div disabled class="form-control list-area-members list-area-members-disabled editable" id="my-stores-box">
                                                        @foreach($myStores as $store)
                                                            <p class="members-item">{{$store->name}}</p>
                                                            <div class="line-item"></div>
                                                        @endforeach
                                                    </div>
                                                </div>

                                                <div class="change-store-box">
                                                    <button onclick="showChangeStoresModal()"
                                                            type="button"
                                                            class="btn d-none"
                                                            id="change-stores-btn"> {{ __('merchant.setting.profile.choose_store') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom"></label>
                                            <div class="col-lg-9 pl-0 pr-0">
                                                <button onclick="editProfile()"
                                                        type="button"
                                                        class="btn form-save rule rule_merchant_profile_edit"
                                                        id="edit-profile"> {{ __('common.button.change') }}
                                                </button>
                                                <div class="button-action-w500">
                                                    <button onclick="confirmUpdateProfile()"
                                                            type="button"
                                                            class="btn form-save d-none"
                                                            id="confirm-update-profile"> {{ __('auth.common.register.submit') }}
                                                    </button>
                                                    <button onclick="cancelUpdateProfile()"
                                                            type="button"
                                                            class="btn form-close d-none"
                                                            id="cancel-update-profile"> {{ __('common.button.cancel') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- box right --}}
                                    <div class="col-lg-12 col-xl-6 box-right-col-6">
                                        <div class="form-group row form-item">
                                            <label for="" class="col-lg-3 col-form-label label-custom pl-0">
                                                {{ __('common.setting.profile.store') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip select-option-button">
                                                <select
                                                    onchange="showPaymentInfo()"
                                                    class="form-control editable"
                                                    id="store-id-selected">
                                                    @if (!empty($profileInfo->getMerchantStore))
                                                    <option value="{{ $profileInfo->getMerchantStore->id }}">
                                                        {{ $profileInfo->getMerchantStore->name}}
                                                    </option>
                                                    @endif

                                                    @foreach($myStores as $store)
                                                        <option value="{{ $store->id }}">
                                                            {{ $store->name}}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <button
                                                    onclick="getDetailStore()"
                                                    type="button"
                                                    class="btn btn-primary btn-shop-member"
                                                   > {{ __('merchant.setting.profile.store_detail') }}
                                                </button>
                                            </div>
                                        </div>

                                        <h3 class=" row tab-title mt-30 mb-30">{{ __('merchant.setting.profile.payment_profile') }}</h3>

                                        <div class="form-group row form-item mb-15">
                                            <label for="" class="col-lg-3 col-form-label label-custom pl-0">
                                                {{ __('merchant.setting.profile.url') }}
                                            </label>
                                            <div class="col-lg-9 form-item-ip">
                                                <div class="input-group">
                                                    <input readonly
                                                           type="text"
                                                           class="form-control"
                                                           id="payment-url"

                                                           aria-label=""
                                                           value="">
                                                    <button onclick="copyPaymentURL()"
                                                            data-clipboard-target="#payment-url"
                                                            class="btn btn-primary rounded-0 copy-qr-btn"
                                                            type="button"
                                                            id="copy-payment-url">
                                                        <img src="{{ asset('/dashboard/img/copy.svg') }}"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item mb-15">
                                            <label for="" class="col-lg-3 col-form-label label-custom pl-0" id="qr-code-label">
                                                {{ __('common.setting.profile.qr_code') }}
                                            </label>
                                            <div class="col-sm-9 form-item-ip">
                                                <div id="qr-code-img"></div>
                                                <button onclick="downloadQrCode()"
                                                        type="button"
                                                        class="btn download-qr-btn"
                                                       > {{ __('merchant.setting.profile.download_qr') }}
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
        'url' => route('merchant.setting.profile.change_password')
    ])
    @include('common.modal.password.success_change')
    @include('merchant.setting.modal.change_store')
    @include('merchant.setting.modal.confirm_update_profile')
    @include('merchant.setting.modal.success_update_profile')

    @include('merchant.setting.modal.detail_store')
@endsection

@push('script')
    <script>
        const ALL_MERCHANT_STORES = @json($myStores);
        var myStores = @json($myStores);
        var myStoreIds = @json($myStoresIds);

        const ROLES = @json($roles);
        const MY_ROLE_ID = @json(auth('merchant')->user()->merchant_role_id);
        const ROLES_NAME = {
            'administrator': 'administrator',
            'operator': 'operator',
            'user': 'user'
        }
        const MY_ROLE = ROLES.find(item => {
            return item.id == MY_ROLE_ID
        })
        const MY_ROLE_NAME = MY_ROLE?.name || '';


        const CHANGE_STORES_MODAL = $("#change-stores-modal");
        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-update-profile-modal");
        const SUCCESS_UPDATE_PROFILE_MODAL = $("#success-update-profile-modal");
        const DETAIL_STORE_MODAL = $("#detail-store-modal");
        const DETAIL_STORE_CONTENT_MODAL = $("#detail-store-content-modal");
        const UPDATE_PROFILE_FORM = $("#update-profile-form");

        const EDIT_PROFILE_BTN = $("#edit-profile");
        const CONFIRM_UPDATE_PROFILE_BTN = $("#confirm-update-profile");
        const CANCEL_UPDATE_PROFILE_BTN = $("#cancel-update-profile");
        const CHANGE_STORES_BTN = $("#change-stores-btn");

        const STORE_ID_SELECTED = $("#store-id-selected");
        const PAYMENT_URL = $("#payment-url");
        const QR_CODE_IMG = $("#qr-code-img");
        const COPY_PAYMENT_URL_BTN = $("#copy-payment-url");
        const MY_STORES_BOX = $("#my-stores-box");


        /**
         *  processes modals
         */
        //
        function showChangeStoresModal() {
            $(CHANGE_STORES_MODAL).modal('show');
        }

        function closeDetailModal() {
            $(DETAIL_STORE_MODAL).modal('hide');
        }

        function confirmUpdateProfile(elm) {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                $(CONFIRM_UPDATE_PROFILE_MODAL).modal('show');
            }
        }
        /**
         *  end processes modals
         */



        /**
         *  function processes other events
         */

        // go to mode edit
        function editProfile(elm) {
            $(".editable").attr("readonly", false).attr("disabled", false);
            $(EDIT_PROFILE_BTN).css('cssText', 'display: none !important;');
            $(CONFIRM_UPDATE_PROFILE_BTN).removeClass('d-none');
            $(CANCEL_UPDATE_PROFILE_BTN).removeClass('d-none');
            $(CHANGE_STORES_BTN).removeClass('d-none');
            $(CONFIRM_UPDATE_PROFILE_BTN).text('{{ __('common.button.submit') }}');

            if (MY_ROLE_NAME === ROLES_NAME.administrator) {
                $('#my-role').attr("disabled", false);
                $('#my-role').parent().find('button').removeClass("disabled");
            } else {
                $('#my-role').attr("disabled", true);
            }
        }

        function updateProfile() {
            if ($(UPDATE_PROFILE_FORM).valid()) {
                let formData = $(UPDATE_PROFILE_FORM).serializeArray();
                myStoreIds.map(storeId => {
                    formData.push({name: 'store_ids[]', value: storeId});
                });

                $.ajax({
                    url: "{{ route('merchant.setting.profile.update_profile') }}",
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
                        toastr.error(PROCESS_FAILED_MSG_COMMON);
                    }
                }).always(function (xhr) {
                    $(CONFIRM_UPDATE_PROFILE_MODAL).modal('hide');
                });
            }
        }

        function getDetailStore() {
            let merchantStoreId = $(STORE_ID_SELECTED).val();
            console.log(merchantStoreId,  'store_id222222222222');
            let url = '{{ route("merchant.merchant-store.detail.get", ":merchantStoreId") }}';
                url = url.replace(':merchantStoreId', merchantStoreId);

            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                dataType: 'json',
                data: {}
            }).done(function (response) {
                $(DETAIL_STORE_CONTENT_MODAL).html(response.data)
                $('.scroll-y').css('overflow-y','auto')
                $(DETAIL_STORE_MODAL).modal('show');

            }).fail(function (err) {
                $(DETAIL_STORE_MODAL).modal('hide');
            }).always(function (xhr) {
            });

        }

        function cancelUpdateProfile() {
            window.location.reload()
        }

        function getPaymentURL() {
            let store_id = $(STORE_ID_SELECTED).val();
            // debugger
            console.log(myStores, 'MY_STORES_bottom')
            let store = myStores.find(item => {
                return item.id == store_id
            })
            return store?.payment_url || ''
        }

        function copyPaymentURL() {
            let payment_url = $(PAYMENT_URL).val();
            let temp = $("<input>");
            $("body").append(temp);
            temp.val(payment_url).select();
            document.execCommand("copy");
            temp.remove();
        }

        function showPaymentURL() {
            let payment_url = getPaymentURL();
            $(PAYMENT_URL).val(payment_url)
        }

        function showPaymentInfo() {
            showPaymentURL();
            generateQrCode()
        }

        function generateQrCode() {
            let  payment_url = getPaymentURL();
            if (payment_url == '') {
                $('#qr-code-label').removeClass('title-qr');
                $('#qr-code-label').addClass('align-items-start');
                $(QR_CODE_IMG).text("{{ __('merchant.setting.profile.not_QR') }}");
            } else {
                $('#qr-code-label').addClass('title-qr');
                $('#qr-code-label').removeClass('align-items-start');
                $(QR_CODE_IMG).empty();
                $(QR_CODE_IMG).qrcode({
                    text: payment_url,
                    size: 250,
                    mode: 0,
                    render: 'canvas',
                });
            }
        }

        function downloadQrCode() {
            let link = document.createElement('a');
            link.download = 'qr_code.png';
            link.href = ($('#qr-code-img canvas')[0]).toDataURL("image/png");
            link.click();
        }

        function changeStores(elm, store_id) {
            let checked = $(elm).is(":checked");
            if (checked) {
                // if (!myStoreIds.includes(store_id)) {
                //     myStoreIds.push(store_id)
                // }
                $(elm).parent().addClass('selected')
            } else {
                // myStoreIds = myStoreIds.filter(item => {
                //     return item != store_id
                // });
                $(elm).parent().removeClass('selected')
            }
        }

        function renderMyStores(elm, store_id) {
            let html = '';
            ALL_MERCHANT_STORES.forEach(store => {
                if (myStoreIds.includes(store.id)) {
                    html += `
                         <p class="members-item">${store.name}</p>
                        <div class="line-item"></div>
                    `
                }
            })
            $(MY_STORES_BOX).html(html);
        }

        function confirmChangeStores(elm, store_id) {
            $(CHANGE_STORES_MODAL).modal('hide');
            myStoreIds = [];
            $(".item-store-select").each(function (index, item) {
                if ($(this).is(":checked")) {
                    myStoreIds.push($(this).val())
                }
            });

            renderMyStores();
        }

        /**
         *  End function processes other events
         */



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
                    merchant_role_id: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "{{ __('admin_epay.setting.profile.validation.name.required') }}",
                    },
                    merchant_role_id: "{{ __('admin_epay.setting.profile.validation.role.required') }}",
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    // error.addClass('col-sm-2 custom-error-box');
                    error.addClass('invalid-feedback');
                    element.closest('.form-item-ip').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
            // $(UPDATE_PROFILE_FORM).valid();

            // show payment url
            showPaymentURL()

            // generateQrCode url
            generateQrCode()
    });
    </script>

@endpush
