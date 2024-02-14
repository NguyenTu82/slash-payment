@extends('merchant.layouts.base')
@section('title', __('merchant.withdraw.payment_request'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/MER_04_02.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        .modal-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1040;
            width: 100vw;
            height: 100vh;
            background-color: #000;
        }
    </style>
@endpush

@php
    use App\Enums\WithdrawMethod;
    use App\Enums\WithdrawAsset;
    use App\Enums\BankAccountType;
    use App\Enums\CryptoNetwork;
    $withdrawMethods = [WithdrawMethod::CASH->value, WithdrawMethod::BANKING->value, WithdrawMethod::CRYPTO->value];
    $bankAccountTypes = [
        'usually' => BankAccountType::USUALLY->value,
        'regular' => BankAccountType::REGULAR->value,
        'current' => BankAccountType::CURRENT->value,
    ];
    $cryptoAssets = [WithdrawAsset::USDT->value, WithdrawAsset::USDC->value, WithdrawAsset::DAI->value, WithdrawAsset::JPYC->value];
    $fiatAssets = [WithdrawAsset::JPY->value];
    $assets = array_merge($fiatAssets, $cryptoAssets);
    $networks = CryptoNetwork::cases();
    $networkKeys = array_column(CryptoNetwork::cases(), 'name');
    $currentHour = now()->format('Y-m-d H:i');
    $merchantUserId = auth('merchant')->user()->id;
@endphp

@section('content')
    <div class="row">
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white">
                <form class="form-detail form-dropdown-input form-validate d-flex"
                    action="{{ route('merchant.withdraw.request.store.post') }}" method="POST"
                    id="create-request-withdraw-form">
                    @csrf
                    <div class='left-wrapper'>
                        <h6 class="title-detail-noti">
                            {{ __('merchant.withdraw.create_request') }}
                        </h6>

                        <div class="form-group row form-item mg-top-first-form ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('merchant.withdraw.store') }} *
                            </label>
                            <div class="col col-md-10">
                                <div class="form-edit-input">
                                    @if (count($storesAssigned) > 0)
                                        <input type="text" class="form-control form-control-w337" id="merchant_store_id"
                                            name="merchant_store_input"
                                            value="{{ formatAccountId($storesAssigned[0]->merchant_code) }} - {{ $storesAssigned[0]->name }}">
                                        <input type="hidden" name="merchant_store_id" value="{{ $storesAssigned[0]->id }}">
                                    @else
                                        <input type="text" class="form-control form-control-w337" value=""
                                            id="merchant_store_id" name="merchant_store_input">
                                        <input type="hidden" name="merchant_store_id" value="">
                                    @endif
                                    <button type="button" class="btn btn-edit-detail merchant-slt-btn ml-15"
                                        data-toggle="modal" data-target="#selectMerchant">
                                        {{ __('merchant.setting.profile.choose_store') }}
                                    </button>
                                    <div class="note-pass"></div>
                                </div>
                            </div>
                        </div>

                        {{-- balance box --}}
                        @include('common.page.withdraw.partial.balance_box')

                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('merchant.withdraw.date') }}
                            </label>
                            <div class="col col-md-10">
                                <input name="date" value="{{ $currentHour }}" type="datetime-local"
                                    class="date-time input_time" id="date-time-input" readonly>
                            </div>
                        </div>

                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('merchant.withdraw.member_code') }}
                            </label>
                            <div class="col col-md-10">
                                <input name="company_member_code" value="" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('merchant.withdraw.note') }}
                            </label>
                            <div class="col col-md-10">
                                <input name="note" value="" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row form-item  ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('merchant.withdraw.payment_info') }}
                            </label>
                            <div class="col col-md-10">
                                <div class="form-edit-input">
                                    <div class="select_info">
                                        <select onchange="changePaymentMethod(this.value)" name="withdraw_method"
                                            class="form_control select_form" id="payment-method-slt">
                                            @foreach ($withdrawMethods as $withdrawMethod)
                                                <option value="{{ $withdrawMethod }}">
                                                    {{ __("merchant.withdraw.withdraw_method.$withdrawMethod") }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="note-pass"></div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom mt-15">
                                {{ __('merchant.withdraw.currency_type') }}
                            </label>
                            <div class="col col-md-10 form-edit-input form-input-withdraw-request">
                                <div class="form-two-input-withdraw">
                                    <div class="select_info form-control-w128">
                                        <select onchange="changeAsset(this)"
                                            class="form_control select_form form-control-w128" id="asset-slt" disabled>
                                            @foreach ($assets as $asset)
                                                <option value="{{ $asset }}">
                                                    {{ $asset }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <input name="asset" value="{{ old('asset') ?? 'JPY' }}" type="hidden"
                                            id="asset-input">
                                    </div>

                                    <div class="form-input-mini-item">
                                        <span class="mt-15 mr-15">{{ __('merchant.withdraw.amount') }}*</span>
                                        <div class="form-noti-request">
                                            <span class="text-noti-request">
                                                {{ __('common.withdraw_management.limit_withdraw') }}:
                                                <span id="min-withdraw-elm-common"> - </span>
                                                〜
                                                <span id="max-withdraw-elm-common"> - </span>
                                            </span>
                                            <input name="amount" value="{{ old('amount') ?? '' }}" type="number"
                                                class="form-control form-control-w293 amount">
                                        </div>
                                    </div>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <!-- button footer-->
                        <div class="form-group row form-item left-button-wrapper">
                            <label for="" class="col-sm-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 ">
                                <div class="button-action">
                                    <div class="btn-w500">
                                        <button type="submit"
                                            class="btn btn-edit-detail rule rule_merchant_withdraw_create">
                                            {{ __('common.submit') }}
                                        </button>
                                        <button type="button" class="btn form-close" id="cancel-create-btn">
                                            {{ __('common.return_btn') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="right-wrapper">
                         {{-- payment-banking-box --}}
                         <div class="infor-group-transfer d-none" id="payment-banking-box">
                            <div class="form-group row form-item ">
                                <p class="col payment_information">
                                    {{ __('merchant.withdraw.payment_info_banking') }}
                                </p>
                            </div>

                            <div class="form-group row form-item  ">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.bank_code') }}*
                                </label>
                                <div class="col col-md-10 form-edit-input">
                                    <div class="form-two-input-withdraw">
                                        <div class="select_info form-control-w62">
                                            <input name="bank_code" value="" type="text"
                                                class="form-control form-control-w62" id="bank-code-input">
                                        </div>
                                        <div class="form-input-mini-item">
                                            <span class="mr-15 mb-15">{{ __('merchant.withdraw.finance_name') }}*</span>
                                            <input name="financial_institution_name" value="" type="text"
                                                class="form-control form-control-w319"
                                                id="financial-institution-name-input" readonly>
                                        </div>
                                    </div>
                                    <div class="note-pass"></div>
                                </div>
                            </div>

                            <div class="form-group row form-item  ">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.branch_code') }}*
                                </label>
                                <div class="col col-md-10 form-edit-input">
                                    <div class="form-two-input-withdraw">
                                        <div class="select_info form-control-w62">
                                            <input name="branch_code" value="" type="text"
                                                class="form-control form-control-w62" id="branch-code-input">
                                        </div>
                                        <div class="form-input-mini-item">
                                            <span class="mb-15 mr-15">{{ __('merchant.withdraw.branch') }}*</span>
                                            <input name="branch_name" value="" type="text"
                                                class="form-control form-control-w319" id="branch-name-input" readonly>
                                        </div>
                                    </div>
                                    <div class="note-pass"></div>
                                </div>
                            </div>

                            <div class="form-group row form-item  ">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.account_type') }}*
                                </label>
                                <div class="col col-md-10 form-edit-input">
                                    <div class="form-two-input-withdraw">
                                        <div class="select_info form-control-w191">
                                            <select name="bank_account_type"
                                                class="form_control select_form form-control-w191"
                                                id="bank-account-type-slt">
                                                @foreach ($bankAccountTypes as $key => $value)
                                                    <option value="{{ $value }}">
                                                        {{ __("merchant.withdraw.bank_account_type.$key") }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-input-mini-item">
                                            <label for="" class="col-form-label label-custom">
                                                {{ __('merchant.withdraw.account_number') }}*
                                            </label>
                                            <input name="bank_account_number" value="" type="text"
                                                class="form-control form-control-w128" id="bank-account-number-input">
                                        </div>
                                    </div>
                                    <div class="note-pass"></div>
                                </div>
                            </div>

                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.account_holder') }}*
                                </label>
                                <div class="col col-md-10">
                                    <div class="form-edit-input">
                                        <input name="bank_account_holder" value="" type="text"
                                            class="form-control" id="bank-account-holder-input">
                                        <div class="note-pass"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- payment-crypto-box --}}
                        <div class="infor-group-transfer d-none" id="payment-crypto-box">
                            <div class="form-group row form-item ">
                                <p class="col payment_information">
                                    {{ __('merchant.withdraw.payment_info_crypto') }}
                                </p>
                            </div>
                            <div class="form-group row form-item ">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.wallet_address') }}
                                </label>
                                <div class="col col-md-10">
                                    <div class="form-edit-input">
                                        <input name="wallet_address" value="" type="text" class="form-control"
                                            id="wallet-address-input">
                                        <div class="note-pass"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.network') }}
                                </label>
                                <div class="col col-md-10">
                                    <div class="form-edit-input">
                                        <div class="select_info">
                                            <select name="network" class="form_control select_form" id="network-input">
                                                <option value="1">
                                                    {{ __('Ethereum（ETH）') }}</option>
                                                <option value="3">
                                                    {{ __('Polygon（Matic）') }}</option>
                                                <option value="4">
                                                    {{ __('Avalanche C-Chain（AVAX）') }}</option>
                                                <option value="5">
                                                    {{ __('Fantom（FTM）') }}</option>
                                                <option value="6">
                                                    {{ __('Arbitrum One（ETH）') }}</option>
                                                <option value="7">
                                                    {{ __('Solana (SOL)') }}</option>
                                            </select>
                                        </div>
                                        <div class="note-pass"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('merchant.withdraw.payment_crypto.note') }}
                                </label>
                                <div class="col col-md-10">
                                    <div class="form-edit-input">
                                        <div class="select_info">
                                            <textarea class="form-control height-control pb-0" id="note-crypto" name="note_crypto" rows="4"></textarea>
                                        </div>
                                        <div class="note-pass"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- button footer-->
                        <div class="form-group row form-item right-button-wrapper d-none">
                            <label for="" class="col-sm-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 ">
                                <div class="button-action">
                                    <div class="btn-w500">
                                        <button type="submit"
                                            class="btn btn-edit-detail rule rule_merchant_withdraw_create">
                                            {{ __('common.submit') }}
                                        </button>
                                        <button type="button" class="btn form-close" id="cancel-create-btn">
                                            {{ __('common.return_btn') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <!-- Modal confirm -->
                @include('common.modal.confirm', [
                    'title' => __('merchant.withdraw.create_request_title_confirm'),
                    'description' => __('merchant.withdraw.create_request_des_confirm'),
                    'submit_btn' => __('common.submit'),
                ])

                @include('merchant.withdraw.request.partial.select_merchant', [
                    'stores' => $storesAssigned,
                    'init' => false
                ])
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        const CRYPTO_ASSETS = @json($cryptoAssets);
        const FIAT_ASSETS = @json($fiatAssets);
        const NETWORK_KEYS = @json($networkKeys);
        const STORES_ASSIGNED = @json($storesAssigned);
        const PAYMENT_BANKING_BOX = $("#payment-banking-box");
        const PAYMENT_CRYPTO_BOX = $("#payment-crypto-box");
        const CREATE_REQUEST_WITHDRAW_FORM = $('#create-request-withdraw-form');
        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-modal");
        const CANCEL_CREATE_BTN = $('#cancel-create-btn');

        const MERCHANT_STORE_SLT = $('input[name=merchant_store_id]');
        const PAYMENT_METHOD_SLT = $("#payment-method-slt");
        const DATE_TIME_INPUT = $("#date-time-input");
        const ASSET_SLT = $("#asset-slt");
        const ASSET_INPUT = $("#asset-input");
        const NETWORK_INPUT = $("#network-input");
        const WALLET_ADDRESS_INPUT = $("#wallet-address-input");

        const BANK_CODE_INPUT = $("#bank-code-input");
        const FINANCIAL_INSTITUTION_NAME_INPUT = $("#financial-institution-name-input");
        const BRANCH_CODE_INPUT = $("#branch-code-input");
        const BRANCH_NAME_INPUT = $("#branch-name-input");
        const BANK_ACCOUNT_NUMBER_INPUT = $("#bank-account-number-input");
        const BANK_ACCOUNT_HOLDER_INPUT = $("#bank-account-holder-input");
        const BANK_ACCOUNT_TYPE_SLT = $("#bank-account-type-slt");

        $('.items-card').addClass("d-none");
        withdrawLimits = '{{ $withdrawLimits }}' ? JSON.parse('{{ $withdrawLimits }}'.replaceAll('&quot;', '"')) : null
        assetSelected = ASSET_INPUT.val();

        function renderAssetsSelect(assets) {
            $(ASSET_SLT).selectpicker('destroy');
            $(ASSET_SLT).empty();
            $.each(assets, function(i, item) {
                // update first item to input hidden asset
                if (i === 0) {
                    $(ASSET_INPUT).val(item);
                }

                $(ASSET_SLT).append($('<option>', {
                    value: item,
                    text: item
                }));

                assetSelected = ASSET_INPUT.val();
                renderLimitWithdraw();
            });
        }

        function changeAsset(elm) {
            let asset = $(elm).val();
            $(ASSET_INPUT).val(asset);
            assetSelected = asset;
            renderLimitWithdraw();
        }

        function updateAssetValue(asset) {
            $(ASSET_SLT).selectpicker('val', asset);
            $(ASSET_SLT).selectpicker('refresh');
            $(ASSET_INPUT).val(asset);
        }

        function handleChangeMerchantStore() {
            let storeSelected = getInfoStoreSelected();
            let withdrawMethod = storeSelected.withdraw_method ?? '{{ WithdrawMethod::CASH->value }}';
            console.log(withdrawMethod, 'withdrawMethod');
            changePaymentMethod(withdrawMethod);
            $(PAYMENT_METHOD_SLT).selectpicker('val', withdrawMethod);
            $(PAYMENT_METHOD_SLT).selectpicker('refresh');

            // show balance by store
            showBalanceSummary();
        }

        function validateBankingPayment() {
            $(BANK_CODE_INPUT).rules('add', {
                checkBankCodeRule: true,
            })
            $(BRANCH_CODE_INPUT).rules('add', {
                checkBranchCodeRule: true
            })
            $(BANK_ACCOUNT_NUMBER_INPUT).rules('add', {
                required: true,
                messages: {
                    required: "{{ __('merchant.withdraw.validation.bank_account_number.required') }}",
                }
            })
            $(BANK_ACCOUNT_HOLDER_INPUT).rules('add', {
                required: true,
                checkKatakana: true,
                messages: {
                    required: "{{ __('merchant.withdraw.validation.bank_account_holder.required') }}",
                    checkKatakana: "{{ __('validation.common.checkKatakana') }}",
                }
            })
        }

        function unValidateBankingPayment() {
            $(BANK_CODE_INPUT).rules('remove', 'required');
            $(FINANCIAL_INSTITUTION_NAME_INPUT).rules('remove', 'required');
            $(BRANCH_CODE_INPUT).rules('remove', 'required');
            $(BRANCH_NAME_INPUT).rules('remove', 'required');
            $(BANK_ACCOUNT_NUMBER_INPUT).rules('remove', 'required');
            $(BANK_ACCOUNT_HOLDER_INPUT).rules('remove', 'required');
            $(BANK_ACCOUNT_HOLDER_INPUT).rules('remove', 'checkKatakana');
        }

        function validateCryptoPayment() {
            $(WALLET_ADDRESS_INPUT).rules('add', {
                required: true,
                messages: {
                    required: "{{ __('merchant.withdraw.validation.wallet_address.required') }}",
                }
            })
        }

        function unValidateCryptoPayment() {
            $(WALLET_ADDRESS_INPUT).rules('remove', 'required')
        }

        async function checkBankCode() {
            let bankCode = $(BANK_CODE_INPUT).val();
            let url = "{{ route('merchant.bank.check_bank_code') }}"
            let formData = {
                bank_code: bankCode
            }
            return $.ajax({
                method: 'POST',
                url: url,
                type: 'POST',
                data: formData,
            }).done(function(response) {
                if (response.data) {
                    let data = response.data || []
                    $(FINANCIAL_INSTITUTION_NAME_INPUT).val(data.name)
                    $(FINANCIAL_INSTITUTION_NAME_INPUT).removeClass('border-error');
                    $(`#${FINANCIAL_INSTITUTION_NAME_INPUT.attr('id')}-error`).empty();

                    $(BANK_CODE_INPUT).parent().removeClass('border-error');
                    $(`#${BANK_CODE_INPUT.attr('id')}-error`).empty();
                    // resolve();
                } else {
                    console.log(222)
                    $(BANK_CODE_INPUT).parent().addClass('border-error');
                    $(BANK_CODE_INPUT).parent().parent().parent().find('.note-pass').html(
                        `<p id="bank-code-input-error" class="error note-pass-error">
                            {{ __('merchant.withdraw.validation.bank_code.non_exist') }}
                        </p>`
                    );

                    $(FINANCIAL_INSTITUTION_NAME_INPUT).val("");
                }
            }).fail(function(err) {
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                console.log('done');
            });
        }

        async function checkBranchCode() {
            let bankCode = $(BANK_CODE_INPUT).val();
            let branchCode = $(BRANCH_CODE_INPUT).val();
            let url = "{{ route('merchant.bank.check_branch_code') }}"
            let formData = {
                bank_code: bankCode,
                branch_code: branchCode,
            }
            return $.ajax({
                method: 'POST',
                url: url,
                type: 'POST',
                data: formData,
            }).done(function(response) {
                console.log(response, 'responseresponse', FINANCIAL_INSTITUTION_NAME_INPUT.attr('id') +
                    '-error')
                if (response.data) {
                    let data = response.data || []
                    $(BRANCH_NAME_INPUT).val(data.name)
                    $(BRANCH_NAME_INPUT).removeClass('border-error');
                    $(`#${BRANCH_NAME_INPUT.attr('id')}-error`).empty();

                    $(BRANCH_CODE_INPUT).parent().removeClass('border-error');
                    $(`#${BRANCH_CODE_INPUT.attr('id')}-error`).empty();
                    // resolve();
                } else {
                    $(BRANCH_CODE_INPUT).parent().addClass('border-error');
                    $(BRANCH_CODE_INPUT).parent().parent().parent().find('.note-pass').html(
                        `<p id="branch-code-input-error" class="error note-pass-error">
                            {{ __('merchant.withdraw.validation.branch_code.non_exist') }}
                        </p>`
                    );

                    $(BRANCH_NAME_INPUT).val("")
                }
            }).fail(function(err) {
                console.log(err);
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                console.log('done');
            });
        }


        function changePaymentMethod(method) {
            switch (method) {
                case 'cash':
                    $('.cash-bank-card').removeClass('d-none');
                    $('.crypto-card').addClass('d-none');
                    $('.right-button-wrapper').addClass('d-none');
                    $('.left-button-wrapper').removeClass('d-none');
                    $(PAYMENT_BANKING_BOX).addClass('d-none');
                    $(PAYMENT_CRYPTO_BOX).addClass('d-none');
                    renderAssetsSelect(FIAT_ASSETS)
                    $(ASSET_SLT).prop('disabled', true);
                    $(ASSET_SLT).selectpicker('refresh');

                    // remove validate Banking vs Crypto
                    unValidateBankingPayment()
                    unValidateCryptoPayment()
                    break
                case 'banking':
                    $('.cash-bank-card').removeClass('d-none');
                    $('.crypto-card').addClass('d-none');
                    $('.left-button-wrapper').addClass('d-none');
                    $('.right-button-wrapper').removeClass('d-none');
                    $(PAYMENT_CRYPTO_BOX).addClass('d-none');
                    renderAssetsSelect(FIAT_ASSETS)
                    $(ASSET_SLT).prop('disabled', true);
                    $(ASSET_SLT).selectpicker('refresh');
                    getFiatAccountDefault()

                    // remove validate Crypto
                    unValidateCryptoPayment()
                    // add validate Banking
                    validateBankingPayment()

                    break
                default:
                    $('.crypto-card').removeClass('d-none');
                    $('.cash-bank-card').addClass('d-none');
                    $('.left-button-wrapper').addClass('d-none');
                    $('.right-button-wrapper').removeClass('d-none');
                    $(PAYMENT_BANKING_BOX).addClass('d-none');
                    renderAssetsSelect(CRYPTO_ASSETS)
                    $(ASSET_SLT).prop('disabled', false);
                    $(ASSET_SLT).selectpicker('refresh');
                    getCryptoAccountDefault()

                    // remove validate Banking
                    unValidateBankingPayment()
                    // add validate Crypto
                    validateCryptoPayment()

            }
        }

        function getFiatAccountDefault() {
            let merchantStoreId = $(MERCHANT_STORE_SLT).val();
            let url = '{{ route('merchant.withdraw.fiat-account-default.get', ':merchantStoreId') }}';
            url = url.replace(':merchantStoreId', merchantStoreId);
            let formData = {}
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                dataType: 'json',
                data: formData
            }).done(function(response) {
                console.log(response, 'getFiatAccountDefault');
                let data = response?.data ?? '';
                $(BANK_CODE_INPUT).val(data.bank_code || '');
                $(FINANCIAL_INSTITUTION_NAME_INPUT).val(data.financial_institution_name || '');
                $(BRANCH_CODE_INPUT).val(data.branch_code || '');
                $(BRANCH_NAME_INPUT).val(data.branch_name || '');
                $(BANK_ACCOUNT_NUMBER_INPUT).val(data.bank_account_number || '');
                $(BANK_ACCOUNT_HOLDER_INPUT).val(data.bank_account_holder || '');
                $(BANK_ACCOUNT_TYPE_SLT).selectpicker('val', data.bank_account_type);
                $(ASSET_SLT).selectpicker('refresh');

                PAYMENT_BANKING_BOX.removeClass('d-none');
                // PAYMENT_BANKING_BOX.html(html).removeClass('d-none');
            }).fail(function(err) {
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                console.log('done');
            });
        }

        function getCryptoAccountDefault() {
            let merchantStoreId = $(MERCHANT_STORE_SLT).val();
            let url = '{{ route('merchant.withdraw.crypto-account-default.get', ':merchantStoreId') }}';
            url = url.replace(':merchantStoreId', merchantStoreId);

            let formData = {}
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                dataType: 'json',
                data: formData
            }).done(function(response) {
                let data = response?.data ?? '';
                // update asset selected
                let asset = CRYPTO_ASSETS.includes(data.asset) ? data.asset : CRYPTO_ASSETS[0]
                $(ASSET_SLT).selectpicker('val', asset);
                $(ASSET_SLT).selectpicker('refresh');
                $(ASSET_INPUT).val(asset);
                assetSelected = asset

                // update render limit withdraw
                renderLimitWithdraw()

                // update network selected
                $(NETWORK_INPUT).selectpicker('val', data.network);
                $(NETWORK_INPUT).selectpicker('refresh');

                $(WALLET_ADDRESS_INPUT).val(data.wallet_address);
                $('#note-crypto').val(data.note);
                $(PAYMENT_CRYPTO_BOX).removeClass('d-none');

            }).fail(function(err) {
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                console.log('done');
            });
        }

        function showBalanceSummary() {
            let merchantStoreId = $(MERCHANT_STORE_SLT).val();
            // let merchantStoreId = 'a6e38047-f712-11ed-b024-067e34f000ba';
            let url = '{{ route('merchant.balance.summary.get', ':merchantStoreId') }}';
            url = url.replace(':merchantStoreId', merchantStoreId);
            getBalanceSummary(url);
        }

        function getInfoStoreSelected() {
            let merchantStoreId = $(MERCHANT_STORE_SLT).val();
            let store = STORES_ASSIGNED.find(item => {
                return item.id == merchantStoreId;
            })
            console.log(store, 'getInfoStoreSelected')
            if (store && store['withdraw_method'] === 'crypto') {
                $('.crypto-card').removeClass('d-none');
                $('.cash-bank-card').addClass('d-none');
            } else {
                $('.cash-bank-card').removeClass('d-none');
                $('.crypto-card').addClass('d-none');
            }

            return store
        }

        $(document).ready(function() {
            // submit data (in modal confirm)
            SUBMIT_BUTTON_COMMON.on('click', function() {
                $(this).prop("disabled", true);

                let url = '{{ route('merchant.withdraw.request.store.post') }}';
                let formData = $(CREATE_REQUEST_WITHDRAW_FORM).serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    data: formData
                }).done(function(response) {
                    if (response.status){
                        window.location.href = "{{ route('merchant.withdraw.history.index.get') }}"
                    } else {
                        SUBMIT_BUTTON_COMMON.prop("disabled", false);
                        $(CONFIRM_MODAL_COMMON).modal('hide');
                        let msg = response.message;
                        toastr.error(msg);
                    }
                })
            });

            CANCEL_CREATE_BTN.on('click', function() {
                window.location.href = `{{ route('merchant.withdraw.history.index.get') }}`;
            });

            {{-- Validate form --}}
            $.validator.addMethod("checkBankCodeRule", async function(value, element, options) {
                console.log(value, 'value01')
                if (value) {
                    await checkBankCode()
                        .then(result => {
                            console.log(result, 'result01')
                            if (result.data) {
                                return true
                            }

                            return false
                        })
                        .catch(error => {
                            console.log(error, 'error01')

                            return false
                        })
                } else {
                    $(BANK_CODE_INPUT).parent().addClass('border-error');
                    $(BANK_CODE_INPUT).parent().parent().parent().find('.note-pass').html(
                        `<p id="bank-code-input-error" class="error note-pass-error">
                           {{ __('merchant.withdraw.validation.bank_code.required') }}
                        </p>`
                    );
                    $(FINANCIAL_INSTITUTION_NAME_INPUT).val('');

                    return false;
                }
            }, "");

            $.validator.addMethod("checkBranchCodeRule", async function(value, element, options) {
                console.log(value, 'value02')
                if (value) {
                    await checkBranchCode()
                        .then(result => {
                            console.log(result, 'result02')
                            if (result.data) {
                                return true
                            }

                            return false
                        })
                        .catch(error => {
                            console.log(error, 'error02')

                            return false
                        })
                } else {
                    $(BRANCH_CODE_INPUT).parent().addClass('border-error');
                    $(BRANCH_CODE_INPUT).parent().parent().parent().find('.note-pass').html(
                        `<p id="branch-code-input-error" class="error note-pass-error">
                           {{ __('merchant.withdraw.validation.branch_code.required') }}
                        </p>`
                    );
                    $(BRANCH_NAME_INPUT).val('');

                    return false;
                }
            }, "");


            $.validator.setDefaults({
                ignore: []
            });
            CREATE_REQUEST_WITHDRAW_FORM.validate({
                rules: {
                    amount: {
                        required: true,
                        number: true,
                        checkAmount: {
                            min: "{{ __('validation.common.amount.min') }}",
                            max: "{{ __('validation.common.amount.max') }}",
                            db_not_found: "{{ __('validation.common.amount.db_not_found') }}"
                        },
                    },
                    merchant_store_input: {
                        required: true,
                    },
                },
                messages: {
                    amount: {
                        required: "{{ __('merchant.withdraw.validation.amount.required') }}",
                        number: "{{ __('validation.common.amount.number_invalid') }}",
                    },
                    merchant_store_input: {
                        required: "{{ __('merchant.withdraw.validation.merchant_select.required') }}",
                    }
                },
                errorElement: 'p',
                // show mess error
                errorPlacement: function(error, element) {
                    error.addClass('note-pass-error');
                    element.closest('.form-edit-input').find('.note-pass').append(error);
                },
                // input highlight
                highlight: function(element) {
                    $(element).addClass('border-error');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-error');
                    $(element).parent().parent().removeClass('border-error');
                },
                submitHandler: function() {
                    CONFIRM_MODAL_COMMON.modal('show');
                }
            });

            // get store selected -> view withdraw default
            handleChangeMerchantStore()

            // show limit withdraw of one by one currency
            renderLimitWithdraw();

            // show balance by store
            showBalanceSummary();

            getInfoStoreSelected();
        });

        $('#asset-slt').change(function () {
            var receivedVirtuaType = this.value;
            if (receivedVirtuaType === 'JPYC') {
                $('#network-input option[value="5"]').hide();
                $('#network-input option[value="7"]').hide();
                if($('#network-input').val() == 5 || $('#network-input').val() == 7)
                    $('#network-input').val(1);
            }
            else {
                $('#network-input option[value="5"]').show();
                $('#network-input option[value="7"]').show();
            }
            $('#network-input').selectpicker('refresh');
        });
    </script>
@endpush
