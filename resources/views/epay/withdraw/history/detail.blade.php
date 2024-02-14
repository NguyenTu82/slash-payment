@extends('epay.layouts.base')
@section('title', __('merchant.withdraw.withdrawal_history_detail'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_payeeInformation.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/MER_03_03.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
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
            <div class="form-detail">
                <h6 class="title-detail-noti">{{ __('merchant.withdraw.withdrawal_history_detail') }}</h6>

                <div class="form-group row form-item">
                    <label class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.transaction_id') }}
                    </label>
                    <div class="col col-md-10">
                        <div class="form-two-input-withdraw tooltip-container">
                            <input type="text" class="form-control form-control-w200 input-tooltip" disabled
                                   id="withdraw_id" title="{{$withdraw->id}}"
                                   value="{{$withdraw->id}}">
                            <div class="form-input-mini-item">
                                <label for="" class="col-form-label label-custom">
                                    {{ __('merchant.withdraw.request_id') }}
                                </label>
                                <input  type="text" class="form-control form-control-w200" disabled value="{{$withdraw->order_id}}">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row form-item  ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.merchant') }}
                    </label>
                    <div class="col col-md-10">
                        <div class="form-edit-input">
                            <div class="select_info">
                                <input type="text" class="form-control" disabled value="{{ formatAccountId($withdraw->merchant_code) }} - {{$withdraw->merchant_store_name}}">
                            </div>
                            <div class="note-pass" hidden>
                                <p class="note-pass-error"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group row form-item noti-detai-type ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('common.withdraw_management.withdraw_name') }}
                    </label>
                    <div class="col col-md-10">
                        <input type="text" class="form-control" disabled value="{{ $withdraw->withdraw_name ?? '' }}">
                    </div>
                </div>

                <div class="form-group row form-item ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.member_id_code') }}
                    </label>
                    <div class="col col-md-10">
                        <input type="text" class="form-control" disabled value="{{$withdraw->company_member_code}}">
                    </div>
                </div>
                <div class="form-group row form-item ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.request_date') }}
                    </label>
                    <div class="col col-md-10">
                        <input class="date-time input_time" type="datetime-local" value="{{ $withdraw->created_at->format('Y-m-d H:i') }}" disabled >
                    </div>
                </div>
                <div class="form-group row form-item ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.content') }}
                    </label>
                    <div class="col col-md-10">
                        <input type="text" class="form-control" disabled value="{{$withdraw->note}}">
                    </div>
                </div>
                <div class="form-group row form-item  ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.publisher') }}
                    </label>
                    <div class="col col-md-10 input-action-select">
                        <div class="form-two-input-withdraw">
                            <div class="select_info form-control-w189">
                                <select disabled
                                    class="form_control select_form form-control-w189">
                                    @if ($withdraw->withdraw_request_method == WithdrawRequestMethod::AUTO->value)
                                        <option selected> {{ __('common.withdraw_management.withdraw_auto') }} </option>
                                    @elseif ($withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_EPAY->value)
                                        <option selected> {{ __('common.withdraw_management.withdraw_request_epay') }} </option>
                                    @elseif ($withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value)
                                        <option selected> {{ __('common.withdraw_management.withdraw_request_merchant') }} </option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-input-mini-item">
                                <label for="" class="col-form-label label-custom">
                                    {{ __('merchant.withdraw.status') }}
                                </label>
                                <div class="select_info">
                                    <select disabled class="form_control select_form form-control-w200" >
                                        @if ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value)
                                            <option selected> {{ __('merchant.withdraw.withdraw_status.waiting_approve') }} </option>
                                        @elseif ($withdraw->withdraw_status == WithdrawStatus::DENIED->value)
                                            <option selected> {{ __('merchant.withdraw.withdraw_status.denied') }} </option>
                                        @elseif ($withdraw->withdraw_status == WithdrawStatus::SUCCEEDED->value)
                                            <option selected> {{ __('merchant.withdraw.withdraw_status.succeeded') }} </option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        @if ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value)
                        <div class="button-action-select">
                            <form id="form-approve" action="{{route('admin_epay.withdraw.history.approve', $withdraw->withdraws_id)}}" method="POST">
                                @csrf
                            </form>
                            <form id="form-decline" action="{{route('admin_epay.withdraw.history.decline', $withdraw->withdraws_id)}}" method="POST">
                                @csrf
                            </form>
                            <button
                                type="button"
                                class="btn btn-edit-detail "
                                id="approve_withdraw">
                                {{ __('common.button.approve') }}
                            </button>
                            <button
                                type="button"
                                class="btn btn-rejection"
                                id="decline_withdraw">
                                {{ __('common.button.decline') }}
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row form-item ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.payment_information') }}
                    </label>
                    <div class="col col-md-10 form-input-select">
                        <div class="select_info">
                            <select disabled class="form_control select_form" >
                                <option>{{$withdraw->withdraw_method}}</option>
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
                            @if($withdraw->withdraw_method ==WithdrawMethod::BANKING->value)
                            <button data-toggle="modal" data-target="#payment-modal" type="button" class="btn form-select">
                                {{ __('merchant.withdraw.payee_information_display') }}
                            </button>
                            @elseif($withdraw->withdraw_method ==WithdrawMethod::CRYPTO->value)
                            <button data-toggle="modal" data-target="#crypto-modal" type="button" class="btn form-select">
                                {{ __('merchant.withdraw.payee_information_display') }}
                            </button>
                            @endif
                        @elseif ($withdraw->withdraw_status == WithdrawStatus::SUCCEEDED->value || $withdraw->withdraw_status == WithdrawStatus::DENIED->value || $withdraw->withdraw_status == WithdrawStatus::TGW_WAITING_APPROVE->value)
                            @if($withdraw->withdraw_method ==WithdrawMethod::BANKING->value)
                            <button data-toggle="modal" data-target="#payment-modal" type="button" class="btn form-select">
                                {{ __('merchant.withdraw.payee_information_display') }}
                            </button>
                            @elseif($withdraw->withdraw_method ==WithdrawMethod::CRYPTO->value)
                            <button data-toggle="modal" data-target="#crypto-modal" type="button" class="btn form-select">
                                {{ __('merchant.withdraw.payee_information_display') }}
                            </button>
                            @endif
                        @endif
                    </div>
                </div>

                <div class="form-group row form-item  form-item-request">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.currency_type') }}
                    </label>
                    <div class="col col-md-10 form-edit-input">
                        <div class="form-two-input-withdraw">
                            <div class="select_info form-control-w128">
                                <select disabled class="form_control select_form form-control-w128">
                                    <option selected>{{$withdraw->asset}}</option>
                                </select>
                            </div>
                            <div class="form-input-mini-item">
                                <label class="col-form-label label-custom">
                                    {{ __('merchant.withdraw.withdrawal_amount') }}*
                                </label>
                                <div class="form-noti-request">
                                    <span class="text-noti-request">
                                        {{ __('common.withdraw_management.limit_withdraw') }}:
                                        <span id="min-withdraw-elm-common"> - </span>
                                        〜
                                        <span id="max-withdraw-elm-common"> - </span>
                                    </span>

                                    <input type="text" class="form-control form-control-w200" disabled
                                           value="{{formatNumberDecimal($withdraw->amount, 3)}}">
                                </div>
                            </div>
                        </div>
                        <div class="note-pass" hidden>
                            <p class="note-pass-error"></p>
                        </div>
                    </div>
                </div>

                <div class="form-group row form-item ">
                    <label for="" class="col col-md-2 col-form-label label-custom">
                        {{ __('merchant.withdraw.withdrawal_processing_date') }}
                    </label>
                    <div class="col col-md-10">
                        <input class="date-time input_time" disabled type="datetime-local" value="{{$withdraw->approve_datetime}}">
                    </div>
                </div>

                <div class="form-group row form-item">
                    <label for="" class="col-sm-2 col-form-label label-custom"></label>
                    <div class="col col-md-10 ">
                        <div class="button-action">
                            <div class="btn-w500">
                                <a class="rule rule_epay_withdraw_edit" href="{{route("admin_epay.withdraw.history.edit.get", $withdraw->withdraws_id)}}">
                                <button type="button" class="btn btn-edit-detail
                                    {{ ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value &&
                                        $withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value) ? '' : ' transparent-disable' }}">
                                        {{ __('common.button.edit') }}
                                </button>
                                </a>
                                <a class="rule rule_epay_withdraw_list" href="{{ route('admin_epay.withdraw.history.index.get') }}">
                                    <button type="button" class="btn form-close"> {{ __('common.button.back') }}</button>
                                </a>
                            </div>
                            <button type="button" id="delete-account"
                                    class="btn btn-delete-detail rule rule_epay_withdraw_delete
                                    {{ ($withdraw->withdraw_status == WithdrawStatus::WAITING_APPROVE->value &&
                                        $withdraw->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value) ? '' : ' transparent-disable' }}">
                                        {{ __('common.button.delete') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- modal payment method  --}}
        @include('merchant.withdraw.history.modal.payment_banking', [])
        @include('merchant.withdraw.history.modal.payment_crypto', [])
        @if($withdraw->withdraw_method == WithdrawMethod::BANKING->value)
            @include('common.modal.confirm', [
                    'title' => __('merchant.withdraw.title_approve'),
                    'description' => __('merchant.withdraw.description_approve_bank'),
                    'submit_btn' => __('common.button.approve'),
                ])
        @endif

        @if($withdraw->withdraw_method == WithdrawMethod::CASH->value || $withdraw->withdraw_method == WithdrawMethod::CRYPTO->value)
            @include('common.modal.confirm', [
                'title' => __('merchant.withdraw.title_approve'),
                'description' => __('merchant.withdraw.description_approve_cash_crypto'),
                'submit_btn' => __('common.button.approve'),
            ])
        @endif
        @include('common.modal.decline', [
            'title' => __('merchant.withdraw.title_decline'),
            'description' => __('merchant.withdraw.description_decline'),
            'submit_btn' => __('common.button.decline'),
        ])
        @include('common.modal.confirm_delete', [
            'title' => __('merchant.withdraw.title_delete'),
            'description' => __('merchant.withdraw.description_delete'),
            'url' => route('admin_epay.withdraw.history.delete', $withdraw->withdraws_id),
            'id' => 'confirm-modal-delete'
        ])
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        withdrawLimits = '{{ $withdrawLimits }}' ? JSON.parse('{{ $withdrawLimits }}'.replaceAll('&quot;','"')):null
        assetSelected = '{{$withdraw->asset}}';

        $(document).ready(function () {
            renderLimitWithdraw();

            const input = $('#withdraw_id');
            const tooltip = $('<span class="tooltip" id="tooltip-withdraw"></span>');

            // Append the tooltip element to the tooltip container
            input.parent().append(tooltip);

            // Show/hide the tooltip on hover
            input.parent().hover(function() {
                tooltip.css('visibility', 'visible').css('opacity', '1');
            }, function() {
                tooltip.css('visibility', 'hidden').css('opacity', '0');
            });

            $('#delete-account').click(()=>{
                $('#confirm-modal-delete').modal("show")
            })

            $('#approve_withdraw').click(() => {
                $('#confirm-modal').modal('show')
            })

            $('#decline_withdraw').click(()=>{
                $('#decline-modal').modal('show')
            })

            $('#submit-form').on('click', function () {
                $(this).prop("disabled", true);
               $('#form-approve').submit()
            });

            $('#submit-decline').on('click', function () {
                $(this).prop("disabled", true);
                $('#form-decline').submit()
            });
        })
    </script>
@endpush
