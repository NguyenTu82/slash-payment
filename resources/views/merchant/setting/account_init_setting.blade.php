@extends('merchant.layouts.base', ['title' => __('common.setting.profile.account_init_setting')])
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/admin_epay/css/merchant.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <style>
        .white-space-nowrap {
            white-space: nowrap;
        }

        .mt-84 {
            margin-top: 84px;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-md-12 pl-0">
                <div class="account bg-white mt-20 pr-30">
                    @include('merchant.setting.navbar')
                </div>

                <div class="form-container merchant-regist-page ">
                    <form class="" id="edit-merchant" method="post"
                        action="{{ route('merchant.setting.account_init_setting.post', ['id' => $dataMerchant->id]) }}">
                        <input type="hidden" class="form-control bg-white" name="total_transaction_amount"
                            value="{{ $dataMerchant->cashPayment ? $dataMerchant->cashPayment['total_transaction_amount'] : '' }}">
                        <input type="hidden" class="form-control bg-white" name="account_balance"
                            value="{{ $dataMerchant->cashPayment ? $dataMerchant->cashPayment['account_balance'] : '' }}">
                        <input type="hidden" class="form-control bg-white" name="paid_balance"
                            value="{{ $dataMerchant->cashPayment ? $dataMerchant->cashPayment['paid_balance'] : '' }}">
                        <div class="row ml-0">
                            <div class="col-lg-6 pl-0 tab-content" style="padding-right: 40px;" id="nav-tabContent">
                                <h4 class="title-merchant">{{ __('common.setting.profile.account_init_setting') }}</h4>
                                <div class="profile-box">
                                    <div class="row">
                                        {{-- box left --}}
                                        <div class="col-12">
                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('merchant.withdraw.store') }} *
                                                </label>
                                                <div class="col-md-9 form-item-ip form-note merchant-select-input">
                                                    @if (count($storesAssigned) > 0)
                                                        <input type="text" class="form-control form-control-w335" id="merchant_store_id"
                                                               name="merchant_store_input"
                                                               value="{{ formatAccountId($dataMerchant->merchant_code) }} - {{ $dataMerchant->name }}">
                                                        <input type="hidden" name="merchant_store_id" value="{{ $dataMerchant->id }}">
                                                    @else
                                                        <input type="text" class="form-control form-control-w335" value=""
                                                               id="merchant_store_id" name="merchant_store_input">
                                                        <input type="hidden" name="merchant_store_id" value="">
                                                    @endif
                                                    <button type="button" class="btn form-save"
                                                            data-toggle="modal" data-target="#selectMerchant">
                                                        {{ __('merchant.setting.profile.choose_store') }}
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item form-status-id">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.id') }}
                                                </label>
                                                <div
                                                    class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                                    <input type="text" class="form-control form-control-w200"
                                                        name="merchant_code" id="name"
                                                        value="{{ old('merchant_code') ?? formatAccountId($dataMerchant->merchant_code) }}"
                                                        disabled>
                                                </div>
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{__("admin_epay.merchant.info.now_status")}}
                                                </label>
                                                <div
                                                    class="col-sm-3 form-item-ip form-note select_search form-select-option-status margin-left-custom">
                                                    <select
                                                        class="form-control select_list select_option form-control-w128 "
                                                        id="status" name="status">
                                                        <option
                                                            value="{{ App\Enums\MerchantStoreStatus::TEMPORARILY_REGISTERED->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::TEMPORARILY_REGISTERED->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.temporarily_registered') }}
                                                        </option>
                                                        <option
                                                            value="{{ App\Enums\MerchantStoreStatus::UNDER_REVIEW->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::UNDER_REVIEW->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.under_review') }}</option>
                                                        <option value="{{ App\Enums\MerchantStoreStatus::IN_USE->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::IN_USE->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.in_use') }}</option>
                                                        <option value="{{ App\Enums\MerchantStoreStatus::SUSPEND->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::SUSPEND->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.suspend') }}</option>
                                                        <option
                                                            value="{{ App\Enums\MerchantStoreStatus::WITHDRAWAL->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::WITHDRAWAL->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.withdrawal') }}</option>
                                                        <option
                                                            value="{{ App\Enums\MerchantStoreStatus::FORCED_WITHDRAWAL->value }}"
                                                            @if (App\Enums\MerchantStoreStatus::FORCED_WITHDRAWAL->value == $dataMerchant->status) selected @endif>
                                                            {{ __('admin_epay.merchant.status.forced_withdrawal') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.name') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" name="name" id="name"
                                                        value="{{ old('name') ?? $dataMerchant->name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.service_name') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" id="service_name"
                                                        name="service_name"
                                                        value="{{ old('service_name') ?? $dataMerchant->service_name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.industry') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" id="industry"
                                                        name="industry"
                                                        value="{{ old('industry') ?? $dataMerchant->industry }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.representative_name') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" id="representative_name"
                                                        name="representative_name"
                                                        value="{{ old('representative_name') ?? $dataMerchant->representative_name }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item merchant-select-input-button">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.post_code') }}*
                                                </label>
                                                <div class="col-md-9 form-item-ip form-note merchant-select-input">
                                                    <input type="text" class="form-control form-control-w335"
                                                        name="post_code_id" id="post_code_id"
                                                        value="{{ old('post_code_id') ?? $dataMerchant->postCodeId ? $dataMerchant->postCodeId['code'] : '' }}"
                                                        placeholder="0000000">
                                                    <input type="hidden" class="form-control form-control-w335"
                                                        name="post_code_id_value" id="post_code_id_value"
                                                        value="{{ old('post_code_id') ?? $dataMerchant->postCodeId ? $dataMerchant->postCodeId['id'] : '' }}">
                                                    <button
                                                        onclick="confirmPostCodeButton('post_code_id','address','post_code_id_value')"
                                                        type="button" class="btn form-save"> {{ __('common.search') }}
                                                    </button>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.address') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" id="address"
                                                        name="address"
                                                        value="{{ old('address') ?? $dataMerchant->address }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.info.phone_number') }}*
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control" id="phone"
                                                        name="phone" value="{{ old('phone') ?? $dataMerchant->phone }}"
                                                        placeholder="000-0000-0000">
                                                </div>
                                            </div>

                                            <h4 class="title-merchant">
                                                <u>{{ __('admin_epay.merchant.common.contract_payment_info') }}</u>
                                            </h4>
                                            <div class="profile-box">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group row form-item form-group-two-item">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom">
                                                                {{ __('admin_epay.merchant.payment_info.contract_date') }}*
                                                            </label>
                                                            <div
                                                                class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191">
                                                                <div class="input-group date form-control-date-w191">
                                                                    <div class="input_date">
                                                                        <input id="contract_date" type="text"
                                                                            placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="contract_date"
                                                                            class="form-control"
                                                                            value="{{ old('contract_date') ?? \Carbon\Carbon::parse($dataMerchant->contract_date)->format('Y/m/d') }}" />
                                                                        <label for="contract_date">
                                                                            <img class="img-date-search mx-auto icon"
                                                                                src="../../../../../dashboard/img/date.svg" alt="">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-2 col-form-label label-custom text-end col-form-label-date">
                                                                {{ __('admin_epay.merchant.payment_info.termination_date') }}
                                                            </label>
                                                            <div class="col-sm-3 form-item-ip form-note">
                                                                <div class="input-group date form-control-date-w191">
                                                                    <div class="input_date">
                                                                        <input id="termination_date" type="text"
                                                                            placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="termination_date"
                                                                            class="form-control"
                                                                            value="{{ old('termination_date') ?? \Carbon\Carbon::parse($dataMerchant->termination_date)->format('Y/m/d') }}" />
                                                                        <label for="termination_date">
                                                                            <img class="img-date-search mx-auto icon"
                                                                                src="../../../../../dashboard/img/date.svg" alt="">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row form-item form-group-two-item">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom">
                                                                {{ __('admin_epay.merchant.payment_info.contract_interest_rate') }}
                                                            </label>
                                                            <div
                                                                class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note percent-contain">
                                                                <input type="text"
                                                                    class="form-control form-control-date-w191"
                                                                    id="contract_interest_rate"
                                                                    name="contract_interest_rate"
                                                                    value="{{ old('contract_interest_rate') ?? $dataMerchant->contract_interest_rate }}">
                                                                <span class="percent-custom">%</span>
                                                            </div>
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom text-end">
                                                                {{ __('admin_epay.merchant.payment_info.payment_cycle') }}
                                                            </label>
                                                            <div class="col-sm-2 form-item-ip form-note form-control-w128">
                                                                <select class="form-control form-control-w128"
                                                                    id="payment_cycle" name="payment_cycle">
                                                                    <option value="0"
                                                                        @if ($dataMerchant->payment_cycle == 0) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_cycle.end_3_days') }}
                                                                    </option>
                                                                    <option value="1"
                                                                        @if ($dataMerchant->payment_cycle == 1) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_cycle.end_week') }}
                                                                    </option>
                                                                    <option value="2"
                                                                        @if ($dataMerchant->payment_cycle == 2) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_cycle.end_month') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row form-item">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom">
                                                            </label>
                                                            <div class="col-sm-9 form-item-ip form-note">
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.payment_cycle.des1') }}</p>
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.payment_cycle.des2') }}</p>
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.payment_cycle.des3') }}</p>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row form-item">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom">
                                                                {{ __('admin_epay.merchant.payment_info.payment_currency') }}*
                                                            </label>
                                                            <div class="col-sm-9 form-item-ip form-note">
                                                                <select class="form-control" id="withdraw_method"
                                                                    name="withdraw_method">
                                                                    <option
                                                                        value="{{ App\Enums\MerchantPaymentType::FIAT->value }}"
                                                                        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::FIAT->value) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_type.fiat') }}
                                                                    </option>
                                                                    <option
                                                                        value="{{ App\Enums\MerchantPaymentType::CRYPTO->value }}"
                                                                        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CRYPTO->value) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_type.crypto') }}
                                                                    </option>
                                                                    <option
                                                                        value="{{ App\Enums\MerchantPaymentType::CASH->value }}"
                                                                        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CASH->value) selected @endif>
                                                                        {{ __('admin_epay.merchant.payment_type.cash') }}
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row form-item">
                                                            <label for=""
                                                                class="col-sm-3 col-form-label label-custom">
                                                            </label>
                                                            <div
                                                                class="col-sm-9 form-item-ip form-note white-space-custom">
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.withdraw_method.des1') }}</p>
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.withdraw_method.des2') }}</p>
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.withdraw_method.des3') }}</p>
                                                                <p class="mb-0">{{ __('merchant.setting.account_init_setting.withdraw_method.des4') }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-0 tab-content tab-content-option" id="nav-tabContent">
                                <div class="profile-box">
                                    <div class="row">
                                        {{-- box right --}}
                                        <div class="col-12">
                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.other_info.delivery_report') }}
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <div class="form-item-ip form-note mr-10">
                                                        <div
                                                            class="custom-control custom-switch custom-switch-md form-control-w91">
                                                            <input type="checkbox" class="custom-control-input"
                                                                id="delivery_report_status" name="delivery_report_status"
                                                                @if (!is_null($dataMerchant->delivery_report)) checked @endif>
                                                            <label class="custom-control-label"
                                                                for="delivery_report_status"></label>
                                                        </div>
                                                    </div>
                                                    <div class="d-none" id="delivery_report_flag">
                                                        <select class="form-control text-input form-control-w399"
                                                            name="delivery_report" id="delivery_report">
                                                            <option value="1"
                                                                @if ($dataMerchant->delivery_report == 1) selected @endif>
                                                                {{ __('admin_epay.merchant.delivery_report.day') }}
                                                            </option>
                                                            <option value="2"
                                                                @if ($dataMerchant->delivery_report == 2) selected @endif>
                                                                {{ __('admin_epay.merchant.delivery_report.week') }}
                                                            </option>
                                                            <option value="3"
                                                                @if ($dataMerchant->delivery_report == 3) selected @endif>
                                                                {{ __('admin_epay.merchant.delivery_report.month') }}
                                                            </option>
                                                            <option value="4"
                                                                @if ($dataMerchant->delivery_report == 4) selected @endif>
                                                                {{ __('admin_epay.merchant.delivery_report.cycle') }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note white-space-custom">
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.delivery_report.des1') }}</p>
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.delivery_report.des2') }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for=""
                                                    class="col-sm-3 col-form-label label-custom label-h52">
                                                    {{ __('admin_epay.merchant.other_info.delivery_email_address') }}
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <input type="text" class="form-control mb-3"
                                                        id="delivery_email_address" name="delivery_email_address"
                                                        value="{{ old('delivery_email_address') ?? $dataMerchant->delivery_email_address1 }}">
                                                    <input type="text" class="form-control mb-3"
                                                        id="delivery_email_address2" name="delivery_email_address2"
                                                        value="{{ old('delivery_email_address2') ?? $dataMerchant->delivery_email_address2 }}">
                                                    <input type="text" class="form-control"
                                                        id="delivery_email_address3" name="delivery_email_address3"
                                                        value="{{ old('delivery_email_address3') ?? $dataMerchant->delivery_email_address3 }}">
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.other_info.guidance_email') }}
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note">
                                                    <div class="custom-control custom-switch custom-switch-md">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="guidance_email"
                                                            @if ($dataMerchant->guidance_email == 1) checked @endif
                                                            name="guidance_email">
                                                        <label class="custom-control-label" for="guidance_email"></label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note white-space-custom">
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.guidance_email.des1') }}</p>
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.guidance_email.des2') }}</p>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item form-switch-input">

                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.other_info.sending_detail') }}
                                                </label>
                                                <div class="form-item-ip form-note">
                                                    <div class="custom-control custom-switch custom-switch-md">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="sending_detail" name="sending_detail"
                                                            @if ($dataMerchant->sending_detail == 1) checked @endif>
                                                        <label class="custom-control-label" for="sending_detail"></label>
                                                    </div>
                                                </div>
                                                <label for="" class="col-form-label label-custom mr-15">
                                                    {{ __('admin_epay.merchant.other_info.ship_date') }}
                                                </label>
                                                <div class="col-sm-3 form-item-ip form-note">
                                                    <select class="form-control" id="ship_date" name="ship_date" value="{{old('ship_date')}}">
                                                        <option @if($dataMerchant->ship_date == \App\Enums\MerchantStoreShipDate::END_MONTH->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::END_MONTH->value}}">{{ __('admin_epay.merchant.ship_date.end_month') }}</option>
                                                        <option @if($dataMerchant->ship_date == \App\Enums\MerchantStoreShipDate::EVERY_WEEKEND->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::EVERY_WEEKEND->value}}">{{ __('admin_epay.merchant.ship_date.every_weekend') }}</option>
                                                        <option @if($dataMerchant->ship_date == \App\Enums\MerchantStoreShipDate::END_OTHER_WEEKEND->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::END_OTHER_WEEKEND->value}}">{{ __('admin_epay.merchant.ship_date.every_other_weekend') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                    {{ __('admin_epay.merchant.other_info.ship_address') }}
                                                </label>
                                                <div class=" col-sm-9 form-item-ip form-note form-two-infomation">
                                                    <div class="form-item-ip form-note">
                                                        <input type="text" class="form-control form-control-w91"
                                                            id="ship_post_code_id" name="ship_post_code_id"
                                                            value="{{ old('ship_post_code_id') ?? $dataMerchant->shipPostCodeId ? $dataMerchant->shipPostCodeId['code'] : '' }}"
                                                            placeholder="0000000">
                                                        <input type="hidden" class="form-control form-control-w91"
                                                            id="ship_post_code_id_value" name="ship_post_code_id_value"
                                                            value="{{ old('ship_post_code_id') ?? $dataMerchant->shipPostCodeId ? $dataMerchant->ship_post_code_id : '' }}"
                                                            placeholder="0000000">
                                                    </div>
                                                    <div class="form-item-ip form-note form-note-two-input">
                                                        <input type="text" class="form-control form-control-w399"
                                                            id="ship_address" name="ship_address"
                                                            value="{{ old('ship_address') ?? $dataMerchant->ship_address }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group row form-item">
                                                <label for="" class="col-sm-3 col-form-label label-custom">
                                                </label>
                                                <div class="col-sm-9 form-item-ip form-note white-space-custom">
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.ship_post_code_id.des1') }}</p>
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.ship_post_code_id.des2') }}</p>
                                                    <p class="mb-0">{{ __('merchant.setting.account_init_setting.ship_post_code_id.des3') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row ml-0">
                            <div class="col-lg-6 pl-0 tab-content" style="padding-right: 40px;" id="nav-tabContent">
                                <div class="profile-box">
                                    <div class="row">
                                        {{-- box left --}}
                                        <div class="col-12">
                                            {{-- fiat --}}
                                            <div id="fiat" class="d-block">
                                                <input type="hidden" class="form-control"
                                                    name="fiat_withdrawn_account_id"
                                                    value="{{ $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['id'] : '' }}">
                                                <p class="text-left">
                                                    {{ __('admin_epay.merchant.fiat_payment.title') }}</p>
                                                <div class="form-group row form-item form-group-two-item">
                                                    <label class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.fiat_payment.bank_code') }}*
                                                    </label>
                                                    <div
                                                        class="form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-w62">
                                                        <input type="text" class="form-control form-control-w62"
                                                            name="bank_code" id="bank_code"
                                                            value="{{ old('bank_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_code'] : '' }}"
                                                            placeholder="0000">
                                                        @if (!empty($dataMerchant->fiatWithdrawAccount))
                                                            <input type="hidden" class="form-control" name="bank_code"
                                                                id="bank_code"
                                                                value="{{ old('bank_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_code'] : '' }}">
                                                        @endif
                                                    </div>
                                                    <label class="col-sm-3 label-control-89 text-end">
                                                        {{ __('admin_epay.merchant.fiat_payment.financial_institution_name') }}*
                                                    </label>
                                                    <div class="col-sm-2 form-item-ip form-note">
                                                        <input type="hidden" class="form-control"
                                                            name="financial_institution_name"
                                                            id="financial_institution_name_value"
                                                            value="{{ old('financial_institution_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['financial_institution_name'] : '' }}">
                                                        <input type="text" class="form-control form-control-w319"
                                                            name="financial_institution_name"
                                                            id="financial_institution_name"
                                                            value="{{ old('financial_institution_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['financial_institution_name'] : '' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row form-item form-group-two-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.fiat_payment.branch_code') }}*
                                                    </label>
                                                    <div
                                                        class="form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-w62">
                                                        <input type="text" class="form-control form-control-w62"
                                                            name="branch_code" id="branch_code"
                                                            value="{{ old('branch_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_code'] : '' }}"
                                                            placeholder="0000">
                                                        @if (!empty($dataMerchant->fiatWithdrawAccount))
                                                            <input type="hidden" class="form-control" name="branch_code"
                                                                id="branch_code"
                                                                value="{{ old('branch_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_code'] : '' }}">
                                                        @endif
                                                    </div>
                                                    <label class="col-sm-3 label-control-89 text-end">
                                                        {{ __('admin_epay.merchant.fiat_payment.branch_name') }}*
                                                    </label>
                                                    <div class="col-sm-2 form-item-ip form-note">
                                                        <input type="hidden" class="form-control" name="branch_name"
                                                            id="branch_name_value"
                                                            value="{{ old('branch_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_name'] : '' }}">
                                                        <input type="text" class="form-control form-control-w319"
                                                            id="branch_name"
                                                            value="{{ old('branch_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_name'] : '' }}"
                                                            disabled>
                                                    </div>
                                                </div>
                                                <div class="form-group row form-item form-group-two-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_type') }}*
                                                    </label>
                                                    <div
                                                        class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                                        <select class="form-control form-control-date-w191"
                                                            id="bank_account_type" name="bank_account_type">
                                                            <option value="1"
                                                                @if ($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 1)  @endif>
                                                                {{ __('admin_epay.merchant.bank_account_type.usually') }}
                                                            </option>
                                                            <option value="2"
                                                                @if ($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 2)  @endif>
                                                                {{ __('admin_epay.merchant.bank_account_type.regular') }}
                                                            </option>
                                                            <option value="3"
                                                                @if ($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 3)  @endif>
                                                                {{ __('admin_epay.merchant.bank_account_type.current') }}
                                                            </option>
                                                        </select>
                                                        @if (!empty($dataMerchant->fiatWithdrawAccount))
                                                            <input type="hidden" class="form-control"
                                                                id="bank_account_type"
                                                                value="{{ old('bank_account_type') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_type'] : '' }}">
                                                        @endif
                                                    </div>
                                                    <label for=""
                                                        class="col-sm-3 col-form-label label-custom text-end">
                                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_number') }}*
                                                    </label>
                                                    <div class="col-sm-2 form-item-ip form-note">
                                                        <input type="text" class="form-control form-control-w128"
                                                            name="bank_account_number" id="bank_account_number"
                                                            value="{{ old('bank_account_number') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_number'] : '' }}"
                                                            placeholder="00000000">
                                                        @if (!empty($dataMerchant->fiatWithdrawAccount))
                                                            <input type="hidden" class="form-control"
                                                                id="bank_account_number"
                                                                value="{{ old('bank_account_number') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_number'] : '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="form-group row form-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_holder') }}*
                                                    </label>
                                                    <div class="col-sm-9 form-item-ip form-note">
                                                        <input type="text" class="form-control"
                                                            name="bank_account_holder" id="bank_account_holder"
                                                            value="{{ old('bank_account_holder') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_holder'] : '' }}">
                                                        @if (!empty($dataMerchant->fiatWithdrawAccount))
                                                            <input type="hidden" class="form-control"
                                                                id="bank_account_holder"
                                                                value="{{ old('bank_account_holder') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_holder'] : '' }}">
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pl-0 tab-content tab-content-option" id="nav-tabContent">
                                <div class="profile-box">
                                    <div class="row">
                                        {{-- box right --}}
                                        <div class="col-12">
                                            {{-- crypto --}}
                                            <div id="crypto" class="d-block">
                                                <input type="hidden" class="form-control"
                                                    name="crypto_withdrawn_account_id"
                                                    value="{{ $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['id'] : '' }}">
                                                <p class="text-left">
                                                    {{ __('admin_epay.merchant.crypto_payment.title') }}</p>
                                                <div class="form-group row form-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.crypto_payment.wallet_address') }}*
                                                    </label>
                                                    <div class="col-sm-9 form-item-ip form-note">
                                                        <input type="text" class="form-control" name="wallet_address"
                                                            id="wallet_address"
                                                            value="{{ old('wallet_address') ?? $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['wallet_address'] : '' }}">
                                                        @if (!empty($dataMerchant->cryptoWithdrawAccount))
                                                            <input type="hidden" class="form-control"
                                                                name="wallet_address" id="wallet_address"
                                                                value="{{ old('wallet_address') ?? $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['wallet_address'] : '' }}">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row form-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.crypto_payment.network') }}*
                                                    </label>
                                                    <div class="col-sm-9 form-item-ip form-note">
                                                        <select class="form-control" id="crypto_network"
                                                            name="crypto_network">
                                                            <option value="1"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 1) selected @endif>
                                                                {{ __('Ethereum（ETH）') }}</option>
                                                            <option value="3"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 3) selected @endif>
                                                                {{ __('Polygon（Matic）') }}</option>
                                                            <option value="4"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 4) selected @endif>
                                                                {{ __('Avalanche C-Chain（AVAX）') }}</option>
                                                            <option value="5"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 5) selected @endif>
                                                                {{ __('Fantom（FTM）') }}</option>
                                                            <option value="6"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 6) selected @endif>
                                                                {{ __('Arbitrum One（ETH）') }}</option>
                                                            <option value="7"
                                                                @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 7) selected @endif>
                                                                {{ __('Solana (SOL)') }}</option>
                                                        </select>
                                                        @if (!empty($dataMerchant->cryptoWithdrawAccount))
                                                            <input type="hidden" class="form-control"
                                                                name="crypto_network" id="crypto_network"
                                                                value="{{ $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['network'] : '' }}">
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="form-group row form-item">
                                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                                        {{ __('admin_epay.merchant.crypto_payment.note') }}
                                                    </label>
                                                    <div class="col-sm-9 form-item-ip form-note">
                                                        <textarea class="form-control height-control" id="note"
                                                            name="note" rows="4">{{ $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['note'] : '' }}</textarea>
                                                    </div>
                                                </div>

                                                <div class="form-group row form-item form-action mt-84">
                                                    <label for=""
                                                        class="col-sm-3 col-form-label label-custom"></label>
                                                    <div class="row col-sm-9 pl-0 mr-0 pr-0">
                                                        <div class="button-action">
                                                            <div class="btn-w500">
                                                                <button type="submit"
                                                                    class="btn btn-edit-detail form-save" id="merchant">
                                                                    {{ __('common.button.edit') }}
                                                                </button>
                                                                <a
                                                                    href="{{ route('merchant.dashboard.index.get', $dataMerchant->id) }}">
                                                                    <button type="button"
                                                                        class="btn form-close form-back">
                                                                        {{ __('common.button.back') }}
                                                                    </button>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @csrf
                    </form>
                </div>
            </div>
            @include('common.modal.merchant_store_validate', [
                'title' => __('入力チェックのエラー'),
                'submit_btn' => __('admin_epay.merchant.common.rewrite'),
            ])
            @include('common.modal.confirm', [
                'title' => __('加盟店の編集'),
                'description' => __('加盟店を編集します。よろしいですか?'),
                'submit_btn' => __('common.button.submit'),
            ])
            @include('merchant.withdraw.request.partial.select_merchant', [
                'stores' => $storesAssigned,
                'init' => true,
            ])
        </div>
    </div>
