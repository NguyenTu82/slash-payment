@extends('epay.layouts.base', ['title' => __('admin_epay.merchant.common.merchant_create')])
@section('title', __('admin_epay.merchant.common.merchant_create'))

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
                <input type="text" class="form-control form-control-header bg-white" name="total_transaction_amount_value" id="total_transaction_amount" value="{{old('total_transaction_amount')}}">
            </div>
        </div>
        <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
            <label for="" class="text-right col-form-label label-custom">
                {{ __('admin_epay.merchant.cash_payment.account_balance') }}
            </label>
            <div class="form-item-ip form-note">
                <input type="text" class="form-control form-control-header bg-white"  name="account_balance_value" id="account_balance" value="{{old('account_balance')}}">
            </div>
        </div>
        <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
            <label for="" class="text-right col-form-label label-custom">
                {{ __('admin_epay.merchant.cash_payment.paid_balance') }}
            </label>
            <div class="form-item-ip form-note">
                <input type="text" class="form-control form-control-header bg-white" name="paid_balance_value" id="paid_balance" value="{{old('paid_balance')}}">
            </div>
        </div>
    </div>
@endsection --}}
@section('content')
    <section id="stepper1" class="content setting-page pt-4" style="padding-left: 0px !important">
        <!--step's content-->
        <div class="form-container merchant-regist-page ">
            <form class="" id="create-merchant" method="post" action="{{ route('admin_epay.merchantStore.create') }}">
                {{-- <input type="hidden" class="form-control bg-white" style="height: 42px" name="total_transaction_amount" value="{{old('total_transaction_amount')}}">
                <input type="hidden" class="form-control bg-white" style="height: 42px" name="account_balance" value="{{old('account_balance')}}">
                <input type="hidden" class="form-control bg-white" style="height: 42px" name="paid_balance" value="{{old('paid_balance')}}"> --}}
                <div class="row ml-0">
                    <div class="col-lg-6 pl-0 tab-content" style="padding-right: 40px;" id="nav-tabContent">
                        <h4 class="title-merchant">{{__("admin_epay.merchant.common.merchant_info")}}</h4>
                        <div class="profile-box">
                            <div class="row">
                                {{-- box left --}}
                                <div class="col-12">
                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.name') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="group" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.group') }}
                                        </label>
                                            <div class="col-md-9 form-item-ip form-note merchant-select-input">
                                                <div class="form-control list-area-members">
                                                @if(session()->has('old_group'))
                                                    @foreach(session()->get('old_group') as $value)
                                                        <p class="members-item">{{$value}}</p>
                                                        <div class="line-item"></div>
                                                    @endforeach
                                                @endif
                                                </div>
                                                <div class="merchant-select-option">
                                                    <button type="button" class="btn form-save note-pass note-pass-select" data-toggle="modal" data-target="#selectMerchant">
                                                        {{ __('admin_epay.merchant.common.select_merchant_store') }}
                                                    </button>
                                                    <!-- Modal Select Merchant -->
                                                </div>
                                            </div>
                                            <input type="hidden" id="group" name="group" value="{{old('group')}}">
                                            <input type="hidden" id="group_id" name="group_id" value="{{old('group_id')}}">
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.service_name') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="service_name" name="service_name" value="{{old('service_name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.industry') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="industry" name="industry" value="{{old('industry')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.representative_name') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="representative_name" name="representative_name" value="{{old('representative_name')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.post_code') }}
                                        </label>
                                        <div class="col-md-9 form-item-ip form-note merchant-select-input">
                                            <input type="text" class="form-control form-control-w335" name="post_code_id" id="post_code_id" placeholder="0000000" value="{{old('post_code_id')}}">
                                            <input type="hidden" class="form-control form-control-w335" name="post_code_id_value" id="post_code_id_value" value="{{old('post_code_id_value')}}">
                                            <button onclick="confirmPostCodeButton('post_code_id','address','post_code_id_value')"
                                                    type="button"
                                                    class="btn form-save"
                                                    > {{ __('common.search') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.address') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="address" name="address" value="{{old('address')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.phone_number') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="000-0000-0000" value="{{old('phone')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.register_email') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="email" name="email" value="{{old('email')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.password') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="password" name="password" value="{{old('password')}}">
                                            <p class="noti-input-pass">{{ __('admin_epay.notifications.common.noti_input_password') }}</p>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom" style="line-height: 16px">
                                            {{ __('admin_epay.merchant.info.contract_wallet1') }}<br>{{ __('admin_epay.merchant.info.contract_wallet2') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <input type="text" class="form-control" name="contract_wallet" id="contract_wallet" value="{{old('contract_wallet')}}" placeholder>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom" style="line-height: 16px">
                                            {{ __('admin_epay.merchant.info.received_wallet1') }}<br>{{ __('admin_epay.merchant.info.received_wallet2') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <input type="text" class="form-control" name="receiving_walletaddress" id="receiving_walletaddress" value="{{old('receiving_walletaddress')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.virtual_currency_type') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip">
                                            <select class="form-control" id="received_virtua_type" name="received_virtua_type">
                                                <option @if(old('received_virtua_type') == "USDT") selected @endif value="USDT">{{ __('USDT') }}</option>
                                                <option @if(old('received_virtua_type') == "USDC") selected @endif value="USDC">{{ __('USDC') }}</option>
                                                <option @if(old('received_virtua_type') == "DAI") selected @endif value="DAI">{{ __('DAI') }}</option>
                                                <option @if(old('received_virtua_type') == "JPYC") selected @endif value="JPYC">{{ __('JPYC') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.auth_token') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="auth_token" name="auth_token" value="{{old('auth_token')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.hash_token') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="hash_token" name="hash_token" value="{{old('hash_token')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.info.payment_url') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="payment_url" name="payment_url" value="{{old('payment_url')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 pl-0 tab-content tab-content-option" id="nav-tabContent">
                        <h4 class="title-merchant"><u>{{__('admin_epay.merchant.common.contract_payment_info')}}</u></h4>
                        <div class="profile-box">
                            <div class="row">
                                {{-- box left --}}
                                <div class="col-12">
                                    <div class="form-group row form-item form-group-two-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.payment_info.contract_date') }}*
                                        </label>
                                        <div class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191">
                                            <div class="input-group date form-control-date-w191" >
                                                <input type="text" class="form-control " name="contract_date" id="contract_date" value="{{old('contract_date')}}"/>
                                                <label for="contract_date">
                                                    <span class="input-group-append">
                                                        <img src="/dashboard/img/calendar.svg"
                                                             class=" mx-auto icon" alt="...">
                                                    </span>
                                                </label>
                                            </div>
                                        </div>

                                        <label for="" class="col-sm-2 col-form-label label-custom text-end col-form-label-date">
                                            {{ __('admin_epay.merchant.payment_info.termination_date') }}
                                        </label>
                                        <div class="col-sm-3 form-item-ip form-note">
                                            <div class="input-group date form-control-date-w191" >
                                                <input type="text" class="form-control" name="termination_date" id="termination_date" value="{{old('termination_date')}}"/>
                                                <label for="termination_date">
                                                    <span class="input-group-append">
                                                        <img src="/dashboard/img/calendar.svg"
                                                             class=" mx-auto icon" alt="...">
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item form-group-two-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.payment_info.contract_interest_rate') }}
                                        </label>
                                        <div class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191 percent-contain">
                                            <input type="text" class="form-control form-control-date-w191" id="contract_interest_rate" value="{{old('contract_interest_rate')}}" name="contract_interest_rate">
                                            <span class="percent-custom">%</span>
                                        </div>

                                        <label for="" class="col-sm-3 col-form-label label-custom text-end">
                                            {{ __('admin_epay.merchant.payment_info.payment_cycle') }}
                                        </label>
                                        <div class="col-sm-2 form-item-ip form-note">
                                            <select class="form-control form-control-w128" id="payment_cycle" name="payment_cycle" value="{{old('payment_cycle')}}">
                                                <option @if(old('payment_cycle') == "0") selected @endif value="0">{{ __('admin_epay.merchant.payment_cycle.end_3_days') }}</option>
                                                <option @if(old('payment_cycle') == "1") selected @endif value="1">{{ __('admin_epay.merchant.payment_cycle.end_week') }}</option>
                                                <option @if(old('payment_cycle') == "2") selected @endif value="2">{{ __('admin_epay.merchant.payment_cycle.end_month') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.payment_info.payment_currency') }}*
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <select class="form-control" id="withdraw_method" name="withdraw_method" value="{{old('withdraw_method')}}">
                                                <option @if(old('withdraw_method') == \App\Enums\MerchantPaymentType::FIAT->value) selected @endif value="{{App\Enums\MerchantPaymentType::FIAT->value}}">{{ __('admin_epay.merchant.payment_type.fiat') }}</option>
                                                <option @if(old('withdraw_method') == \App\Enums\MerchantPaymentType::CRYPTO->value) selected @endif value="{{App\Enums\MerchantPaymentType::CRYPTO->value}}">{{ __('admin_epay.merchant.payment_type.crypto') }}</option>
                                                <option @if(old('withdraw_method') == \App\Enums\MerchantPaymentType::CASH->value) selected @endif value="{{App\Enums\MerchantPaymentType::CASH->value}}">{{ __('admin_epay.merchant.payment_type.cash') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    {{-- crypto --}}
                                    <div id="crypto">
                                        <p class="text-left">{{ __('admin_epay.merchant.crypto_payment.title') }}</p>
                                        <div class="form-group row form-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.crypto_payment.wallet_address') }}*
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <input type="text" class="form-control" name="wallet_address" id="wallet_address" value="{{old('wallet_address')}}">
                                            </div>
                                        </div>
                                        <div class="form-group row form-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.crypto_payment.network') }}*
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <select class="form-control" id="crypto_network" name="crypto_network" value="{{old('crypto_network')}}">
                                                    <option @if(old('crypto_network') == "1") selected @endif value="1">{{ __('Ethereum（ETH）') }}</option>
                                                    <option @if(old('crypto_network') == "3") selected @endif value="3">{{ __('Polygon（Matic）') }}</option>
                                                    <option @if(old('crypto_network') == "4") selected @endif value="4">{{ __('Avalanche C-Chain（AVAX）') }}</option>
                                                    <option @if(old('crypto_network') == "5") selected @endif value="5">{{ __('Fantom（FTM）') }}</option>
                                                    <option @if(old('crypto_network') == "6") selected @endif value="6">{{ __('Arbitrum One（ETH）') }}</option>
                                                    <option @if(old('crypto_network') == "7") selected @endif value="7">{{ __('Solana (SOL)') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row form-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.crypto_payment.note') }}
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <textarea class="form-control height-control pt-3" rows=1 name="note" id="note" value="{{old('note')}}"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- fiat --}}
                                    <div id="fiat">
                                        <p class="text-left">{{ __('admin_epay.merchant.fiat_payment.title') }}</p>
                                        <div class="form-group row form-item form-group-two-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_code') }}*
                                            </label>
                                            <div class="form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-w62">
                                                <input type="text" class="form-control form-control-w62" name="bank_code" id="bank_code" placeholder="0000" value="{{old('bank_code')}}">
                                            </div>
                                            <label class="col-sm-3 label-control-89 text-end">
                                                {{ __('admin_epay.merchant.fiat_payment.financial_institution_name') }}*
                                            </label>
                                            <div class="col-sm-2 form-item-ip form-note">
                                                <input type="hidden" class="form-control" name="financial_institution_name" id="financial_institution_name_value" value="{{old('financial_institution_name')}}" >
                                                <input type="text" class="form-control form-control-w319" id="financial_institution_name" value="{{old('financial_institution_name')}}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row form-item form-group-two-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.branch_code') }}*
                                            </label>
                                            <div class="form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-w62">
                                                <input type="text" class="form-control form-control-w62" name="branch_code" id="branch_code" placeholder="0000" value="{{old('branch_code')}}">
                                            </div>
                                            <label class="col-sm-3 label-control-89 text-end">
                                                {{ __('admin_epay.merchant.fiat_payment.branch_name') }}*
                                            </label>
                                            <div class="col-sm-2 form-item-ip form-note">
                                                <input type="hidden" class="form-control" name="branch_name" id="branch_name_value" value="{{old('branch_name')}}" >
                                                <input type="text" class="form-control form-control-w319" id="branch_name" value="{{old('branch_name')}}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row form-item form-group-two-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_account_type') }}*
                                            </label>
                                            <div class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191">
                                                <select class="form-control form-control-date-w191" id="bank_account_type" name="bank_account_type" value="{{old('bank_account_type')}}">
                                                    <option @if(old('bank_account_type') == "1") selected @endif value="1">{{ __('admin_epay.merchant.bank_account_type.usually') }}</option>
                                                    <option @if(old('bank_account_type') == "2") selected @endif value="2">{{ __('admin_epay.merchant.bank_account_type.regular') }}</option>
                                                    <option @if(old('bank_account_type') == "3") selected @endif value="3">{{ __('admin_epay.merchant.bank_account_type.current') }}</option>
                                                </select>
                                                <div class="note-pass" id="bank_account_type-error">
                                                    <p class="error note-pass-error">{{ __('common.error.email_exists') }}</p>
                                                </div>
                                            </div>
                                            <!-- <div class="col-sm-1 form-item-ip form-note">
                                            </div> -->
                                            <label for="" class="col-sm-3 text-right col-form-label label-custom text-end">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_account_number') }}*
                                            </label>
                                            <div class="col-sm-2 form-item-ip form-note">
                                                <input type="text" class="form-control form-control-w128" name="bank_account_number" id="bank_account_number" value="{{old('bank_account_number')}}" placeholder="00000000">
                                            </div>
                                        </div>
                                        <div class="form-group row form-item">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_account_holder') }}*
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <input type="text" class="form-control" name="bank_account_holder" id="bank_account_holder" value="{{old('bank_account_holder')}}">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- cash --}}
                                    <div id="cash">
                                        <p class="text-left">{{ __('admin_epay.merchant.cash_payment.title') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="title-merchant"><u>{{__('admin_epay.merchant.common.merchant_other_info')}}</u></h4>
                        <div class="profile-box">
                            <div class="row">
                                {{-- box left --}}
                                <div class="col-12">
                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.sending_detail') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <div class="custom-control custom-switch custom-switch-md">
                                                <input type="checkbox" class="custom-control-input" id="sending_detail" name="sending_detail"
                                                       @if (session()->has('sending_detail_error')) @if(old('sending_detail') == 'on') checked @endif @endif
                                                       >
                                                <label class="custom-control-label" for="sending_detail"></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.ship_date') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <select class="form-control" id="ship_date" name="ship_date" value="{{old('ship_date')}}">
                                                <option @if(old('ship_date') == \App\Enums\MerchantStoreShipDate::END_MONTH->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::END_MONTH->value}}">{{ __('admin_epay.merchant.ship_date.end_month') }}</option>
                                                <option @if(old('ship_date') == \App\Enums\MerchantStoreShipDate::EVERY_WEEKEND->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::EVERY_WEEKEND->value}}">{{ __('admin_epay.merchant.ship_date.every_weekend') }}</option>
                                                <option @if(old('ship_date') == \App\Enums\MerchantStoreShipDate::END_OTHER_WEEKEND->value) selected @endif value="{{App\Enums\MerchantStoreShipDate::END_OTHER_WEEKEND->value}}">{{ __('admin_epay.merchant.ship_date.every_other_weekend') }}</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.post_code_ship') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note merchant-select-input">
                                            <input type="text" class="form-control form-control-w335" id="ship_post_code_id" name="ship_post_code_id"  placeholder="0000000" value="{{old('ship_post_code_id')}}">
                                            <input type="hidden" class="form-control form-control-w335 " id="ship_post_code_id_value" name="ship_post_code_id_value" value="{{old('ship_post_code_id_value')}}" placeholder="000-0000" >
                                            <button onclick="confirmPostCodeButton('ship_post_code_id','ship_address','ship_post_code_id_value')"
                                                    type="button"
                                                    class="btn form-save"
                                                    > {{ __('common.search') }}
                                            </button>
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.ship_address') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control" id="ship_address" name="ship_address" value="{{old('ship_address')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom label-h52">
                                            {{ __('admin_epay.merchant.other_info.delivery_email_address') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <input type="text" class="form-control mb-3" id="delivery_email_address" name="delivery_email_address" value="{{old('delivery_email_address')}}">
                                            <input type="text" class="form-control mb-3" id="delivery_email_address2" name="delivery_email_address2" value="{{old('delivery_email_address2')}}">
                                            <input type="text" class="form-control" id="delivery_email_address3" name="delivery_email_address3" value="{{old('delivery_email_address3')}}">
                                        </div>
                                    </div>

                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.delivery_report') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <div class="form-item-ip form-note mr-10">
                                                <div class="custom-control custom-switch custom-switch-md form-control-w91">
                                                    <input type="checkbox" class="custom-control-input" id="delivery_report_status" name="delivery_report_status" >
                                                    <label class="custom-control-label" for="delivery_report_status"></label>
                                                </div>
                                            </div>
                                            <div class="d-none" id="delivery_report_flag">
                                                <select
                                                class="form-control text-input form-control-w399"
                                                name="delivery_report" id="delivery_report">
                                                    <option @if(old('delivery_report') == "1") selected @endif value="1">{{__('admin_epay.merchant.delivery_report.day')}}</option>
                                                    <option @if(old('delivery_report') == "2") selected @endif value="2">{{__('admin_epay.merchant.delivery_report.week')}}</option>
                                                    <option @if(old('delivery_report') == "3") selected @endif value="3">{{__('admin_epay.merchant.delivery_report.month')}}</option>
                                                    <option @if(old('delivery_report') == "4") selected @endif value="4">{{__('admin_epay.merchant.delivery_report.cycle')}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                            {{ __('admin_epay.merchant.other_info.guidance_email') }}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <div class="custom-control custom-switch custom-switch-md">
                                                <input type="checkbox" class="custom-control-input" id="guidance_email" name="guidance_email"  @if (session()->has('guidance_email_error')) @if(old('guidance_email') == 'on') checked @endif @else checked @endif>
                                                <label class="custom-control-label" for="guidance_email"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h4 class="title-merchant"><u>{{__('admin_epay.merchant.common.af_info')}}</u></h4>
                        <div class="profile-box">
                            <div class="row">
                                {{-- box left --}}
                                <div class="col-12">
                                    <div class="form-group row form-item">
                                        <label for="" class="col-sm-3 col-form-label label-custom">
                                        {{__('admin_epay.merchant.affiliate_info.info')}}
                                        </label>
                                        <div class="col-sm-9 form-item-ip form-note">
                                            <div class="custom-control custom-switch custom-switch-md">
                                                <input type="checkbox" class="custom-control-input" name="afSwitch" id="afSwitch" @if (session()->has('afSwitch_error')) @if(old('afSwitch') == 'on') checked @endif @endif>
                                                <label class="custom-control-label" for="afSwitch"></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="afSwitchStatus">
                                        <div class="form-group row form-item form-group-two-item-input">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{__('admin_epay.merchant.affiliate_info.id')}}
                                            </label>

                                            <div class="col-sm-3 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_id" name="af_id" value="{{old('af_id')}}">
                                                <input type="hidden" class="form-control" id="afId" name="afId" value="{{old('afId')}}" >
                                            </div>
                                            <div class="col-sm-1 form-item-ip form-note">
                                            </div>
                                            <label for="" class="col-sm-3 col-form-label label-custom" style="max-width: none">
                                                {{__('admin_epay.merchant.affiliate_info.fee')}}
                                            </label>
                                            <div class="col-sm-2 form-item-ip form-note percent-contain">
                                                <input type="text" class="form-control" id="af_rate" name="af_rate" value="{{old('af_rate')}}" onkeydown="validateInput()">
                                                <span class="percent-custom">%</span>
                                            </div>
                                        </div>

                                        <div class="form-group row form-item form-group-two-item-input">
                                            <label for="" class="col-sm-3 col-form-label label-custom">
                                                {{__('admin_epay.merchant.affiliate_info.name')}}
                                            </label>
                                            <div class="col-sm-9 form-item-ip form-note">
                                                <input type="text" class="form-control" id="af_name" name="af_name" value="{{old('af_name')}}">
                                            </div>
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
                                <div class="col-12">
                                    <div class="form-group row form-item form-action">
                                        <label for="" class="col-sm-3 col-form-label label-custom"></label>
                                        <div class="row col-sm-9 pl-0 mr-0 pr-0">
                                            <div class="button-action">
                                                <div class="btn-w500">
                                                    <button type="submit" class="btn btn-edit-detail form-save" id="merchant">
                                                        {{__('admin_epay.merchant.common.create')}}
                                                    </button>
                                                    <a href="{{route('admin_epay.merchantStore.index.get')}}">
                                                        <button type="button" class="btn form-close form-back" >
                                                        {{__('common.button.back')}}
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
            @include('common.modal.merchant_store_validate', [
                'title' => __('入力チェックのエラー'),
                'submit_btn' => __('admin_epay.merchant.common.rewrite'),
            ])
            @include('common.modal.confirm', [
                'title' => __('新規加盟店の登録確認'),
                'description' => __('新規加盟店を登録します。よろしいですか?'),
                'submit_btn' => __('common.create'),
            ])
        </div>
    </section>
    @include('common.modal.select_merchant', [
        'stores' => $merchantStores,
        'selectedStores' =>session()->has('old_group_id') ? session()->get('old_group_id') : [],
    ])
@endsection

@push('script')
<script>
    let inputStep3 = ["af_id","af_name","af_rate"]
    let validateFiat = ["bank_code","financial_institution_name","branch_code","branch_name","bank_account_type","bank_account_type","bank_account_number","bank_account_holder"]
    let validateCash = ["total_transaction_amount","account_balance","paid_balance"]
    let validateCrypto = ["wallet_address","crypto_network"]

    const confirmPostCode = async (element,address,value) => {
        return new Promise((resolve, reject) => {
            let post_code_id = $(`#${element}`)[0].value;
            $.ajax({
                type: 'post',
                url: `{{ route('admin_epay.merchantStore.check_post_code') }}`,
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    postal_code: post_code_id
                },
                success: function (response) {
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
                        if (element === 'post_code_id'){
                            $(`#${element}-error`).find('.error').html("{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}")
                        }
                        if (element === 'ship_post_code_id'){
                            $(`#${element}-error`).find('.error').html("{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}")
                        }
                        reject();
                    }
                }
            })
        });
    }

    const confirmPostCodeButton = async (element,address,value) => {
        let post_code_id = $(`#${element}`)[0].value;
        $.ajax({
            type: 'post',
            url: `{{ route('admin_epay.merchantStore.check_post_code') }}`,
            data: {
                _token: $("meta[name='csrf-token']").attr('content'),
                postal_code: post_code_id
            },
            success: function (response) {
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
                    if (element === 'post_code_id'){
                        $(`#${element}-error`).find('.error').html("{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}")
                        toastr.error("{{ __('admin_epay.merchant.validation.post_code_id.non_exist') }}");
                    }
                    if (element === 'ship_post_code_id'){
                        $(`#${element}-error`).find('.error').html("{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}")
                        toastr.error("{{ __('admin_epay.merchant.validation.ship_post_code_id.non_exist') }}");
                    }
                }
            }
        });
    }

    const confirmBankCode = async () => {
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
                    $(`#bank_code-error`).find('.error').html("{{ __('admin_epay.merchant.validation.bank_code.non_exist') }}")
                }
            }
        })
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
                        $(`#branch_code-error`).find('.error').html("{{ __('admin_epay.merchant.validation.branch_code.non_exist') }}")
                        reject();
                    }
                }
            })
        });
    }

    $(document).ready(function () {
        const MERCHANT_STORE = $('.merchant-item');
        const CREATE_MERCHANT = $('#create-merchant');
        const STORE_SELECTED = $('.list-area-members');
        const MERCHANT_SELECTED =  $('.form-note-textarea');
        $("#submit-form").click(()=> {
            CREATE_MERCHANT[0].submit();
        });

        MERCHANT_STORE.on('click', function () {
            $('.modal-backdrop').show();
          STORE_SELECTED.children().remove();
          $('input[name=group]').val('');
          $('input[name=group_id]').val('');
          let array = []
          let nameGroup = []
          $('.merchant-list input:checked').each(function () {
              let name = $(this).data('name');
              array = [...array,$(this)[0].value]
              nameGroup = [...nameGroup,name]
              $('input[name=group_id]').val(JSON.stringify(array));
              STORE_SELECTED.append(`<p class="members-item">${name}</p><div class="line-item"></div>`);
          });
          if (nameGroup.length > 0) {
              $('input[name=group]').val(JSON.stringify(nameGroup));
          }
          if ($('input:checked').length > 0) {
              MERCHANT_SELECTED.find('.border-error').removeClass('border-error');
              MERCHANT_SELECTED.find('.note-pass-error').html('');
          }
          console.log($('input[name=group]')[0].value)
        });

        $('#ship_date').datepicker(COMMON_DATEPICKER);
        $('#contract_date').datepicker(COMMON_DATEPICKER);
        $('#termination_date').datepicker(COMMON_DATEPICKER);
        const currentDate = new Date();
        $('#contract_date').datepicker('setDate', currentDate);
        $('#afSwitch').change(function () {
            if ($('#afSwitch').is(":checked")){
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
                inputStep3.forEach(value=>{
                    $('#myForm').rules('remove',value)
                    $(`#${value}-error`).find('.error').remove();
                })
            }
        });
        $('#delivery_report_status').change(function () {
            if ($('#delivery_report_status').is(":checked")){
                $("#delivery_report_flag").removeClass("d-none");
                $('#delivery_email_address').rules('add',{
                    required: true,
                });
            } else {
                $("#delivery_report_flag").addClass("d-none");
                $('#delivery_email_address').removeClass('border-error');
                $('#delivery_email_address').rules('remove', 'required');
            }
        });
        $('input[name=total_transaction_amount_value]').change((e)=>{
            $('input[name=total_transaction_amount]').val(e.target.value)
        })
        $('input[name=account_balance_value]').change((e)=>{
            $('input[name=account_balance]').val(e.target.value)
        })
        $('input[name=paid_balance_value]').change((e)=>{
            $('input[name=paid_balance]').val(e.target.value)
        })
        @if(old('afSwitch') == 'on')
            $("#afSwitchStatus").show();
        @endif
        $('#withdraw_method').change(function () {
            if ($('#withdraw_method')[0].value === "{{\App\Enums\MerchantPaymentType::CRYPTO->value}}") {
                $('#crypto').show()
                $('#fiat').hide()
                $('#cash').hide()
                $('#bank_code').removeClass('border-error')
                $('#branch_code').removeClass('border-error')
                $('#bank_account_number').removeClass('border-error')
                $('#bank_account_holder').removeClass('border-error')
                validateFiat.forEach(value=>{
                    if (value == 'bank_code') {
                        $(`#${value}`).rules('remove',"checkBankCode")
                    }
                    if (value == 'branch_code') {
                        $(`#${value}`).rules('remove',"checkBranchCode")
                    }
                    if (value == 'bank_account_holder') {
                        $(`#${value}`).rules('remove',"checkKatakana")
                    }
                    $(`#${value}-error`).find('.error').remove();
                    if (value !== 'bank_code' && value !== 'branch_code'){
                        $(`#${value}`).rules('remove',"required")
                    }

                })
                validateCash.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                $('#wallet_address').rules('add',{
                    required: true,
                })
                $('#crypto_network').rules('add',{
                    required: true,
                })
            }
            if ($('#withdraw_method')[0].value === "{{App\Enums\MerchantPaymentType::FIAT->value}}") {
                $('#crypto').hide()
                $('#fiat').show()
                $('#cash').hide()
                $('#wallet_address').removeClass('border-error')
                validateCrypto.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                validateCash.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                $('#bank_code').rules('add',{
                    checkBankCode: true,
                })
                $('#financial_institution_name').rules('add',{
                    required: true,
                })
                $('#branch_code').rules('add',{
                    checkBranchCode: true,
                })
                $('#branch_name').rules('add',{
                    required: true,
                })
                $('#bank_account_number').rules('add',{
                    required: true,
                })
                $('#bank_account_holder').rules('add',{
                    required: true,
                    checkKatakana: true
                })
            }
            if ($('#withdraw_method')[0].value === "{{App\Enums\MerchantPaymentType::CASH->value}}") {
                $('#crypto').hide()
                $('#fiat').hide()
                $('#cash').show()
                $('#bank_code').removeClass('border-error')
                $('#branch_code').removeClass('border-error')
                $('#bank_account_number').removeClass('border-error')
                $('#bank_account_holder').removeClass('border-error')
                validateCrypto.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                validateFiat.forEach(value=>{
                    if (value === 'bank_code') {
                        $(`#${value}`).rules('remove',"checkBankCode")
                    }
                    if (value === 'branch_code') {
                        $(`#${value}`).rules('remove',"checkBranchCode")
                    }
                    if (value === 'bank_account_holder') {
                        $(`#${value}`).rules('remove',"checkKatakana")
                    }
                    $(`#${value}-error`).find('.error').remove();
                    if (value !== 'bank_code' && value !== 'branch_code'){
                        $(`#${value}`).rules('remove',"required")
                    }
                })
            }
        });

        $(function() {
            $.validator.addMethod("checkCode", async function(value, element, options) {
                if (value){
                    if (/^\d{1,8}$/.test(value)){
                        await confirmPostCode('post_code_id','address','post_code_id_value')
                            .then(result => {})
                            .catch(error => {})
                    } else {
                        $(`#address`).val("")
                        $(`#post_code_id_value`).val("")
                        $(`#post_code_id`).addClass('border-error')
                        $(`#post_code_id-error`).find('.error').show();
                        $(`#post_code_id-error`).find('.error').html("{{ __('admin_epay.merchant.validation.post_code_id.format') }}")
                    }

                    return !$('#post_code_id').hasClass('border-error');
                } else {
                    $(`#address`).val("")
                    $(`#post_code_id_value`).val("")
                    $(`#post_code_id`).removeClass('border-error')
                    $(`#post_code_id-error`).find('.error').hide();
                    return true;
                }
            }, "");
            $.validator.addMethod("checkShipCode", async function(value, element, options) {
                if (value){
                    if (/^\d{1,8}$/.test(value)){
                        await confirmPostCode('ship_post_code_id','ship_address','ship_post_code_id_value')
                            .then(result => {})
                            .catch(error => {})
                    } else {
                        $(`#address`).val("")
                        $(`#ship_post_code_id_value`).val("")
                        $(`#ship_post_code_id`).addClass('border-error')
                        $(`#ship_post_code_id-error`).find('.error').show();
                        $(`#ship_post_code_id-error`).find('.error').html("{{ __('admin_epay.merchant.validation.ship_post_code_id.format') }}")
                    }

                    return !$('#ship_post_code_id').hasClass('border-error');
                } else {
                    $(`#ship_address`).val("")
                    $(`#ship_post_code_id_value`).val("")
                    $(`#ship_post_code_id`).removeClass('border-error')
                    $(`#ship_post_code_id-error`).find('.error').hide();
                    return true;
                }
            }, "");

            $.validator.addMethod("checkBankCode", async function(value, element, options) {
                if (value){
                    await confirmBankCode()
                        .then(result => {})
                        .catch(error => {})

                    return !$('#bank_code').hasClass('border-error');
                } else {
                    $("#bank_code").addClass('border-error');
                    $(`#financial_institution_name`).val("")
                    $(`#financial_institution_name_value`).val("")
                    $(`#bank_code-error`).find('.error').show();
                    $(`#bank_code-error`).find('.error').html("{{ __('admin_epay.merchant.validation.bank_code.required') }}")
                    return false;
                }
            }, "");
            $.validator.addMethod("checkBranchCode", async function(value, element, options) {
                if (value){
                    await confirmBranchCode()
                        .then(result => {})
                        .catch(error => {})

                    return !$('#branch_code').hasClass('border-error');
                } else {
                    $("#branch_code").addClass('border-error');
                    $(`#branch_name`).val("")
                    $(`#branch_name_value`).val("")
                    $(`#branch_code-error`).find('.error').show();
                    $(`#branch_code-error`).find('.error').html("{{ __('admin_epay.merchant.validation.branch_code.required') }}")
                    return false;
                }
            }, "");

            $.validator.addMethod("notEqualTo", function(value, element, param) {
                let flag = true;
                if(value == '') return flag;
                param.forEach(e =>{
                    if ($(`${e}`)[0].value == value) {
                        flag = false
                    }
                })
                return flag
            });

            $("#create-merchant").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    post_code_id: {
                        checkCode: true,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    password: {
                        required: true,
                        checkStringNumber : true
                    },
                    contract_wallet: {
                        required: true,
                    },
                    receiving_walletaddress: {
                        required: true,
                    },
                    received_virtua_type: {
                        required: true,
                    },
                    auth_token: {
                        required: true,
                    },
                    hash_token: {
                        required: true,
                    },
                    payment_url: {
                        required: true,
                    },
                    ship_post_code_id: {
                        checkShipCode: true,
                    },
                    delivery_email_address: {
                        email: true,
                        notEqualTo: ['#delivery_email_address2','#delivery_email_address3'],
                    },
                    delivery_email_address2: {
                        email: true,
                        notEqualTo: ['#delivery_email_address','#delivery_email_address3'],
                    },
                    delivery_email_address3: {
                        email: true,
                        notEqualTo: ['#delivery_email_address2', '#delivery_email_address'],
                    },
                    contract_date: {
                        required: true,
                    },
                    bank_code: {
                        // required: true,
                        checkBankCode : true
                    },
                    financial_institution_name: {
                        required: true,
                    },
                    branch_code: {
                        checkBranchCode: true,
                    },
                    branch_name: {
                        required: true,
                    },
                    bank_account_number: {
                        required: true,
                    },
                    bank_account_holder: {
                        required: true,
                        checkKatakana: true
                    },
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
                        checkCode: "{{ __('admin_epay.merchant.validation.post_code_id.required') }}",
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
                        checkStringNumber: "{{ __('admin_epay.merchant.validation.password.format') }}"
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
                    payment_url: {
                        required: "{{ __('admin_epay.merchant.validation.payment_url.required') }}",
                    },
                    ship_date: {
                        required: "{{ __('admin_epay.merchant.validation.ship_date.required') }}",
                    },
                    ship_post_code_id: {
                        checkShipCode: "{{ __('admin_epay.merchant.validation.ship_post_code_id.required') }}",
                    },
                    ship_address: {
                        required: "{{ __('admin_epay.merchant.validation.ship_address.required') }}",
                    },
                    delivery_email_address: {
                        required: "{{ __('admin_epay.merchant.validation.delivery_email_address.required') }}",
                        email: "{{ __('validation.common.email.format') }}",
                        notEqualTo: "{{ __('admin_epay.merchant.validation.delivery_email_address.notEqualTo') }}",
                    },
                    delivery_email_address2: {
                        notEqualTo: "{{ __('admin_epay.merchant.validation.delivery_email_address.notEqualTo') }}",
                        email: "{{ __('validation.common.email.format') }}",
                    },
                    delivery_email_address3: {
                        notEqualTo: "{{ __('admin_epay.merchant.validation.delivery_email_address.notEqualTo') }}",
                        email: "{{ __('validation.common.email.format') }}",
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
                errorPlacement: function (error, element) {
                    let name = $(element).attr('name');
                    if(name == 'delivery_email_address2' || name == 'delivery_email_address3')
                        name = 'delivery_email_address';
                    $(`#${name}-error`).find('.error').remove();
                    $(`#${name}-error`).append(error);
                },
                highlight: function (element) {
                    $(element).addClass('border-error');
                },
                unhighlight: function (element) {
                    const name = $(element).attr('name');
                    if (name !== 'post_code_id' && name !== 'ship_post_code_id' && name !== 'bank_code' && name !== 'branch_code' ) {
                        $(`#${name}-error`).find('.error').remove();
                        $(element).removeClass('border-error');
                    }

                },
                submitHandler: function() {
                    if ($('#bank_code').hasClass('border-error') || $('#branch_code').hasClass('border-error') || $('#post_code_id').hasClass('border-error') || $('#ship_post_code_id').hasClass('border-error')) {
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
                    $('.modal-backdrop').show();
                }
            });
            @if(old('withdraw_method') == App\Enums\MerchantPaymentType::FIAT->value)
                $('#crypto').hide()
                $('#cash').hide()
                $('#fiat').show()
                $('#wallet_address').removeClass('border-error')
                validateCrypto.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                validateCash.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                $('#bank_code').rules('add',{
                    checkBankCode: true,
                })
                $('#financial_institution_name').rules('add',{
                    required: true,
                })
                $('#branch_code').rules('add',{
                    checkBranchCode: true,
                })
                $('#branch_name').rules('add',{
                    required: true,
                })
                $('#bank_account_number').rules('add',{
                    required: true,
                })
                $('#bank_account_holder').rules('add',{
                    required: true,
                    checkKatakana: true
                })
            @endif
            @if(old('withdraw_method') == App\Enums\MerchantPaymentType::CRYPTO->value)
                $('#fiat').hide()
                $('#cash').hide()
                $('#crypto').show()
                $('#bank_code').removeClass('border-error')
                $('#branch_code').removeClass('border-error')
                $('#bank_account_number').removeClass('border-error')
                $('#bank_account_holder').removeClass('border-error')
                validateFiat.forEach(value=>{
                    if (value === 'bank_code') {
                        $(`#${value}`).rules('remove',"checkBankCode")
                    }
                    if (value === 'branch_code') {
                        $(`#${value}`).rules('remove',"checkBranchCode")
                    }
                    if (value === 'bank_account_holder') {
                        $(`#${value}`).rules('remove',"checkKatakana")
                    }
                    $(`#${value}-error`).find('.error').remove();
                    if (value !== 'bank_code' && value !== 'branch_code'){
                        $(`#${value}`).rules('remove',"required")
                    }

                })
                validateCash.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                $('#wallet_address').rules('add',{
                    required: true,
                })
                $('#crypto_network').rules('add', {
                    required: true,
                })
            @endif
            @if(old('withdraw_method') == App\Enums\MerchantPaymentType::CASH->value)
                $('#crypto').hide()
                $('#fiat').hide()
                $('#cash').show()
                $('#bank_code').removeClass('border-error')
                $('#branch_code').removeClass('border-error')
                $('#bank_account_number').removeClass('border-error')
                $('#bank_account_holder').removeClass('border-error')
                validateCrypto.forEach(value=>{
                    $(`#${value}`).rules('remove',"required")
                    $(`#${value}-error`).find('.error').remove();
                })
                validateFiat.forEach(value=>{
                    if (value === 'bank_code') {
                        $(`#${value}`).rules('remove', 'checkBankCode')
                    }
                    if (value === 'branch_code') {
                        $(`#${value}`).rules('remove', 'checkBranchCode')
                    }
                    if (value === 'bank_account_holder') {
                        $(`#${value}`).rules('remove', 'checkKatakana')
                    }
                    $(`#${value}-error`).find('.error').remove();
                    if (value !== 'bank_code' && value !== 'branch_code'){
                        $(`#${value}`).rules('remove', 'required')
                    }
                })
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
            if(parseFloat(afterInputValue) > 100 || afterInputValue == "100."){
                event.preventDefault();
            }

            if(afterInputValue.includes(".") && (afterInputValue.split(".")[1]).length > 1 && event.key != "Backspace"){
                event.preventDefault();
            }
        } else {
            event.preventDefault();
        }
    }

    $('#received_virtua_type').change(function () {
        var receivedVirtuaType = this.value;
        if (receivedVirtuaType === 'JPYC') {
            $('#crypto_network option[value="5"]').hide();
            $('#crypto_network option[value="7"]').hide();
            if($('#crypto_network').val() == 5 || $('#crypto_network').val() == 7)
                $('#crypto_network').val(1);
        }
        else {
            $('#crypto_network option[value="5"]').show();
            $('#crypto_network option[value="7"]').show();
        }
        $('#crypto_network').selectpicker('refresh');
    });
</script>
@endpush
