@php
    use App\Enums\WithdrawMethod;
    use App\Enums\WithdrawAsset;
    use App\Enums\MerchantStoreStatus;
    use App\Enums\MerchantPaymentType;
    use Illuminate\Support\Carbon;

    $merchantStoreStatus = [
        MerchantStoreStatus::TEMPORARILY_REGISTERED->value => 'temporarily_registered',
        MerchantStoreStatus::UNDER_REVIEW->value => 'under_review',
        MerchantStoreStatus::IN_USE->value => 'in_use',
        MerchantStoreStatus::SUSPEND->value => 'suspend',
        MerchantStoreStatus::WITHDRAWAL->value => 'withdrawal',
        MerchantStoreStatus::FORCED_WITHDRAWAL->value => 'forced_withdrawal',
        MerchantStoreStatus::CANCEL->value => 'agreement',
    ];
    $receiveCryptoTypes = [
        '1' => 'USDT',
        '2' => 'USDC',
        '3' => 'DAI',
        '4' => 'JPYC',
    ];
    $deliveryReports = [
        '1' => 'day',
        '2' => 'week',
        '3' => 'month',
        '4' => 'cycle',
    ];
    $paymentCycles = [
        '1' => 'end_week',
        '2' => 'end_month',
    ];
    $withdrawMethods = [
        WithdrawMethod::CASH->value,
        WithdrawMethod::BANKING->value,
        WithdrawMethod::CRYPTO->value,
    ];
    $cryptoAssets = [
        WithdrawAsset::USDT->value,
        WithdrawAsset::DAI->value,
    ];
    $fiatAssets = [
        WithdrawAsset::JPY->value,
    ];
    $assets = [
        WithdrawAsset::JPY->value,
        WithdrawAsset::USDT->value,
        WithdrawAsset::DAI->value,
    ];
    $currentHour = now()->format('Y-m-d H:i');
    $merchantUserId = auth('merchant')->user()->id;
@endphp

<section class="content-header">
    <div class="row header-input">
        <div class="d-flex align-items-center">
            <h1 class="main-title-page"> {{__('merchant.setting.profile.merchant_detail_popup_title')}}</h1>
        </div>
        {{-- <div class="input-header-close">
            <div class="setting-page-profile page-merchant-store-header">
                <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
                    <label for="" class="text-right col-form-label label-custom">
                        {{ __('admin_epay.merchant.cash_payment.total_transaction_amount') }}
                    </label>
                    <div class="form-item-ip form-note">
                        <input type="text"
                               class="form-control form-control-header bg-white"
                               value="{{ $dataMerchant->cashPayment->total_transaction_amount ?? 0 }}"
                               name="total_transaction_amount_value"
                               id="total_transaction_amount"/>
                    </div>
                </div>
                <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
                    <label for="" class="text-right col-form-label label-custom">
                        {{ __('admin_epay.merchant.cash_payment.account_balance') }}
                    </label>
                    <div class="form-item-ip form-note">
                        <input type="text"
                               class="form-control form-control-header bg-white"
                               value="{{ $dataMerchant->cashPayment->account_balance ?? 0 }}"
                               name="account_balance_value"
                               id="account_balance"/>
                    </div>
                </div>
                <div class="form-group form-item form-item-header pl-0 pr-0 mb-0">
                    <label for="" class="text-right col-form-label label-custom">
                        {{ __('admin_epay.merchant.cash_payment.paid_balance') }}
                    </label>
                    <div class="form-item-ip form-note">
                        <input type="text"
                               class="form-control form-control-header bg-white"
                               value="{{ $dataMerchant->cashPayment->paid_balance ?? 0 }}"
                               name="paid_balance_value"
                               id="paid_balance"/>
                    </div>
                </div>
            </div>
            <button onclick="closeDetailModal()" type="button" class="close" data-dismiss="modal" aria-label="Close">
                <img class="img-cancel" src="../../../../../dashboard/img/cancel.svg"/>
            </button>
        </div> --}}
    </div>
</section>

