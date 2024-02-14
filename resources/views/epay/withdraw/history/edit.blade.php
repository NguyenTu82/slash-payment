@extends('epay.layouts.base')
@section('title', __('merchant.withdraw.withdrawal_history_detail'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_payeeInformation.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/MER_03_03.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">

    <style>
        .modal.modal-popup-confirm.fade.show {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal.fade.common-modal.common-modal-confirm.show {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .common-modal-confirm {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>
@endpush

@php
    use App\Enums\WithdrawStatus;
    use App\Enums\WithdrawRequestMethod;
    use App\Enums\WithdrawMethod;
@endphp

@section('content')
    <div class="row">
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white">
                <form class="form-detail" id="edit-withdraw" method="POST"
                    action="{{ route('admin_epay.withdraw.history.edit.post', $withdraw->withdraws_id) }}">
                    @csrf
                    <h6 class="title-detail-noti">{{ __('merchant.withdraw.withdrawal_history_edit') }}</h6>

                    <div class="form-group row form-item  ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.transaction_id') }}
                        </label>
                        <div class="col col-md-10">
                            <div class=" form-two-input-withdraw">
                                <input type="text" class="form-control form-control-w200" disabled
                                    value="{{ $withdraw->id }}">
                                <div class="form-input-mini-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('merchant.withdraw.request_id') }}
                                    </label>
                                    <input type="text" class="form-control form-control-w200" disabled
                                        value="{{ $withdraw->order_id }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row form-item mg-top-first-form ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.merchant') }}*
                        </label>
                        <div class="col col-md-10">
                            <div class="form-edit-input">
                                <input disabled type="text" class="form-control form-control-w337"
                                    value="{{ formatAccountId($withdraw->merchant_code) }} - {{ $withdraw->merchant_store_name }}"
                                    id="merchant_store_id" name="merchant_store_input">
                                <button type="button" class="btn btn-edit-detail merchant-slt-btn ml-15" disabled>
                                    {{ __('merchant.setting.profile.choose_store') }}
                                </button>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                    </div>

                    {{-- balance box --}}
                    @include('common.page.withdraw.partial.balance_box')

                    <div class="form-group row form-item noti-detai-type ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.financial_institution_name') }}
                        </label>
                        <div class="col col-md-10">
                            <input type="text" class="form-control" disabled
                                value="{{ $withdraw->financial_institution_name }}">
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.member_id_code') }}
                        </label>
                        <div class="col col-md-10">
                            <input type="text" class="form-control" name="company_member_code"
                                value="{{ $withdraw->company_member_code }}">
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.request_date') }}
                        </label>
                        <div class="col col-md-10">
                            <input class="date-time input_time" type="datetime-local" value="{{ $withdraw->created_at }}"
                                disabled>
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.content') }}
                        </label>
                        <div class="col col-md-10">
                            <input type="text" class="form-control" name="note" value="{{ $withdraw->note }}">
                        </div>
                    </div>
                    <div class="form-group row form-item  ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.publisher') }}
                        </label>
                        <div class="col col-md-10 input-action-select">
                            <div class="form-two-input-withdraw">
                                <div class="select_info form-control-w189">
                                    <select disabled class="form_control select_form form-control-w189">
                                        @if ($withdraw->withdraw_request_method == WithdrawRequestMethod::AUTO->value)
                                            <option selected> {{ __('common.withdraw_management.withdraw_auto') }}
                                            </option>
                                        @elseif ($withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_EPAY->value)
                                            <option selected> {{ __('common.withdraw_management.withdraw_request_epay') }}
                                            </option>
                                        @elseif ($withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value)
                                            <option selected>
                                                {{ __('common.withdraw_management.withdraw_request_merchant') }} </option>
                                        @endif
                                    </select>
                                </div>
                                <div class="form-input-mini-item">
                                    <label for="" class="col-form-label label-custom">
                                        {{ __('merchant.withdraw.status') }}
                                    </label>
                                    <div class="select_info">
                                        <select disabled class="form_control select_form form-control-w200">
                                            @if ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value)
                                                <option selected>
                                                    {{ __('merchant.withdraw.withdraw_status.waiting_approve') }} </option>
                                            @elseif ($withdraw->withdraw_status == WithdrawStatus::DENIED->value)
                                                <option selected> {{ __('merchant.withdraw.withdraw_status.denied') }}
                                                </option>
                                            @elseif ($withdraw->withdraw_status == WithdrawStatus::SUCCEEDED->value)
                                                <option selected> {{ __('merchant.withdraw.withdraw_status.succeeded') }}
                                                </option>
                                            @endif
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
                                <select disabled class="form_control select_form">
                                    <option>{{ $withdraw->withdraw_method }}</option>
                                    @if ($withdraw->withdraw_method == WithdrawMethod::CASH->value)
                                        <option selected> {{ __('merchant.withdraw.withdraw_method.cash') }} </option>
                                    @elseif ($withdraw->withdraw_method == WithdrawMethod::BANKING->value)
                                        <option selected> {{ __('merchant.withdraw.withdraw_method.banking') }} </option>
                                    @elseif ($withdraw->withdraw_method == WithdrawMethod::CRYPTO->value)
                                        <option selected> {{ __('merchant.withdraw.withdraw_method.crypto') }} </option>
                                    @endif
                                </select>
                            </div>

                            @if ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value)
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
                            @elseif (
                                $withdraw->withdraw_status == WithdrawStatus::SUCCEEDED->value ||
                                    $withdraw->withdraw_status == WithdrawStatus::DENIED->value)
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
                                    <select disabled class="form_control select_form form-control-w128">
                                        <option selected>
                                            {{ $withdraw->asset }}
                                        </option>
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
                                        <input type="text" name="amount"
                                            class="form-control form-control-w200 number"
                                            value="{{ $withdraw->amount }}">
                                    </div>
                                </div>
                            </div>
                            <div class="note-pass" id="amount-note-pass"></div>
                        </div>
                    </div>

                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.withdraw.withdrawal_processing_date') }}
                        </label>
                        <div class="col col-md-10">
                            <input class="date-time input_time" disabled type="datetime-local"
                                value="{{ $withdraw->approve_datetime }}">
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col-sm-2 col-form-label label-custom"></label>
                        <div class="col col-md-10 ">
                            <div class="button-action">
                                <div class="btn-w500">
                                    <button type="submit"
                                        class="btn btn-edit-detail
                                    {{ $withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value &&
                                    $withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value
                                        ? ''
                                        : ' transparent-disable' }}">
                                        {{ __('common.button.submit') }}
                                    </button>
                                    <a
                                        href="{{ route('admin_epay.withdraw.history.detail.get', $withdraw->withdraws_id) }}">
                                        <button type="button" class="btn form-close"> {{ __('common.button.back') }}
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- modal payment method  --}}
            @include('merchant.withdraw.history.modal.payment_banking', [
                'url' => route('merchant.notification.delete.get', ['id' => object_get($withdraw, 'id')]),
                'id' => '',
            ])
            @include('merchant.withdraw.history.modal.payment_crypto', [
                'url' => route('merchant.notification.delete.get', ['id' => object_get($withdraw, 'id')]),
                'id' => '',
            ])
            @include('common.modal.confirm', [
                'title' => __('merchant.withdraw.title_update'),
                'description' => __('merchant.withdraw.description_update'),
                'submit_btn' => __('common.button.edit'),
            ])
        </div>
    </div>
@endsection

@push('script')
    <script>
        withdrawLimits = '{{ $withdrawLimits }}' ? JSON.parse('{{ $withdrawLimits }}'.replaceAll('&quot;', '"')) : null
        assetSelected = '{{ $withdraw->asset }}';

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

        function showBalanceSummary() {
            let merchantStoreId = "{{ $withdraw->merchant_store_id }}"
            let url = '{{ route('admin_epay.balance.summary.get', ':merchantStoreId') }}';
            url = url.replace(':merchantStoreId', merchantStoreId);
            getBalanceSummary(url);
        }

        $(document).ready(function() {
            renderLimitWithdraw();

            showBalanceSummary();

            $('#submit-form').on('click', function() {
                $(this).prop("disabled", true);
                $('.number').val($('.number').val().replace(/,/g, ''));
                $('#edit-withdraw')[0].submit();
            });

            $("#edit-withdraw").validate({
                rules: {
                    amount: {
                        required: true,
                        checkAmount: {
                            min: "{{ __('validation.common.amount.min') }}",
                            max: "{{ __('validation.common.amount.max') }}",
                            db_not_found: "{{ __('validation.common.amount.db_not_found') }}"
                        },
                    }
                },
                messages: {
                    amount: {
                        required: "{{ __('merchant.withdraw.validation.amount.required') }}",
                    }
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    const name = $(element).attr('name');
                    $(`#${name}-note-pass`).find('.error').remove();
                    error.addClass('note-pass-error');
                    $(`#${name}-note-pass`).append(error);
                },
                highlight: function(element) {
                    $(element).addClass('border-error');
                },
                unhighlight: function(element) {
                    const name = $(element).attr('name');
                    $(`#${name}-note-pass `).find('.error').remove();
                    $(element).removeClass('border-error');
                },
                submitHandler: function() {
                    $('#confirm-modal').modal('show')
                }
            })
        });
    </script>
@endpush