@endsection

@push('script')
    <script>
        let inputStep3 = ["af_id", "af_name", "af_rate"]
        let validateFiat = ["bank_code", "financial_institution_name", "branch_code", "branch_name", "bank_account_type",
            "bank_account_type", "bank_account_number", "bank_account_holder"
        ]
        let validateCash = ["total_transaction_amount", "account_balance", "paid_balance"]
        let validateCrypto = ["wallet_address", "crypto_network"]
        @if ($dataMerchant->af_switch)
            $("#afSwitchStatus").show();
        @endif
        @if (!is_null($dataMerchant->delivery_report))
            $("#delivery_report_flag").removeClass("d-none");
        @endif
        const confirmPostCode = async (element, address, value) => {
            return new Promise((resolve, reject) => {
                let post_code_id = $(`#${element}`)[0].value;
                $.ajax({
                    type: 'post',
                    url: `{{ route('admin_epay.merchantStore.check_post_code') }}`,
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                        postal_code: post_code_id
                    },
                    success: function(response) {
                        if (response.status) {
                            let data = JSON.parse(response?.dataPostal?.json)
                            $(`#${address}`).val(data[0].addressKanji)
                            $(`#${value}`).val(response?.dataPostal?.id)
                            $(`#${element}`).removeClass('border-error')
                            $(`#${element}-error`).find('.error').hide();
                            resolve();
                        } else {
                            $(`#${element}`).addClass('border-error');
                            $(`#${address}`).val("")
                            $(`#${value}`).val("")
                            $(`#${element}-error`).find('.error').show();
                            if (element == 'post_code_id') {
                                $(`#${element}-error`).find('.error').html(
                                    "{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}"
                                )
                            }
                            if (element == 'ship_post_code_id') {
                                $(`#${element}-error`).find('.error').html(
                                    "{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}"
                                )
                            }
                            reject();
                        }
                    }
                })
            });
        }
        const confirmPostCodeButton = async (element, address, value) => {
            let post_code_id = $(`#${element}`)[0].value;
            $.ajax({
                type: 'post',
                url: `{{ route('admin_epay.merchantStore.check_post_code') }}`,
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    postal_code: post_code_id
                },
                success: function(response) {
                    if (response.status) {
                        let data = JSON.parse(response?.dataPostal?.json)
                        $(`#${address}`).val(data[0].addressKanji)
                        $(`#${value}`).val(response?.dataPostal?.id)
                        $(`#${element}`).removeClass('border-error')
                        $(`#${element}-error`).find('.error').hide();
                    } else {
                        $(`#${element}`).addClass('border-error');
                        $(`#${address}`).val("")
                        $(`#${value}`).val("")
                        $(`#${element}-error`).find('.error').show();
                        toastr.options.escapeHtml = false;
                        toastr.options.closeButton = false;
                        toastr.options.closeDuration = 0;
                        toastr.options.extendedTimeOut = 500;
                        toastr.options.timeOut = 4000;
                        toastr.options.tapToDismiss = false;
                        toastr.options.positionClass = 'toast-top-center custom-toast';
                        if (element == 'post_code_id') {
                            $(`#${element}-error`).find('.error').html(
                                "{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}"
                            )
                            toastr.error(
                                "{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}"
                            );
                        }
                        if (element == 'ship_post_code_id') {
                            $(`#${element}-error`).find('.error').html(
                                "{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}"
                            )
                            toastr.error(
                                "{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}"
                            );
                        }
                    }
                }
            });
        }
        $('input[name=total_transaction_amount_value]').change((e) => {
            $('input[name=total_transaction_amount]').val(e.target.value)
        })
        $('input[name=account_balance_value]').change((e) => {
            $('input[name=account_balance]').val(e.target.value)
        })
        $('input[name=paid_balance_value]').change((e) => {
            $('input[name=paid_balance]').val(e.target.value)
        })
        const confirmBankCode = async () => {
            // return new Promise((resolve, reject) => {
            let bank_code = $("#bank_code")[0].value;
            let url = `{{ route('admin_epay.bank.check_bank_code') }}`
            $.ajax({
                method: 'POST',
                url: url,
                type: 'POST',
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    bank_code: bank_code
                },
                success: function(response) {
                    if (response.status) {
                        $("#financial_institution_name").val(response.data.name)
                        $("#financial_institution_name_value").val(response.data.name)
                        $(`#bank_code`).removeClass('border-error')
                        $(`#bank_code-error`).find('.error').hide();
                        // resolve();
                    } else {
                        $("#bank_code").addClass('border-error');
                        $(`#financial_institution_name`).val("")
                        $(`#financial_institution_name_value`).val("")
                        $(`#bank_code-error`).find('.error').show();
                        $(`#bank_code-error`).find('.error').html(
                            "{{ __('admin_epay.merchant.validation.bank_code.non_exist') }}")
                        // reject();
                    }
                }
            })
            // });
        }
        const confirmBranchCode = () => {
            return new Promise((resolve, reject) => {
                let bank_code = $("#bank_code")[0].value;
                let branch_code = $("#branch_code")[0].value;
                let url = `{{ route('admin_epay.bank.check_branch_bank') }}`
                $.ajax({
                    method: 'POST',
                    url: url,
                    type: 'POST',
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                        bank_code: bank_code,
                        branch_code: branch_code
                    },
                    success: function(response) {
                        if (response.status) {
                            $("#branch_name_value").val(response.data.name)
                            $("#branch_name").val(response.data.name)
                            $("#branch_code").removeClass('border-error');
                            $(`#branch_code-error`).find('.error').hide();
                            resolve();
                        } else {
                            $("#branch_code").addClass('border-error');
                            $(`#branch_name`).val("")
                            $(`#branch_name_value`).val("")
                            $(`#branch_code-error`).find('.error').show();
                            $(`#branch_code-error`).find('.error').html(
                                "{{ __('admin_epay.merchant.validation.branch_code.non_exist') }}"
                            )
                            reject();
                        }
                    }
                })
            });
        }
        $(document).ready(function() {

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
            const MERCHANT_STORE = $('.merchant-item');
            const EDIT_MERCHANT = $('#edit-merchant');
            const STORE_SELECTED = $('.list-area-members');
            const MERCHANT_SELECTED = $('.form-note-textarea');
            $("#submit-form").click(() => {
                EDIT_MERCHANT[0].submit();
            });

            MERCHANT_STORE.on('click', function() {
                STORE_SELECTED.children().remove();
                $('input[name=group]').val('');
                $('input[name=group_id]').val('');
                let array = []
                $('.merchant-list input:checked').each(function() {
                    let name = $(this).data('name');
                    $('input[name=group]').val(name);
                    array = [...array, $(this)[0].value]
                    $('input[name=group_id]').val(JSON.stringify(array));
                    STORE_SELECTED.append(
                        `<p class="members-item">${name}</p><div class="line-item"></div>`);
                });

                if ($('input:checked').length > 0) {
                    MERCHANT_SELECTED.find('.border-error').removeClass('border-error');
                    MERCHANT_SELECTED.find('.note-pass-error').html('');
                }
            });
            $('#ship_date').datepicker(COMMON_DATEPICKER);
            $('#contract_date').datepicker(COMMON_DATEPICKER);
            $('#termination_date').datepicker(COMMON_DATEPICKER);
            $('#afSwitch').change(function() {
                if ($('#afSwitch').is(":checked")) {
                    $("#afSwitchStatus").show();
                    $('#myForm').rules('add', {
                        af_id: {
                            required: true,
                        },
                        af_name: {
                            required: true,
                        },
                        af_rate: {
                            required: true,
                        }
                    })
                } else {
                    $("#afSwitchStatus").hide();
                    inputStep3.forEach(value => {
                        $('#myForm').rules('remove', value)
                        $(`#${value}-error`).find('.error').remove();
                    })
                }
            });
            $('#delivery_report_status').change(function() {
                if ($('#delivery_report_status').is(":checked")) {
                    $("#delivery_report_flag").removeClass("d-none");
                } else {
                    $("#delivery_report_flag").addClass("d-none");
                }
            });
            $('#withdraw_method').change(function() {
                if ($('#withdraw_method')[0].value ==
                    "{{ \App\Enums\MerchantPaymentType::CRYPTO->value }}") {
                    $('#crypto').show()
                    $('#fiat').hide()
                    $('#cash').hide()
                    $('#bank_code').removeClass('border-error')
                    $('#branch_code').removeClass('border-error')
                    $('#bank_account_number').removeClass('border-error')
                    $('#bank_account_holder').removeClass('border-error')
                    validateFiat.forEach(value => {
                        if (value == 'bank_code') {
                            $(`#${value}`).rules('remove', "checkBankCode")
                        }
                        if (value == 'branch_code') {
                            $(`#${value}`).rules('remove', "checkBranchCode")
                        }
                        if (value == 'bank_account_holder') {
                            $(`#${value}`).rules('remove', "checkKatakana")
                        }
                        $(`#${value}-error`).find('.error').remove();
                        if (value !== 'bank_code' && value !== 'branch_code') {
                            $(`#${value}`).rules('remove', "required")
                        }
                    })
                    validateCash.forEach(value => {
                        $(`#${value}`).rules('remove', "required")
                        $(`#${value}-error`).find('.error').remove();
                    })
                    $('#wallet_address').rules('add', {
                        required: true,
                    })
                    $('#crypto_network').rules('add', {
                        required: true,
                    })
                }
                if ($('#withdraw_method')[0].value ==
                    "{{ App\Enums\MerchantPaymentType::FIAT->value }}") {
                    $('#crypto').hide()
                    $('#fiat').show()
                    $('#cash').hide()
                    validateCrypto.forEach(value => {
                        $(`#${value}`).rules('remove', "required")
                        $('#wallet_address').removeClass('border-error')
                    })
                    validateCash.forEach(value => {
                        $(`#${value}`).rules('remove', "required")
                        $(`#${value}-error`).find('.error').remove();
                    })
                    $('#bank_code').rules('add', {
                        checkBankCode: true,
                    })
                    $('#financial_institution_name').rules('add', {
                        required: true,
                    })
                    $('#branch_code').rules('add', {
                        checkBranchCode: true,
                    })
                    $('#branch_name').rules('add', {
                        required: true,
                    })
                    $('#bank_account_number').rules('add', {
                        required: true,
                    })
                    $('#bank_account_holder').rules('add', {
                        required: true,
                        checkKatakana: true
                    })
                }
                if ($('#withdraw_method')[0].value ==
                    "{{ App\Enums\MerchantPaymentType::CASH->value }}") {
                    $('#crypto').hide()
                    $('#fiat').hide()
                    $('#cash').show()
                    $('#bank_code').removeClass('border-error')
                    $('#branch_code').removeClass('border-error')
                    $('#bank_account_number').removeClass('border-error')
                    $('#bank_account_holder').removeClass('border-error')
                    validateCrypto.forEach(value => {
                        $(`#${value}`).rules('remove', "required")
                        $('#wallet_address').removeClass('border-error')
                    })
                    validateFiat.forEach(value => {
                        if (value == 'bank_code') {
                            $(`#${value}`).rules('remove', "checkBankCode")
                        }
                        if (value == 'branch_code') {
                            $(`#${value}`).rules('remove', "checkBranchCode")
                        }
                        if (value == 'bank_account_holder') {
                            $(`#${value}`).rules('remove', "checkKatakana")
                        }
                        $(`#${value}-error`).find('.error').remove();
                        if (value !== 'bank_code' && value !== 'branch_code') {
                            $(`#${value}`).rules('remove', "required")
                        }
                    })
                }
            });
            $(function() {
                $.validator.addMethod("checkCode", async function(value, element, options) {
                    if (value) {
                        if (/^\d{1,8}$/.test(value)) {
                            await confirmPostCode('post_code_id', 'address',
                                    'post_code_id_value')
                                .then(result => {})
                                .catch(error => {})
                        } else {
                            $(`#address`).val("")
                            $(`#post_code_id_value`).val("")
                            $(`#post_code_id`).addClass('border-error')
                            $(`#post_code_id-error`).find('.error').show();
                            $(`#post_code_id-error`).find('.error').html(
                                "{{ __('admin_epay.merchant.validation.post_code_id.format') }}"
                            )
                        }
                        if ($('#post_code_id').hasClass('border-error')) {
                            return false
                        }
                        return true
                    } else {
                        $(`#address`).val("")
                        $(`#post_code_id_value`).val("")
                        $(`#post_code_id`).removeClass('border-error')
                        $(`#post_code_id-error`).find('.error').hide();
                        return true;
                    }
                }, "");
                $.validator.addMethod("checkShipCode", async function(value, element, options) {
                    if (value) {
                        if (/^\d{1,8}$/.test(value)) {
                            await confirmPostCode('ship_post_code_id', 'ship_address',
                                    'ship_post_code_id_value')
                                .then(result => {})
                                .catch(error => {})
                        } else {
                            $(`#address`).val("")
                            $(`#ship_post_code_id_value`).val("")
                            $(`#ship_post_code_id`).addClass('border-error')
                            $(`#ship_post_code_id-error`).find('.error').show();
                            $(`#ship_post_code_id-error`).find('.error').html(
                                "{{ __('admin_epay.merchant.validation.ship_post_code_id.format') }}"
                            )
                        }
                        if ($('#ship_post_code_id').hasClass('border-error')) {
                            return false
                        }
                        return true
                    } else {
                        $(`#ship_address`).val("")
                        $(`#ship_post_code_id_value`).val("")
                        $(`#ship_post_code_id`).removeClass('border-error')
                        $(`#ship_post_code_id-error`).find('.error').hide();
                        return true;
                    }

                }, "");

                $.validator.addMethod("checkBankCode", async function(value, element, options) {
                    if (value) {
                        await confirmBankCode()
                            .then(result => {})
                            .catch(error => {})
                        if ($('#bank_code').hasClass('border-error')) {
                            return false
                        }
                        return true
                    } else {
                        $("#bank_code").addClass('border-error');
                        $(`#financial_institution_name`).val("")
                        $(`#financial_institution_name_value`).val("")
                        $(`#bank_code-error`).find('.error').show();
                        $(`#bank_code-error`).find('.error').html(
                            "{{ __('admin_epay.merchant.validation.bank_code.required') }}"
                        )
                        return false;
                    }
                }, "");
                $.validator.addMethod("checkBranchCode", async function(value, element, options) {
                    if (value) {
                        await confirmBranchCode()
                            .then(result => {})
                            .catch(error => {})
                        if ($('#branch_code').hasClass('border-error')) {
                            return false
                        }
                        return true
                    } else {
                        $("#branch_code").addClass('border-error');
                        $(`#branch_name`).val("")
                        $(`#branch_name_value`).val("")
                        $(`#branch_code-error`).find('.error').show();
                        $(`#branch_code-error`).find('.error').html(
                            "{{ __('admin_epay.merchant.validation.branch_code.required') }}"
                        )
                        return false;
                    }
                }, "");
                EDIT_MERCHANT.validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        service_name: {
                            required: true,
                        },
                        industry: {
                            required: true,
                        },
                        representative_name: {
                            required: true,
                        },
                        post_code_id: {
                            checkCode: true,
                        },
                        address: {
                            required: true,
                        },
                        phone: {
                            required: true,
                        },
                        // email: {
                        //     required: true,
                        //     email: true,
                        // },
                        // password: {
                        //     required: true,
                        // },
                        // contract_wallet: {
                        //     required: true,
                        // },
                        // receiving_walletaddress: {
                        //     required: true,
                        // },
                        // received_virtua_type: {
                        //     required: true,
                        // },
                        // auth_token: {
                        //     required: true,
                        // },
                        // hash_token: {
                        //     required: true,
                        // },
                        // ship_date: {
                        //     required: true,
                        // },
                        ship_post_code_id: {
                            checkShipCode: true,
                        },
                        // ship_address: {
                        //     required: true,
                        // },
                        // delivery_email_address: {
                        //     required: true,
                        // },
                        // delivery_report: {
                        //     required: true,
                        // },
                        contract_date: {
                            required: true,
                        },
                        // termination_date: {
                        //     required: true,
                        // },
                        // contract_interest_rate: {
                        //     required: true,
                        // },
                        wallet_address: {
                            // required: true,
                        },
                        crypto_network: {},
                        bank_code: {
                            checkBankCode: true
                        },
                        financial_institution_name: {},
                        branch_code: {
                            checkBranchCode: true,
                        },
                        branch_name: {},
                        bank_account_number: {
                            required: true,
                        },
                        bank_account_holder: {
                            required: true,
                            checkKatakana: true
                        },
                        // total_transaction_amount: {
                        //     required: true,
                        // },
                        // account_balance: {
                        //     required: true,
                        // },
                        // paid_balance: {
                        //     required: true,
                        // },
                        // af_id: {
                        //     required: true,
                        // },
                        // af_name: {
                        //     required: true,
                        // },
                        // af_rate: {
                        //     required: true,
                        // }
                    },
                    messages: {
                        name: {
                            required: "{{ __('admin_epay.merchant.validation.name.required') }}",
                        },
                        group: {
                            required: "{{ __('admin_epay.merchant.validation.group.required') }}",
                        },
                        service_name: {
                            required: "{{ __('admin_epay.merchant.validation.service_name.required') }}",
                        },
                        industry: {
                            required: "{{ __('admin_epay.merchant.validation.industry.required') }}",
                        },
                        representative_name: {
                            required: "{{ __('admin_epay.merchant.validation.representative_name.required') }}",
                        },
                        post_code_id: {
                            required: "{{ __('admin_epay.merchant.validation.post_code_id.required') }}",
                        },
                        address: {
                            required: "{{ __('admin_epay.merchant.validation.address.required') }}",
                        },
                        phone: {
                            required: "{{ __('admin_epay.merchant.validation.phone.required') }}",
                        },
                        email: {
                            required: "{{ __('admin_epay.merchant.validation.email.required') }}",
                            email: "{{ __('validation.common.email.format') }}",
                        },
                        password: {
                            required: "{{ __('admin_epay.merchant.validation.password.required') }}",
                        },
                        contract_wallet: {
                            required: "{{ __('admin_epay.merchant.validation.contract_wallet.required') }}",
                        },
                        receiving_walletaddress: {
                            required: "{{ __('admin_epay.merchant.validation.receiving_walletaddress.required') }}",
                        },
                        received_virtua_type: {
                            required: "{{ __('admin_epay.merchant.validation.received_virtua_type.required') }}",
                        },
                        auth_token: {
                            required: "{{ __('admin_epay.merchant.validation.auth_token.required') }}",
                        },
                        hash_token: {
                            required: "{{ __('admin_epay.merchant.validation.hash_token.required') }}",
                        },
                        ship_date: {
                            required: "{{ __('admin_epay.merchant.validation.ship_date.required') }}",
                        },
                        ship_post_code_id: {
                            required: "{{ __('admin_epay.merchant.validation.ship_post_code_id.required') }}",
                        },
                        ship_address: {
                            required: "{{ __('admin_epay.merchant.validation.ship_address.required') }}",
                        },
                        delivery_email_address: {
                            required: "{{ __('admin_epay.merchant.validation.delivery_email_address.required') }}",
                        },
                        delivery_report: {
                            required: "{{ __('admin_epay.merchant.validation.delivery_report.required') }}",
                        },
                        contract_date: {
                            required: "{{ __('admin_epay.merchant.validation.contract_date.required') }}",
                        },
                        termination_date: {
                            required: "{{ __('admin_epay.merchant.validation.termination_date.required') }}",
                        },
                        contract_interest_rate: {
                            required: "{{ __('admin_epay.merchant.validation.contract_interest_rate.required') }}",
                        },
                        wallet_address: {
                            required: "{{ __('admin_epay.merchant.validation.crypto_wallet_address.required') }}",
                        },
                        crypto_network: {
                            required: "{{ __('admin_epay.merchant.validation.crypto_network.required') }}",
                        },
                        bank_code: {
                            required: "{{ __('admin_epay.merchant.validation.bank_code.required') }}",
                        },
                        financial_institution_name: {
                            required: "{{ __('admin_epay.merchant.validation.financial_institution_name.required') }}",
                        },
                        branch_code: {
                            required: "{{ __('admin_epay.merchant.validation.branch_code.required') }}",
                        },
                        branch_name: {
                            required: "{{ __('admin_epay.merchant.validation.branch_name.required') }}",
                        },
                        bank_account_number: {
                            required: "{{ __('admin_epay.merchant.validation.bank_account_number.required') }}",
                        },
                        bank_account_holder: {
                            required: "{{ __('admin_epay.merchant.validation.bank_account_holder.required') }}",
                            checkKatakana: "{{ __('admin_epay.merchant.validation.bank_account_holder.checkKatakana') }}",
                        },
                        total_transaction_amount: {
                            required: "{{ __('admin_epay.merchant.validation.total_transaction_amount.required') }}",
                        },
                        account_balance: {
                            required: "{{ __('admin_epay.merchant.validation.account_balance.required') }}",
                        },
                        paid_balance: {
                            required: "{{ __('admin_epay.merchant.validation.paid_balance.required') }}",
                        },
                        af_id: {
                            required: "{{ __('admin_epay.merchant.validation.af_id.required') }}",
                        },
                        af_name: {
                            required: "{{ __('admin_epay.merchant.validation.af_name.required') }}",
                        },
                        af_rate: {
                            required: "{{ __('admin_epay.merchant.validation.af_rate.required') }}",
                        }
                    },
                    errorElement: 'p',
                    errorPlacement: function(error, element) {
                        console.log('validate');
                        const name = $(element).attr('name');
                        $(`#${name}-error`).find('.error').remove();
                        $(`#${name}-error`).append(error);
                    },
                    highlight: function(element) {
                        $(element).addClass('border-error');
                    },
                    unhighlight: function(element) {
                        const name = $(element).attr('name');
                        if (name !== 'post_code_id' && name !== 'ship_post_code_id' && name !==
                            'bank_code' && name !== 'branch_code') {
                            $(`#${name}-error`).find('.error').remove();
                            $(element).removeClass('border-error');
                        }
                    },
                    submitHandler: function() {
                        if ($('#bank_code').hasClass('border-error') || $('#branch_code')
                            .hasClass('border-error') || $('#post_code_id').hasClass(
                                'border-error') || $('#ship_post_code_id').hasClass(
                                'border-error')) {
                            $('#merchant-validate-modal').modal('show')
                            $('.modal-backdrop').show();
                        } else {
                            $('#confirm-modal').modal('show')
                            $('#merchant-validate-modal').modal('hide')
                            $('.modal-backdrop').show();
                        }
                    },
                    invalidHandler: function(event, validator) {
                        // Xử lý khi form có trường không hợp lệ
                        $('#merchant-validate-modal').modal('show')
                    }
                });
                $('#fiat').hide()
                @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::FIAT->value)
                    $('#fiat').show()
                    $('#bank_code').rules('add', {
                        checkBankCode: true,
                    })
                    $('#financial_institution_name').rules('add', {
                        required: true,
                    })
                    $('#branch_code').rules('add', {
                        checkBranchCode: true,
                    })
                    $('#branch_name').rules('add', {
                        required: true,
                    })
                    $('#bank_account_number').rules('add', {
                        required: true,
                    })
                    $('#bank_account_holder').rules('add', {
                        required: true,
                        checkKatakana: true
                    })
                @endif
                @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CRYPTO->value)
                    $('#crypto').show()
                    $('#wallet_address').rules('add', {
                        required: true,
                    })
                    $('#crypto_network').rules('add', {
                        required: true,
                    })
                @endif
                @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CASH->value)
                    $('#cash').show()
                @endif
            })
        });

        const validateInput = () => {
            var inputValue = document.getElementById("af_rate").value;
            if (
                (event.key >= 0 && event.key <= 9) || // Numbers
                event.key === "." || // Decimal point
                event.key === "Backspace" // Backspace key
            ) {
                if (event.key === "." && inputValue.includes(".")) {
                    event.preventDefault();
                }
                var afterInputValue = inputValue + event.key;
                if (parseFloat(afterInputValue) > 100 || afterInputValue == "100.") {
                    event.preventDefault();
                }

                if (afterInputValue.includes(".") && (afterInputValue.split(".")[1]).length > 1 && event.key !=
                    "Backspace") {
                    event.preventDefault();
                }
            } else {
                event.preventDefault();
            }
        }

        var receive_crypto_type_check = @json($dataMerchant->slashApi['receive_crypto_type']);
        console.log("receive_crypto_type_check", receive_crypto_type_check)
        if (receive_crypto_type_check === 'JPYC') {
            console.log(1);
            $('#crypto_network option[value="5"]').hide();
            $('#crypto_network option[value="7"]').hide();
        }
    </script>
@endpush