<section id="stepper1" class="content setting-page-profile pt-4" style="padding-left: 0px !important">
    <!--step's content-->
    <div class="form-container merchant-regist-page ">
        <div class="row ml-0">
            <div class="col-lg-6 pl-0 tab-content" style="padding-right: 40px;"
                 id="nav-tabContent">
                <h4 class="title-merchant">
                    {{__('admin_epay.merchant.common.merchant_other_info')}}
                </h4>
                <div class="profile-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row form-item form-status-id">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{__("admin_epay.merchant.info.id")}}
                                </label>
                                <div
                                    class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control form-control-w200"
                                           name="merchant_code" id="name"
                                           value="{{ formatAccountId($dataMerchant->merchant_code)}}"
                                           disabled>
                                </div>

                                <label for="" class="col-sm-4 col-form-label label-custom text-select-status text-end">
                                    {{__("admin_epay.merchant.info.status")}}
                                </label>
                                 <div class="col-sm-2 form-control-w91 form-item-ip form-note select_search form-select-option-status ">
                                     <select
                                         name="status"
                                         class="form-control form-control-w91"
                                         id="payment-method-slt"
                                         disabled
                                     >
                                         @foreach($merchantStoreStatus as $key => $value)
                                             <option
                                                 value="{{$key}}"
                                                 @if($dataMerchant->status == $key) selected @endif >
                                                 {{ __("admin_epay.merchant.status.$value") }}
                                             </option>
                                         @endforeach
                                     </select>
                                 </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.name') }}*
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           name="name"
                                           id="name"
                                           disabled
                                           value="{{ $dataMerchant->name ?? '' }}">
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.service_name') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="service_name"
                                           name="service_name"
                                           disabled
                                           value="{{ $dataMerchant->service_name ?? '' }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.industry') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="industry"
                                           name="industry"
                                           disabled
                                           value="{{ $dataMerchant->industry ?? '' }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.representative_name') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="representative_name"
                                           disabled
                                           name="representative_name"
                                           value="{{ $dataMerchant->representative_name ?? '' }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.address') }}
                                </label>
                                <div
                                    class="col-sm-9 form-item-ip form-note form-two-infomation">
                                    <div class="form-item-ip form-note">
                                        <input type="text"
                                               class="form-control form-control-w91"
                                               name="post_code_id"
                                               id="post_code_id"
                                               disabled
                                               value="{{ $dataMerchant->postCodeId->code ?? '' }}"
                                               required>
                                    </div>
                                    <div class="form-item-ip form-note">
                                        <input type="text"
                                               class="form-control form-control-w399"
                                               id="address"
                                               name="address"
                                               disabled
                                               value="{{ $dataMerchant->address ?? '' }}"
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.phone_number') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="phone"
                                           name="phone"
                                           disabled
                                           value="{{ $dataMerchant->phone ?? '' }}"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.register_email') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="email"
                                           value="{{ $dataMerchant->merchantOwner->email ?? '' }}"
                                           disabled
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.password') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="phone"
                                           name="phone"
                                           disabled
                                           value="***********"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="group"
                                       class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.group') }}
                                </label>
                                <div class="col-md-9 form-item-ip form-note ">
                                    <div
                                        class="form-control list-area-members list-area-members-w500"
                                        style="background-color: #f0f0f2 !important;">
                                        @foreach($dataMerchant->groups as $value)
                                            <p class="members-item">{{$value->name}}</p>
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
                                    <input type="text"
                                           class="form-control"
                                           name="contract_wallet"
                                           id="contract_wallet"
                                           value="{{ $dataMerchant->slashApi->contract_wallet ?? '' }}"
                                           disabled>
                                </div>
                            </div>

                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom"
                                       style="line-height: 16px">
                                    {{ __('admin_epay.merchant.info.received_wallet1') }}<br>{{ __('admin_epay.merchant.info.received_wallet2') }}*
                                </label>
                                <div class="col-sm-9 form-item-ip">
                                    <input type="text"
                                           class="form-control"
                                           name="receiving_walletaddress"
                                           id="receiving_walletaddress"
                                           value="{{ $dataMerchant->slashApi->receive_wallet_address ?? '' }}"
                                           disabled>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.virtual_currency_type') }}
                                </label>
                                <div class="col-sm-9 form-item-ip">
                                    <select
                                        class="form-control"

                                        disabled
                                    >
                                    @if(!empty($dataMerchant->slashApi->receive_crypto_type))
                                        @foreach($receiveCryptoTypes as $key => $value)
                                            <option
                                                value="{{$key}}"
                                                @if(!empty($dataMerchant->slashApi->receive_crypto_type) and $dataMerchant->slashApi->receive_crypto_type == $key) selected @endif >
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.auth_token') }}*
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="api_key"
                                           name="api_key"
                                           disabled
                                           value="***********"
                                           required>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.hash_token') }}*
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="api_key"
                                           name="api_key"
                                           disabled
                                           value="***********"
                                    >
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.info.payment_url') }}*
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control"
                                           id="api_key"
                                           name="api_key"
                                           disabled
                                           value="{{ $dataMerchant->payment_url ? $dataMerchant->payment_url :'' }}"
                                           required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- box right --}}
            <div class= "col-lg-6 pl-0 tab-content tab-content-option" id="nav-tabContent">
                <h4 class="title-merchant">
                    {{__('admin_epay.merchant.common.merchant_other_info')}}
                </h4>
                <div class="profile-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row form-item form-switch-input">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.other_info.sending_detail') }}
                                </label>
                                <div class="form-item-ip form-note">
                                    <div
                                        class="custom-control custom-switch custom-switch-md">
                                        <input type="checkbox"
                                               @if($dataMerchant->sending_detail == 1) checked @endif
                                               class="custom-control-input"
                                               id="sending_detail"
                                               name="sending_detail">
                                        <label class=" custom-control-label"
                                               for="sending_detail"></label>
                                    </div>
                                </div>
                                <label for="" class="col-form-label label-custom mr-15">
                                    {{ __('admin_epay.merchant.other_info.ship_date') }}
                                </label>
                                <div class="col-sm-3 form-item-ip form-note">
                                    <select disabled class="form-control form-control-w128" id="ship_date" name="ship_date" value="{{old('ship_date')}}">
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
                                <div
                                    class="col-sm-9 form-item-ip form-note form-two-infomation">
                                    <div class="form-item-ip form-note">
                                        <input type="text"
                                               class="form-control form-control-w91"
                                               id="ship_post_code_id"
                                               name="ship_post_code_id"
                                               disabled
                                               value="{{ $dataMerchant->shipPostCodeId->code ?? '' }}"
                                               required>
                                    </div>
                                    <div class="form-item-ip form-note">
                                        <input type="text"
                                               class="form-control form-control-w399"

                                               value="{{ $dataMerchant->ship_address ?? '' }}"
                                               name="code"
                                               disabled
                                               required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.other_info.delivery_report') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <select
                                        class="form-control"

                                        disabled
                                    >
                                    @if (!empty($dataMerchant->delivery_report))
                                        @foreach($deliveryReports as $key => $value)
                                            <option
                                                value="{{$key}}"
                                                @if($dataMerchant->delivery_report == $key) selected @endif >
                                                {{ __("admin_epay.merchant.delivery_report.$value") }}
                                            </option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for=""
                                       class="col-sm-3 col-form-label label-custom label-h52">
                                    {{ __('admin_epay.merchant.other_info.delivery_email_address') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control mb-3"
                                           id="delivery_email_address"
                                           disabled
                                           name="delivery_email_address"
                                           value="{{ $dataMerchant->delivery_email_address1 ?? '' }}" >
                                    <input type="text"
                                           class="form-control mb-3"
                                           id="delivery_email_address2"
                                           disabled
                                           name="delivery_email_address2"
                                           value="{{ $dataMerchant->delivery_email_address2 ?? '' }}" >
                                    <input type="text"
                                           class="form-control"
                                           id="delivery_email_address3"
                                           disabled
                                           name="delivery_email_address3"
                                           value="{{ $dataMerchant->delivery_email_address3 ?? '' }}" >
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.other_info.guidance_email') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <div
                                        class="custom-control custom-switch custom-switch-md">
                                        <input type="checkbox"
                                               @if($dataMerchant->delivery_report == 1) checked @endif
                                               class="custom-control-input"
                                               id="guidance_email"
                                               name="guidance_email">
                                        <label class="custom-control-label"
                                               for="guidance_email"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <h4 class="title-merchant">
                    <u>
                        {{__('admin_epay.merchant.common.contract_payment_info')}}
                    </u>
                </h4>
                <div class="profile-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row form-item form-group-two-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.payment_info.contract_date') }}*
                                </label>
                                <div
                                    class="col-sm-3 form-item-ip form-note form-responsive-two-input  form-responsive-mb-15 form-control-date-w191">
                                    <div class="input-group date form-control-date-w191">
                                        <input type="text"
                                               class="form-control"
                                               name="contract_date"
                                               disabled
                                               id="contract_date"
                                               value="{{ $dataMerchant->contract_date ? Carbon::parse($dataMerchant->contract_date)->format('Y年m月d日') : '' }}"/>
                                    </div>
                                </div>
                                <!-- <label for="" class=" col-sm-1 form-item-ip form-note"></label> -->
                                <label for=""
                                       class="col-sm-2 col-form-label label-custom text-end col-form-label-date">
                                    {{ __('admin_epay.merchant.payment_info.termination_date') }}
                                </label>
                                <div
                                    class="col-sm-3 form-item-ip form-note form-control-date-w191">
                                    <div class="input-group date form-control-date-w191">
                                        <input type="text"
                                               class="form-control"
                                               disabled
                                               name="termination_date"
                                               id="termination_date"
                                               value="{{ $dataMerchant->termination_date ? Carbon::parse($dataMerchant->termination_date)->format('Y年m月d日') : '' }}" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item form-group-two-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.payment_info.contract_interest_rate') }}
                                </label>
                                <div
                                    class="col-sm-3 form-responsive-two-input form-responsive-mb-15 form-item-ip form-note">
                                    <input type="text"
                                           class="form-control form-control-date-w191"
                                           id="contract_interest_rate"
                                           disabled
                                           name="contract_interest_rate"
                                           value="{{ $dataMerchant->contract_interest_rate ? $dataMerchant->contract_interest_rate.'%' : '' }}" >
                                </div>

                                <label for="" class="col-sm-3 col-form-label label-custom text-end pr-24 ">
                                    {{ __('admin_epay.merchant.payment_info.payment_cycle') }}
                                </label>
                                <div class="col-sm-2 form-item-ip form-note">
                                    <select
                                        class="form-control form-control-w128"

                                        disabled
                                    >
                                    @if(!empty($dataMerchant->payment_cycle))
                                        @foreach($paymentCycles as $key => $value)
                                            <option
                                                value="{{$key}}"
                                                @if($dataMerchant->payment_cycle == $key) selected @endif >
                                                {{ __("admin_epay.merchant.payment_cycle.$value") }}
                                            </option>
                                        @endforeach
                                    @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{ __('admin_epay.merchant.payment_info.payment_currency') }}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note merchant-select-input">
                                    <select
                                        name="withdraw_method"
                                        class="form-control form-control-w311"
                                        id="payment-method-slt"
                                        disabled
                                    >
                                    @if(!empty($dataMerchant->withdraw_method))
                                        @foreach($withdrawMethods as $withdrawMethod)
                                            <option
                                                value="{{$withdrawMethod}}"
                                                @if($dataMerchant->withdraw_method == $withdrawMethod) selected @endif >
                                                {{ __("merchant.withdraw.withdraw_method.$withdrawMethod") }}
                                            </option>
                                        @endforeach
                                    @endif
                                    </select>

                                    @if($dataMerchant->withdraw_method ==WithdrawMethod::BANKING->value)
                                        <button data-toggle="modal" data-target="#payment-modal" type="button"
                                                class="height-auto btn form-save btn-primary btn-show_payment_modal">
                                            {{ __('merchant.withdraw.payee_information_display') }}
                                        </button>
                                        @include('merchant.setting.modal.partial.payment_banking', [
                                            'bankingInfo' => $dataMerchant->fiatWithdrawAccount
                                        ])

                                    @elseif($dataMerchant->withdraw_method ==WithdrawMethod::CRYPTO->value)
                                        <button data-toggle="modal" data-target="#crypto-modal" type="button"
                                                class="height-auto btn form-save btn-primary btn-show_payment_modal">
                                            {{ __('merchant.withdraw.payee_information_display') }}
                                        </button>
                                        @include('merchant.setting.modal.partial.payment_crypto', [
                                            'cryptoInfo' => $dataMerchant->cryptoWithdrawAccount
                                        ])
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- <h4 class="title-merchant">
                    <u>
                        {{__('admin_epay.merchant.common.af_info')}}
                    </u>
                </h4> --}}
                {{-- <div class="profile-box">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{__('admin_epay.merchant.affiliate_info.info')}}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <div
                                        class="custom-control custom-switch custom-switch-md">
                                        <input type="checkbox"
                                               checked
                                               class="custom-control-input"
                                               name="afSwitch"
                                               id="afSwitch">
                                        <label class="custom-control-label"
                                               for="afSwitch"></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item form-group-two-item-input">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{__('admin_epay.merchant.affiliate_info.id')}}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           disabled
                                           class="form-control form-control-w200"
                                           id="af_name"
                                           name="af_name">
                                </div>
                            </div>
                            <div class="form-group row form-item form-group-two-item-input">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{__('admin_epay.merchant.affiliate_info.fee')}}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           disabled
                                           class="form-control"
                                           id="af_name"
                                           name="af_name">
                                </div>
                            </div>
                            <div class="form-group row form-item form-group-two-item-input">
                                <label for="" class="col-sm-3 col-form-label label-custom">
                                    {{__('admin_epay.merchant.affiliate_info.name')}}
                                </label>
                                <div class="col-sm-9 form-item-ip form-note">
                                    <input type="text"
                                           disabled
                                           class="form-control"
                                           id="af_name"
                                           name="af_name">
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</section>
