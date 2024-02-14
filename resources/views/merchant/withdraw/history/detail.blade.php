@extends('merchant.layouts.base')
@section('title', __('merchant.withdraw.withdrawal_history_detail'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_payeeInformation.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/MER_03_03.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
@endpush

@php
    use App\Enums\WithdrawRequestMethod;
    use App\Enums\WithdrawMethod;
    use App\Enums\WithdrawAsset;
    use App\Enums\WithdrawStatus;
    $withdrawMethods = [WithdrawMethod::CASH->value, WithdrawMethod::BANKING->value, WithdrawMethod::CRYPTO->value];
    $withdrawRequestMethods = [WithdrawRequestMethod::REQUEST_EPAY->value, WithdrawRequestMethod::REQUEST_MERCHANT->value, WithdrawRequestMethod::AUTO->value];
    $withdrawStatus = [WithdrawStatus::WAITING_APPROVE->value, WithdrawStatus::DENIED->value, WithdrawStatus::SUCCEEDED->value];
    $cryptoAssets = [WithdrawAsset::JPYC->value, WithdrawAsset::USDC->value, WithdrawAsset::USDT->value, WithdrawAsset::DAI->value];
    $fiatAssets = [WithdrawAsset::JPY->value];
    $assets = array_merge($fiatAssets, $cryptoAssets);
    $currentHour = now()->format('Y-m-d H:i');
    $merchantUserId = auth('merchant')->user()->id;
@endphp

@section('content')
    <div class="row">
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="form-detail form-validate"
                    action="{{ route('merchant.withdraw.history.update.post', ['id' => $withdraw->id]) }}" method="POST"
                    id="update-withdraw-form">
                    @csrf
                    <h6 class="title-detail-noti detail-container">{{ __('merchant.withdraw.withdrawal_history_detail') }}</h6>
                    <h6 class="title-detail-noti edit-container d-none">{{ __('merchant.withdraw.withdrawal_history_edit') }}</h6>

                    <div class="form-group row form-item  ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.transaction_id') }}
                        </label>
                        <div class="col col-md-10">
                            <div class=" form-two-input-withdraw tooltip-container">
                                <input value="{{ $withdraw->id }}" type="text"
                                    class="form-control form-control-w200 input-tooltip" id="withdraw_id"
                                    title="{{ $withdraw->id }}" readonly>
                                <div class="form-input-mini-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('merchant.withdraw.request_id') }}
                                    </label>
                                    <input value="{{ $withdraw->order_id }}" type="text"
                                        class="form-control form-control-w200" readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item mg-top-first-form merchant-store-search-container d-none">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.merchant') }}*
                        </label>
                        <div class="col col-md-10">
                            <div class="form-edit-input">
                                @foreach ($storesAssigned as $item)
                                    @if (old('merchant_store_id', $withdraw->merchant_store_id) == $item->id)
                                        <input disabled type="text" class="form-control form-control-w337"
                                            value="{{ formatAccountId($item->merchant_code) }} - {{ $item->name }}">
                                    @endif
                                @endforeach
                                <button type="button" class="btn btn-edit-detail merchant-slt-btn ml-15" disabled>
                                    {{ __('merchant.setting.profile.choose_store') }}
                                </button>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item merchant-store-slt-container">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.merchant') }}
                        </label>
                        <div class="col col-md-10">
                            <div class="form-edit-input">
                                <div class="select_info">
                                    <select onchange="changeMerchantStore(this.value)" name="merchant_store_id"
                                        class="form_control select_form" id="merchant-store-slt" disabled>
                                        @foreach ($storesAssigned as $item)
                                            <option @if (old('merchant_store_id', $withdraw->merchant_store_id) == $item->id) selected @endif
                                                value="{{ $item->id }}">
                                                {{ formatAccountId($item->merchant_code) }} - {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="note-pass">
                                </div>
                            </div>
                        </div>
                    </div>

                     {{-- balance box --}}
                     <div class='balance-box-container d-none'>
                        @include('common.page.withdraw.partial.balance_box')
                    </div>

                    <div class="form-group row form-item noti-detai-type ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.financial_institution_name') }}
                        </label>
                        <div class="col col-md-10">
                            <input value="{{ $withdraw->withdraw_name ?? '' }}" type="text" class="form-control"
                                readonly>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.member_id_code') }}
                        </label>
                        <div class="col col-md-10">
                            <input name="company_member_code" value="{{ $withdraw->company_member_code }}" type="text"
                                class="form-control editable" readonly>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.request_date') }}
                        </label>
                        <div class="col col-md-10">
                            <input value="{{ $withdraw->created_at->format('Y-m-d H:i') }}" type="datetime-local"
                                class="date-time input_time" readonly>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.content') }}
                        </label>
                        <div class="col col-md-10">
                            <input name="note" value="{{ $withdraw->note }}" type="text"
                                class="form-control editable" readonly>
                        </div>
                    </div>

                    <div class="form-group row form-item  ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.publisher') }}
                        </label>
                        <div class="col col-md-10">
                            <div class="form-two-input-withdraw">
                                <div class="select_info form-control-w189">
                                    <select {{-- onchange="changePaymentMethod1(this.value)" --}} name="withdraw_request_method"
                                        class="form_control select_form form-control-w189"
                                        id="withdraw-request-method-slt" disabled>
                                        @foreach ($withdrawRequestMethods as $withdrawRequestMethod)
                                            <option @if (old('withdraw_request_method', $withdraw->withdraw_request_method) == $withdrawRequestMethod) selected @endif
                                                value="{{ $withdrawRequestMethod }}">
                                                {{ __("common.withdraw_management.withdraw_$withdrawRequestMethod") }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-input-mini-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('merchant.withdraw.status') }}
                                    </label>
                                    <div class="select_info">
                                        <select name="withdraw_method" class="form_control select_form form-control-w200"
                                            id="withdraw_method-slt" disabled>
                                            @foreach ($withdrawStatus as $item)
                                                <option @if (old('withdraw_status', $withdraw->withdraw_status) == $item) selected @endif
                                                    value="{{ $item }}">
                                                    {{ __("merchant.withdraw.withdraw_status.$item") }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.payment_information') }}
                        </label>
                        <div class="col col-md-10 form-input-select">
                            <div class="select_info">
                                <select name="withdraw_status" class="form_control select_form" id="withdraw-status-slt"
                                    disabled>
                                    @foreach ($withdrawMethods as $withdrawMethod)
                                        <option @if (old('withdraw_method', $withdraw->withdraw_method) == $withdrawMethod) selected @endif
                                            value="{{ $withdrawMethod }}">
                                            {{ __("merchant.withdraw.withdraw_method.$withdrawMethod") }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            @if ($withdraw->withdraw_method == WithdrawMethod::BANKING->value)
                                <button data-toggle="modal" data-target="#payment-modal" type="button"
                                    class="btn form-select">
                                    {{ __('merchant.withdraw.payee_information_display') }}
                                </button>
                            @elseif($withdraw->withdraw_method == WithdrawMethod::CRYPTO->value)
                                <button data-toggle="modal" data-target="#crypto-modal" type="button"
                                    class="btn form-select">
                                    {{ __('merchant.withdraw.payee_information_display') }}
                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row form-item form-item-request">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.currency_type') }}
                        </label>
                        <div class="col col-md-10 form-edit-input form-input-withdraw-request">
                            <div class="form-two-input-withdraw">
                                <div class="select_info form-control-w128">
                                    <select name="asset" class="form_control select_form form-control-w128"
                                        id="asset-slt" disabled>
                                        @foreach ($assets as $asset)
                                            <option @if (old('asset', $withdraw->asset) == $asset) selected @endif
                                                value="{{ $asset }}">
                                                {{ $asset }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-input-mini-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('merchant.withdraw.withdrawal_amount') }}*
                                    </label>

                                    <div class="form-noti-request">
                                        <span class="text-noti-request">
                                            {{ __('common.withdraw_management.limit_withdraw') }}:
                                            <span id="min-withdraw-elm-common"> - </span>
                                            〜
                                            <span id="max-withdraw-elm-common"> - </span>
                                        </span>

                                        <input name="amount" value="{{ formatNumberDecimal($withdraw->amount, 3) }}"
                                            type="text" class="form-control form-control-w200 editable number"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="note-pass"></div>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.withdrawal_processing_date') }}
                        </label>
                        <div class="col col-md-10">
                            <input value="{{ $withdraw->approve_datetime }}" type="datetime-local"
                                class="date-time input_time" readonly>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <input value="detail" type="hidden" id="switch-mode-input">
                        <label for="" class="col-sm-2 col-form-label label-custom"></label>
                        <div class="col col-md-10 ">
                            <div class="button-action">
                                <div class="btn-w500 d-flex justify-content-end">
                                    @php
                                        $checker = $withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value && $withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value;
                                    @endphp
                                    <a href="{{ route('merchant.withdraw.history.index.get') }}" id="back-btn">
                                        <button type="button" class="btn form-close">
                                            {{ __('common.button.back') }}
                                        </button>
                                    </a>
                                </div>

                                <button type="button"
                                    class="btn btn-delete-detail rule rule_merchant_withdraw_delete {{ $checker ? '' : 'transparent-disable' }}"
                                    id="delete-withdraw-btn" data-toggle="modal" data-target="#confirm-modal-delete">
                                    {{ __('common.button.delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- modal payment method  --}}
            @include('merchant.withdraw.history.modal.payment_banking', [
                'bankingInfo' => (object) $withdraw->bank_info,
            ])
            @include('merchant.withdraw.history.modal.payment_crypto', [
                'cryptoInfo' => (object) $withdraw->crypto_info,
            ])

            {{-- modal confirm  --}}
            @include('common.modal.confirm', [
                'title' => __('merchant.withdraw.update_title_confirm'),
                'description' => __('merchant.withdraw.update_des_confirm'),
                'submit_btn' => __('common.button.send'),
            ])
            @include('common.modal.confirm_delete', [
                'title' => __('merchant.withdraw.delete_title_confirm'),
                'description' => __('merchant.withdraw.delete_des_confirm'),
                'url' => route('merchant.withdraw.history.delete.get', ['id' => object_get($withdraw, 'id')]),
                'id' => 'confirm-modal-delete',
            ])
        </div>
    </div>
@endsection

@push('script')
    <script>
        const UPDATE_WITHDRAW_FORM = $("#update-withdraw-form");
        const SWITCH_MODE_INPUT = $("#switch-mode-input");
        const DELETE_WITHDRAW_BTN = $("#delete-withdraw-btn");
        const BACK_BTN = $("#back-btn");

        @if ($withdraw->withdraw_method == 'crypto')
            $('.crypto-card').removeClass('d-none');
            $('.cash-bank-card').addClass('d-none');
        @else
            $('.cash-bank-card').removeClass('d-none');
            $('.crypto-card').addClass('d-none');
        @endif

        $(".merchant-slt-btn").mouseenter(function() {
            $(this).css({
                "color": "white"
            });
        });

        withdrawLimits = '{{ $withdrawLimits }}' ? JSON.parse('{{ $withdrawLimits }}'.replaceAll('&quot;', '"')) : null
        assetSelected = '{{ $withdraw->asset }}';

        // go to mode edit
        function editWithdraw(elm) {
            $('.balance-box-container').removeClass('d-none');
            $('.merchant-store-slt-container').addClass('d-none');
            $('.merchant-store-search-container').removeClass('d-none');
            $('.detail-container').addClass('d-none');
            $('.edit-container').removeClass('d-none');

            // mode: detail (view detail)  |  edit (update info)
            let mode = $(SWITCH_MODE_INPUT).val();
            if (mode == 'detail') {
                $(".editable").attr("readonly", false).attr("disabled", false);
                $(SWITCH_MODE_INPUT).val('edit');
                $(DELETE_WITHDRAW_BTN).addClass('transparent-disable');
                BACK_BTN.removeAttr('href');
                BACK_BTN.attr('href', '{{ route('merchant.withdraw.history.detail.get', $withdraw->id) }}');
            } else {
                $(UPDATE_WITHDRAW_FORM).trigger('submit');
            }
        }

        function showBalanceSummary() {
            let merchantStoreId = "{{ $withdraw->merchant_store_id }}"
            let url = '{{ route('merchant.balance.summary.get', ':merchantStoreId') }}';
            url = url.replace(':merchantStoreId', merchantStoreId);
            getBalanceSummary(url);
        }

        $(document).ready(function() {
            renderLimitWithdraw();

            showBalanceSummary();

            // submit data (in modal confirm)
            SUBMIT_BUTTON_COMMON.on('click', function() {
                $('.number').val($('.number').val().replace(/,/g, ''));
                UPDATE_WITHDRAW_FORM[0].submit();
            });

            {{-- Validate form --}}
            $.validator.setDefaults({
                ignore: []
            });
            UPDATE_WITHDRAW_FORM.validate({
                rules: {
                    amount: {
                        required: true,
                        checkAmount: {
                            min: "{{ __('validation.common.amount.min') }}",
                            max: "{{ __('validation.common.amount.max') }}",
                            db_not_found: "{{ __('validation.common.amount.db_not_found') }}"
                        },
                    },
                },
                messages: {
                    amount: {
                        required: "{{ __('merchant.withdraw.validation.amount.required') }}",
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
                    $(element).parent().removeClass('border-error');
                },
                submitHandler: function() {
                    CONFIRM_MODAL_COMMON.modal('show');
                }
            });

            var input = $('#withdraw_id');
            var tooltip = $('<span class="tooltip" id="tooltip-withdraw"></span>');

            // Append the tooltip element to the tooltip container
            input.parent().append(tooltip);

            // Show/hide the tooltip on hover
            input.parent().hover(function() {
                tooltip.css('visibility', 'visible').css('opacity', '1');
            }, function() {
                tooltip.css('visibility', 'hidden').css('opacity', '0');
            });
        });
    </script>
@endpush
