@extends('epay.layouts.base', ['title' => __('admin_epay.merchant.common.merchant_detail')])
@section('title', __('admin_epay.merchant.common.merchant_detail'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/admin_epay/css/merchant.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
@endpush
{{-- @section('merchant_cash')
    <div class="setting-page page-merchant-store-header ">
        <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
            <label for="" class="text-right col-form-label label-custom">
                {{ __('admin_epay.merchant.cash_payment.total_transaction_amount') }}
            </label>
            <div class="form-item-ip form-note">
                <input type="text" class="form-control form-control-header bg-white" disabled value="{{old('total_transaction_amount_value') ?? $dataMerchant->cashPayment ? $dataMerchant->cashPayment["total_transaction_amount"]:""}}" name="total_transaction_amount_value" id="total_transaction_amount"  required>
            </div>
        </div>
        <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
            <label for="" class="text-right col-form-label label-custom">
                {{ __('admin_epay.merchant.cash_payment.account_balance') }}
            </label>
            <div class="form-item-ip form-note">
                <input type="text" class="form-control form-control-header bg-white" disabled value="{{old('account_balance_value') ?? $dataMerchant->cashPayment ? $dataMerchant->cashPayment["account_balance"]:""}}" name="account_balance_value" id="account_balance" required>
            </div>
        </div>
        <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
            <label for="" class="text-right col-form-label label-custom">
                {{ __('admin_epay.merchant.cash_payment.paid_balance') }}
            </label>
            <div class="form-item-ip form-note">
                <input type="text" class="form-control form-control-header bg-white" disabled value="{{old('paid_balance_value') ?? $dataMerchant->cashPayment ? $dataMerchant->cashPayment["paid_balance"]:""}}" name="paid_balance_value" id="paid_balance"  required>
            </div>
        </div>
    </div>
@endsection --}}
@section('content')
    <section id="stepper1" class="content setting-page" style="padding-left: 0px !important">
        <!--step's content-->
        <div class="account bg-white mt-20">
            @include('epay.merchantStore.navbar', ['route' => 'merchant', 'id' => $dataMerchant->id])
        </div>
        <div class="form-container merchant-regist-page ">
            <div class="row ml-0">
                <div class="col-lg-6 pl-0 tab-content" style="padding-right: 40px;" id="nav-tabContent">
                    <h4 class="title-merchant">{{ __('admin_epay.merchant.common.merchant_detail') }}</h4>
                    <div class="profile-box">
                        <div class="row">
                            {{-- box left --}}
                            <div class="col-12">
                                <div class="form-group row form-item form-status-id">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.id') }}
                                    </label>
                                    <div
                                        class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                        <input type="text" class="form-control form-control-w200" name="merchant_code"
                                            id="name"
                                            value="{{ old('merchant_code') ?? formatAccountId($dataMerchant->merchant_code) }}"
                                            disabled>
                                    </div>
                                    <label for=""
                                        class="col-sm-4 text-right col-form-label label-custom text-select-status text-end">
                                        {{ __('admin_epay.merchant.info.status') }}
                                    </label>
                                    <div
                                        class="col-sm-2 form-control-w91 form-item-ip form-note select_search form-select-option-status ">
                                        @if (App\Enums\MerchantStoreStatus::TEMPORARILY_REGISTERED->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.temporarily_registered') }}">
                                        @elseif(App\Enums\MerchantStoreStatus::UNDER_REVIEW->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.under_review') }}">
                                        @elseif(App\Enums\MerchantStoreStatus::IN_USE->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.in_use') }}">
                                        @elseif(App\Enums\MerchantStoreStatus::SUSPEND->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.suspend') }}">
                                        @elseif(App\Enums\MerchantStoreStatus::WITHDRAWAL->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.withdrawal') }}">
                                        @elseif(App\Enums\MerchantStoreStatus::FORCED_WITHDRAWAL->value == $dataMerchant->status)
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="{{ __('admin_epay.merchant.status.forced_withdrawal') }}">
                                        @else
                                            <input type="text" class="form-control form-control-w91" disabled
                                                value="">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.name') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" name="name" id="name" disabled
                                            value="{{ old('name') ?? $dataMerchant->name }}">
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.service_name') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="service_name" name="service_name"
                                            disabled value="{{ old('service_name') ?? $dataMerchant->service_name }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.industry') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="industry" name="industry" disabled
                                            value="{{ old('industry') ?? $dataMerchant->industry }}" required>
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.representative_name') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="representative_name" disabled
                                            name="representative_name"
                                            value="{{ old('representative_name') ?? $dataMerchant->representative_name }}"
                                            required>
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.address') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note form-two-infomation">
                                        <div class="form-item-ip form-note">
                                            <input type="text" class="form-control form-control-w91" name="post_code_id"
                                                id="post_code_id" disabled
                                                value="{{ old('post_code_id') ?? $dataMerchant->postCodeId ? $dataMerchant->postCodeId['code'] : '' }}"
                                                required>
                                        </div>
                                        <div class="form-item-ip form-note form-note-two-input">
                                            <input type="text" class="form-control form-control-w399" id="address"
                                                name="address" disabled
                                                value="{{ old('address') ?? $dataMerchant->address }}" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.phone_number') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            disabled value="{{ old('phone') ?? $dataMerchant->phone }}" required>
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.register_email') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            disabled
                                            value="{{ $dataMerchant->merchantOwner ? $dataMerchant->merchantOwner['email'] : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.password') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="phone" name="phone"
                                            disabled value="{{ $dataMerchant->merchantOwner ? '***********' : '' }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row form-item merchant-select-input-button">
                                    <label for="group" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.group') }}
                                    </label>
                                    <div class="col-md-9 form-item-ip form-note ">
                                        <div class="form-control list-area-members list-area-members-w500 disable">
                                            @foreach ($dataMerchant->groups as $value)
                                                <p class="members-item">{{ $value->name }}</p>
                                                <div class="line-item"></div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom"
                                        style="line-height: 16px">
                                        {{ __('admin_epay.merchant.info.contract_wallet1') }}<br>{{ __('admin_epay.merchant.info.contract_wallet2') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip">
                                        <input type="text" class="form-control" name="contract_wallet"
                                            id="contract_wallet"
                                            title="{{ old('contract_wallet') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['contract_wallet'] : '' }}"
                                            disabled
                                            value="{{ old('contract_wallet') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['contract_wallet'] : '' }}">
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom"
                                        style="line-height: 16px">
                                        {{ __('admin_epay.merchant.info.received_wallet1') }}<br>{{ __('admin_epay.merchant.info.received_wallet2') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip">
                                        <input type="text" class="form-control" name="receiving_walletaddress"
                                            id="receiving_walletaddress"
                                            title="{{ old('receiving_walletaddress') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['receive_wallet_address'] : '' }}"
                                            disabled
                                            value="{{ old('receiving_walletaddress') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['receive_wallet_address'] : '' }}">
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.virtual_currency_type') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip">
                                        @if ($dataMerchant->slashApi && $dataMerchant->slashApi['receive_crypto_type'] == 'USDT')
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('USDT') }}">
                                        @elseif($dataMerchant->slashApi && $dataMerchant->slashApi['receive_crypto_type'] == 'USDC')
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('USDC') }}">
                                        @elseif($dataMerchant->slashApi && $dataMerchant->slashApi['receive_crypto_type'] == 'DAI')
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('DAI') }}">
                                        @elseif($dataMerchant->slashApi && $dataMerchant->slashApi['receive_crypto_type'] == 'JPYC')
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('JPYC') }}">
                                        @else
                                            <input type="text" class="form-control" disabled value="    ">
                                        @endif
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.auth_token') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="auth_token" name="auth_token"
                                            disabled
                                            value="{{ old('auth_token') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['slash_auth_token'] : '' }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.hash_token') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="hash_token" name="hash_token"
                                            disabled
                                            value="{{ old('hash_token') ?? $dataMerchant->slashApi ? $dataMerchant->slashApi['slash_hash_token'] : '' }}"
                                            required>
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.info.payment_url') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control" id="payment_url" name="payment_url"
                                            disabled
                                            value="{{ old('payment_url') ?? $dataMerchant->payment_url ? $dataMerchant->payment_url : '' }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-0 tab-content tab-content-option" id="nav-tabContent">
                    <h4 class="title-merchant"><u>{{ __('admin_epay.merchant.common.contract_payment_info') }}</u></h4>
                    <div class="profile-box">
                        <div class="row">
                            {{-- box left --}}
                            <div class="col-12">
                                <div class="form-group row form-item form-group-two-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.payment_info.contract_date') }}*
                                    </label>
                                    <div
                                        class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191">
                                        <div class="input-group date form-control-date-w191">
                                            <input type="text" class="form-control" disabled name="contract_date"
                                                id="contract_date"
                                                value="{{ old('contract_date') ?? ($dataMerchant->contract_date ? \Carbon\Carbon::parse($dataMerchant->contract_date)->format('Y/m/d') : '') }}" />
                                        </div>
                                    </div>
                                    <label for=""
                                        class="col-sm-2 col-form-label label-custom text-end col-form-label-date">
                                        {{ __('admin_epay.merchant.payment_info.termination_date') }}
                                    </label>
                                    <div class="col-sm-3 form-item-ip form-note form-control-date-w191">
                                        <div class="input-group date form-control-date-w191">
                                            <input type="text" class="form-control" disabled name="termination_date"
                                                id="termination_date"
                                                value="{{ old('termination_date') ?? ($dataMerchant->termination_date ? \Carbon\Carbon::parse($dataMerchant->termination_date)->format('Y/m/d') : '') }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row form-item form-group-two-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.payment_info.contract_interest_rate') }}
                                    </label>
                                    <div
                                        class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                        <input type="text" class="form-control form-control-date-w191"
                                            id="contract_interest_rate" disabled name="contract_interest_rate"
                                            value="{{ old('contract_interest_rate') ?? ($dataMerchant->contract_interest_rate ? $dataMerchant->contract_interest_rate . '%' : '') }}">
                                    </div>
                                    <!-- <label for="" class="col-sm-1 form-item-ip form-note"> -->
                                    </label>
                                    <label for="" class="col-sm-3 col-form-label label-custom text-end  pr-24 ">
                                        {{ __('admin_epay.merchant.payment_info.payment_cycle') }}
                                    </label>
                                    <div class="col-sm-2 form-item-ip form-note">
                                        @if ($dataMerchant->payment_cycle == 1)
                                            <input type="text" class="form-control form-control-w128" disabled
                                                value="{{ __('admin_epay.merchant.payment_cycle.end_week') }}">
                                        @elseif($dataMerchant->payment_cycle == 2)
                                            <input type="text" class="form-control form-control-w128" disabled
                                                value="{{ __('admin_epay.merchant.payment_cycle.end_month') }}">
                                        @else
                                            <input type="text" class="form-control form-control-w128" disabled
                                                value="{{ __('admin_epay.merchant.payment_cycle.end_3_days') }}">
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.payment_info.payment_currency') }}*
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note merchant-select-input">
                                        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::FIAT->value)
                                            <input type="text" class="form-control form-control-w311" disabled
                                                value="{{ __('admin_epay.merchant.payment_type.fiat') }}">
                                            <button class="height-auto btn form-save btn-primary btn-show_payment_modal"
                                                id="show_payment_modal">{{ __('admin_epay.merchant.common.show_payee_information') }}</button>
                                        @elseif($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CRYPTO->value)
                                            <input type="text" class="form-control form-control-w311" disabled
                                                value="{{ __('admin_epay.merchant.payment_type.crypto') }}">
                                            <button class="height-auto btn form-save btn-primary btn-show_payment_modal"
                                                id="show_payment_modal">{{ __('admin_epay.merchant.common.show_payee_information') }}</button>
                                        @elseif($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CASH->value)
                                            <input type="text" class="form-control form-control-w311" disabled
                                                value="{{ __('admin_epay.merchant.payment_type.cash') }}">
                                        @else
                                            <input type="text" class="form-control form-control-w311" disabled
                                                value="">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="title-merchant"><u>{{ __('admin_epay.merchant.common.merchant_other_info') }}</u></h4>
                    <div class="profile-box">
                        <div class="row">
                            {{-- box left --}}
                            <div class="col-12">
                                <div class="form-group row form-item form-switch-input">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.other_info.sending_detail') }}
                                    </label>
                                    <div class="form-item-ip form-note">
                                        <div class="custom-control custom-switch custom-switch-md">
                                            <input type="checkbox" class="custom-control-input" id="sending_detail"
                                                disabled name="sending_detail"
                                                @if ($dataMerchant->sending_detail == 1) checked @endif ">
                                                <label class="custom-control-label" for="sending_detail"></label>
                                            </div>
                                        </div>
                                        <label for="" class="col-form-label label-custom mr-15">
                                            {{ __('admin_epay.merchant.other_info.ship_date') }}
                                        </label>
                                        <div class="col-sm-3 form-item-ip form-note">
                                            <select disabled class="form-control" id="ship_date" name="ship_date" value="{{old('ship_date')}}">
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
                                        <div class= "col-sm-9 form-item-ip form-note form-two-infomation">
                                            <div class="form-item-ip form-note">
                                                <input type="text" class="form-control form-control-w91" id="ship_post_code_id" name="ship_post_code_id" disabled value="{{ old('ship_post_code_id') ?? $dataMerchant->shipPostCodeId ? $dataMerchant->shipPostCodeId['code'] : '' }}"  required>
                                            </div>
                                            <div class="form-item-ip form-note form-note-two-input">
                                                <input type="text" class="form-control form-control-w399" id="ship_address" name="ship_address" disabled value="{{ old('ship_address') ?? $dataMerchant->ship_address }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.delivery_report') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <div class="form-item-ip form-note mr-10">
                                                <div class="custom-control custom-switch custom-switch-md form-control-w91">
                                                    <input disabled type="checkbox" class="custom-control-input" id="delivery_report_status" name="delivery_report_status"
                                                    @if (!is_null($dataMerchant->delivery_report)) checked @endif>
                                                    <label class="custom-control-label" for="delivery_report_status"></label>
                                                </div>
                                            </div>
                                            <div class="d-none" id="delivery_report_flag">
                                                 @if ($dataMerchant->delivery_report == 1)
                                            <input class="form-control form-control-w399" type="text" disabled
                                                value="{{ __('admin_epay.merchant.delivery_report.day') }}">
                                        @elseif($dataMerchant->delivery_report == 2)
                                            <input class="form-control form-control-w399" type="text" disabled
                                                value="{{ __('admin_epay.merchant.delivery_report.week') }}">
                                        @elseif($dataMerchant->delivery_report == 3)
                                            <input class="form-control form-control-w399" type="text" disabled
                                                value="{{ __('admin_epay.merchant.delivery_report.month') }}">
                                        @elseif($dataMerchant->delivery_report == 4)
                                            <input class="form-control form-control-w399" type="text" disabled
                                                value="{{ __('admin_epay.merchant.delivery_report.cycle') }}">
                                        @else
                                            <input class="form-control form-control-w399" type="text" disabled
                                                value="">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom label-h52">
                                        {{ __('admin_epay.merchant.other_info.delivery_email_address') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <input type="text" class="form-control mb-3" id="delivery_email_address"
                                            disabled name="delivery_email_address"
                                            value="{{ old('delivery_email_address') ?? $dataMerchant->delivery_email_address1 }}"
                                            required>
                                        <input type="text" class="form-control mb-3" id="delivery_email_address2"
                                            disabled name="delivery_email_address2"
                                            value="{{ old('delivery_email_address2') ?? $dataMerchant->delivery_email_address2 }}">
                                        <input type="text" class="form-control" id="delivery_email_address3" disabled
                                            name="delivery_email_address3"
                                            value="{{ old('delivery_email_address3') ?? $dataMerchant->delivery_email_address3 }}">
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.other_info.guidance_email') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <div class="custom-control custom-switch custom-switch-md">
                                            <input type="checkbox" class="custom-control-input" disabled
                                                id="guidance_email" @if ($dataMerchant->guidance_email == 1) checked @endif
                                                name="guidance_email">
                                            <label class="custom-control-label" for="guidance_email"></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h4 class="title-merchant"><u>{{ __('admin_epay.merchant.common.af_info') }}</u></h4>
                    <div class="profile-box">
                        <div class="row">
                            {{-- box left --}}
                            <div class="col-12">
                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{ __('admin_epay.merchant.affiliate_info.info') }}
                                    </label>
                                    <div class="col-sm-9 form-item-ip form-note">
                                        <div class="custom-control custom-switch custom-switch-md">
                                            <input type="checkbox" disabled class="custom-control-input" name="afSwitch"
                                                id="afSwitch" @if ($dataMerchant->af_switch) checked @endif>
                                            <label class="custom-control-label" for="afSwitch"></label>
                                        </div>
                                    </div>
                                </div>
                                @if ($dataMerchant->af_switch)
                                    <div>
                                        <div class="form-group row form-item form-group-two-item-input">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.affiliate_info.id') }} </label>

                                            <div class="col-sm-3 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_id" name="af_id"
                                                    value="{{ $dataMerchant->affiliate_id }}" disabled>
                                                <input type="hidden" class="form-control" id="afId" name="afId"
                                                    value="{{ $dataMerchant->affiliate_id }}" disabled>
                                            </div>
                                            <!-- <div class="col-sm-1 form-item-ip form-note">
                                            </div>
                                            <label for="" class="col-sm-3 col-form-label label-custom" style="max-width: none">
                                                {{ __('admin_epay.merchant.affiliate_info.fee') }}
                                            </label>
                                            <div class="col-sm-2 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_rate" name="af_rate" value="{{ $dataMerchant->af_fee }}" disabled>
                                            </div> -->
                                        </div>
                                        <div class="form-group row form-item form-group-two-item-input">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.affiliate_info.name') }}
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_name" name="af_name"
                                                    value="{{ $dataMerchant->af_name }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row form-item form-group-two-item-input">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.affiliate_info.fee') }}
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_rate" name="af_rate"
                                                    value="{{ $dataMerchant->af_fee ? $dataMerchant->af_fee.'%' : '' }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ml-0 row-button-action">
                <div class="col-lg-6 pl-0 tab-content button-two-form" id="nav-tabContent">
                    <div class="profile-box">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group row form-item form-action">
                                    <label for="" class="col-sm-3 col-form-label label-custom"></label>
                                    <div class="row col-sm-9 pl-0 mr-0 pr-0">
                                        <div class="button-action">
                                            <div class="btn-w500">
                                                <a class="rule rule_epay_merchant_edit"
                                                    href="{{ route('admin_epay.merchantStore.view_edit', $dataMerchant->id) }}">
                                                    <button type="submit" class="btn btn-edit-detail form-save"
                                                        id="merchant">
                                                        {{ __('common.button.edit') }}
                                                    </button>
                                                </a>
                                                <a class="rule rule_epay_merchant_list"
                                                    href="{{ route('admin_epay.merchantStore.index.get') }}">
                                                    <button type="button" class="btn form-close form-back">
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
                <div class="col-lg-6 pl-0 tab-content" id="nav-tabContent">
                    <div class="profile-box">
                        <div class="row row-delete">
                            <div class="col-12">
                                <div class="form-group row form-item">
                                    <div class="rule rule_epay_merchant_delete button-action button-action-delete">
                                        <button data-target="#confirm-modal-delete" type="button"
                                            class="btn btn-delete form-submit"
                                            id="delete-account">{{ __('common.delete') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal result --}}
        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::FIAT->value)
            <div class="modal fade common-modal common-modal-confirm" id="payment-modal" aria-hidden="true"
                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body confirmm">
                            <h1 class="modal-title title r12">
                                {{ __('admin_epay.merchant.fiat_payment.title') }}
                            </h1>
                            <div id="fiat">
                                <div class="form-group d-flex form-item">
                                    <label for="" class="form-label label-custom">
                                        {{ __('admin_epay.merchant.fiat_payment.financial_institution_name') }}
                                    </label>
                                    <div class="form-item-ip form-note mr-3 w3">
                                        <input type="text" class="form-control" id="financial_institution_name"
                                            disabled
                                            value="{{ old('financial_institution_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['financial_institution_name'] : '' }}"
                                            required>
                                    </div>
                                    <label for="" class="form-label label-custom mr-2 w11">
                                        {{ __('admin_epay.merchant.fiat_payment.bank_code') }}
                                    </label>
                                    <div class="form-item-ip form-note w6">
                                        <input type="text" class="form-control" name="bank_code" id="bank_code"
                                            disabled
                                            value="{{ old('bank_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_code'] : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group d-flex form-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('admin_epay.merchant.fiat_payment.branch_name') }}
                                    </label>
                                    <div class="form-item-ip form-note mr-3 w3">
                                        <input type="text" class="form-control" id="branch_name" disabled
                                            value="{{ old('branch_name') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_name'] : '' }}"
                                            required>
                                    </div>
                                    <label for="" class="col-form-label label-custom mr-2 w11">
                                        {{ __('admin_epay.merchant.fiat_payment.branch_code') }}
                                    </label>
                                    <div class="form-item-ip form-note w6">
                                        <input type="text" class="form-control" name="branch_code" disabled
                                            id="branch_code"
                                            value="{{ old('branch_code') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['branch_code'] : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group d-flex form-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_type') }}
                                    </label>
                                    <div class="form-item-ip form-note mr-3 w3">
                                        @if ($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 1)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('admin_epay.merchant.bank_account_type.usually') }}">
                                        @elseif($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 2)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('admin_epay.merchant.bank_account_type.regular') }}">
                                        @elseif($dataMerchant->fiatWithdrawAccount && $dataMerchant->fiatWithdrawAccount['bank_account_type'] == 3)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('admin_epay.merchant.bank_account_type.current') }}">
                                        @else
                                            <input type="text" class="form-control" disabled value="">
                                        @endif
                                    </div>
                                    <label for="" class="col-form-label label-custom mr-2 w8">
                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_number') }}
                                    </label>
                                    <div class="form-item-ip form-note w95">
                                        <input type="text" class="form-control" disabled name="bank_account_number"
                                            id="bank_account_number"
                                            value="{{ old('bank_account_number') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_number'] : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group d-flex form-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('admin_epay.merchant.fiat_payment.bank_account_holder') }}
                                    </label>
                                    <div class="form-item-ip form-note w5">
                                        <input type="text" class="form-control" disabled name="bank_account_holder"
                                            id="bank_account_holder"
                                            value="{{ old('bank_account_holder') ?? $dataMerchant->fiatWithdrawAccount ? $dataMerchant->fiatWithdrawAccount['bank_account_holder'] : '' }}"
                                            required>
                                    </div>
                                </div>
                            </div>
                            <div class="modalFooter btn-confirm">
                                <button type="button" class="btn btn-yes" data-bs-dismiss="modal" id="return-btn"
                                    style="background: #F3F3F3; color: #6A707E; border:none">{{ __('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if ($dataMerchant->withdraw_method == App\Enums\MerchantPaymentType::CRYPTO->value)
            <div class="modal fade common-modal common-modal-confirm" id="payment-modal" aria-hidden="true"
                aria-labelledby="exampleModalToggleLabel" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body confirmm">
                            <h1 class="modal-title title">
                                {{ __('admin_epay.merchant.crypto_payment.title') }}
                            </h1>
                            <div id="fiat">
                                <div class="form-group d-flex form-item">
                                    <label for="" class="form-label label-custom">
                                        {{ __('admin_epay.merchant.crypto_payment.network') }}
                                    </label>
                                    <div class="form-item-ip form-note mr-3 w3">
                                        @if ($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 1)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Ethereum（ETH）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 2)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('BNB Chain（BNB）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 3)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Polygon（Matic）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 4)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Avalanche C-Chain（AVAX）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 5)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Fantom（FTM）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 6)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Arbitrum One（ETH）') }}">
                                        @elseif($dataMerchant->cryptoWithdrawAccount && $dataMerchant->cryptoWithdrawAccount['network'] == 7)
                                            <input type="text" class="form-control" disabled
                                                value="{{ __('Solana (SOL)') }}">
                                        @else
                                            <input type="text" class="form-control" disabled value="">
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group d-flex form-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('admin_epay.merchant.crypto_payment.wallet_address') }}
                                    </label>
                                    <div class="form-item-ip form-note w5">
                                        <input type="text" class="form-control" id="wallet_address" disabled
                                            value="{{ $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['wallet_address'] : '' }}"
                                            required>
                                    </div>
                                </div>
                                <div class="form-group d-flex form-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('admin_epay.merchant.crypto_payment.note') }}
                                    </label>
                                    <div class="form-item-ip form-note w5">
                                        <textarea @if (!empty($dataMerchant->cryptoWithdrawAccount)) disabled @endif class="form-control height-control" id="note"
                                            name="note" rows="4">{{ $dataMerchant->cryptoWithdrawAccount ? $dataMerchant->cryptoWithdrawAccount['note'] : '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modalFooter btn-confirm">
                                <button type="button" class="btn btn-yes" data-bs-dismiss="modal" id="return-btn"
                                    style="background: #F3F3F3; color: #6A707E; border:none;">{{ __('common.cancel') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @include('common.modal.confirm_delete', [
            'title' => __('admin_epay.merchant.common.title_confirm_modal_delete'),
            'description' => __('admin_epay.merchant.common.description_confirm_modal_delete'),
            'url' => route('admin_epay.merchantStore.delete', $dataMerchant->id),
            'id' => 'confirm-modal-delete',
        ])
        @include('common.modal.confirm_delete', [
            'title' => __('admin_epay.merchant.common.title_confirm_modal_delete'),
            'description' => __('admin_epay.merchant.common.delete_confirm_group'),
            'url' => route('admin_epay.merchantStore.delete', $dataMerchant->id),
            'id' => 'confirm-modal-group-delete',
        ])
    </section>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#show_payment_modal').click(() => {
                $('#payment-modal').modal("show")
                $('.modal-backdrop').show();
            })
            $('#delete-account').click(() => {
                $.ajax({
                    type: 'post',
                    url: `{{ route('admin_epay.merchantStore.check_group') }}`,
                    data: {
                        _token: $("meta[name='csrf-token']").attr('content'),
                        merchant_id: '{{ $dataMerchant->id }}'
                    },
                    success: function(response) {
                        if (response.status) {
                            $('#confirm-modal-delete').modal('hide')
                            $('#confirm-modal-group-delete').modal('show')
                        } else {
                            $('#confirm-modal-group-delete').modal('hide')
                            $('#confirm-modal-delete').modal('show')
                        }
                    }
                });
            })
            @if (!is_null($dataMerchant->delivery_report))
                $("#delivery_report_flag").removeClass("d-none");
            @endif
        })
    </script>
@endpush
