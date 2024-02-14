@extends('merchant.layouts.base')
@section('title', __('common.withdraw_management.withdraw_history'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/MER_03.css') }}">
@endpush
@php
    use App\Enums\WithdrawRequestMethod;
    use App\Enums\WithdrawMethod;
    use App\Enums\WithdrawStatus;
    use App\Enums\WithdrawAsset;
@endphp

@section('content')
    <div class="row">
        <div class="col-12 mt-15">
            <div class="list_search bg-white d-flex">
                <form class="form-search">
                    <div class="form-input">
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.transaction_id') }}</p>
                            <input type="text" class="form-control form-w200 input_infor" name="transaction_id"
                                value="{{ $request->transaction_id }}" />
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.merchant_store_id') }}</p>
                            <input type="text" class="form-control form-w200 input_infor" name="merchant_store_id"
                                value="{{ $request->merchant_store_id }}" />
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.merchant_store_name') }}</p>
                            <input type="text" class="form-control input_infor" name="merchant_store_name"
                                value="{{ $request->merchant_store_name }}" />
                        </div>
                         <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.unit') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option asset-custom" name="asset">
                                    <option value="">{{ __('common.withdraw_management.all') }}</option>
                                    <option value="{{ WithdrawAsset::JPY->value }}"
                                        @if ($request->asset == WithdrawAsset::JPY->value) selected @endif>
                                        {{ WithdrawAsset::JPY->value }} </option>
                                    <option value="{{ WithdrawAsset::USDT->value }}"
                                        @if ($request->asset == WithdrawAsset::USDT->value) selected @endif>
                                        {{ WithdrawAsset::USDT->value }} </option>
                                    <option value="{{ WithdrawAsset::USDC->value }}"
                                        @if ($request->asset == WithdrawAsset::USDC->value) selected @endif>
                                        {{ WithdrawAsset::USDC->value }} </option>
                                    <option value="{{ WithdrawAsset::DAI->value }}"
                                        @if ($request->asset == WithdrawAsset::DAI->value) selected @endif>
                                        {{ WithdrawAsset::DAI->value }} </option>
                                </select>
                            </div>
                        </div>
                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.withdraw_management.amount') }}</p>
                                <input class="form-control input_text" name="amount_from"
                                    value="{{ $request->amount_from }}" />
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <input class="form-control input_text" name="amount_to"
                                    value="{{ $request->amount_to }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-select-action">
                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.withdraw_management.request_date') }}</p>
                                <div class="input_date">
                                    <input id="request_date_from" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="request_date_from"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->request_date_from }}" />
                                    <label for="request_date_from">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="request_date_to" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="request_date_to"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->request_date_to }}" />
                                    <label for="request_date_to">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.withdraw_management.approve_time') }}</p>
                                <div class="input_date">
                                    <input id="approve_time_from" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="approve_time_from"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->approve_time_from }}" />
                                    <label for="approve_time_from">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="approve_time_to" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="approve_time_to"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->approve_time_to }}" />
                                    <label for="approve_time_to">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.withdraw_request_method') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="withdraw_request_method">
                                    <option value="">{{ __('common.withdraw_management.all') }}</option>
                                    <option value="{{ WithdrawRequestMethod::AUTO->value }}"
                                        @if ($request->withdraw_request_method == WithdrawRequestMethod::AUTO->value) selected @endif>
                                        {{ __('common.withdraw_management.withdraw_auto') }} </option>
                                    <option value="{{ WithdrawRequestMethod::REQUEST_EPAY->value }}"
                                        @if ($request->withdraw_request_method == WithdrawRequestMethod::REQUEST_EPAY->value) selected @endif>
                                        {{ __('common.withdraw_management.withdraw_request_epay') }} </option>
                                    <option value="{{ WithdrawRequestMethod::REQUEST_MERCHANT->value }}"
                                        @if ($request->withdraw_request_method == WithdrawRequestMethod::REQUEST_MERCHANT->value) selected @endif>
                                        {{ __('common.withdraw_management.withdraw_request_merchant') }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.withdraw_status') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="withdraw_status">
                                    <option value="">{{ __('common.withdraw_management.all') }}</option>
                                    <option value="{{ WithdrawStatus::WAITING_APPROVE->value }}"
                                        @if ($request->withdraw_status == WithdrawStatus::WAITING_APPROVE->value) selected @endif>
                                        {{ __('common.withdraw_management.waiting_approve') }} </option>
                                    <option value="{{ WithdrawStatus::DENIED->value }}"
                                        @if ($request->withdraw_status == WithdrawStatus::DENIED->value) selected @endif>
                                        {{ __('common.withdraw_management.denied') }} </option>
                                    <option value="{{ WithdrawStatus::SUCCEEDED->value }}"
                                        @if ($request->withdraw_status == WithdrawStatus::SUCCEEDED->value) selected @endif>
                                        {{ __('common.withdraw_management.succeeded') }} </option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex flex button__click">
                            <div class="action__button d-flex flex">
                                <button type="submit" class="btn btn_ok">
                                    {{ __('common.search') }}
                                </button>
                                <button type="button" class="btn btn_cancel reset" id="reset-form-btn">
                                    {{ __('common.reset') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-mer-dash-table">
                <div class="title-csv d-flex flex-row justify-content-between">
                    <h6 class="font-weight-bold text-primary">
                        {{ __('common.withdraw_management.withdraw_history') }}
                    </h6>
                    <button type="button" class="btn btn-primary btn-csv" id="export-csv-btn">
                        {{ __('common.csv') }}
                    </button>
                </div>
                <!-- Card Body -->
                <div class="table-data">
                    <div class="table-responsive p-0">
                        <table class="table table-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="center-table">
                                            {{ __('common.withdraw_management.transaction_id') }}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">
                                            {{ __('common.withdraw_management.merchant_store_id') }}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">
                                            {{ __('common.withdraw_management.merchant_store_name') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('common.withdraw_management.withdrawal_amount') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('common.withdraw_management.request_datetime') }}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('common.withdraw_management.approve_datetime') }}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">
                                            {{ __('common.withdraw_management.withdraw_request_method') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('common.withdraw_management.withdraw_status') }}
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($histories->count() > 0)
                                    @foreach ($histories as $history)
                                        <tr>
                                            <td class="text-number-font">
                                                <a class="show-popup-data rule rule_merchant_withdraw_detail"
                                                href="{{ route('merchant.withdraw.history.detail.get', ['id' => $history->id]) }}">
                                                    {{ $history->id }}
                                                </a>
                                            </td>
                                            <td>
                                                <a class="show-popup-data rule rule_merchant_withdraw_detail"
                                                href="{{ route('merchant.withdraw.history.detail.get', ['id' => $history->id]) }}">
                                                    {{ formatAccountId($history->merchant_code) }}
                                                </a>
                                            </td>

                                            <td>{{ $history->merchant_store_name }}</td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    {{ $history->asset }}
                                                    {{ formatNumberDecimal($history->amount, 3) }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ formatDateHour($history->created_at) }}
                                            </td>
                                            <td>{{ formatDateHour($history->approve_datetime) }}</td>
                                            <td>{{ getWithdrawRequestMethod($history->withdraw_request_method) }}</td>
                                            @php
                                                $withdrawStatusInfo = getWithdrawStatus($history->withdraw_status);
                                            @endphp
                                            <td class="status_item">
                                                <div class="center-table">
                                                    <div class="status completion {{ $withdrawStatusInfo['class'] }} ">
                                                        {{ $withdrawStatusInfo['label'] }}
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <td colspan="13">
                                        <div class="center-table">{{ __('common.messages.no_data') }}</div>
                                    </td>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('common.pagination', ['paginator' => $histories])
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        const SEARCH_FORM = $("#search");
        const RESET_FORM_BTN = $("#reset-form-btn");
        const EXPORT_CSV_BTN = $("#export-csv-btn");

        $('input[name=request_date_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=request_date_to]').datepicker(COMMON_DATEPICKER);
        $('input[name=approve_time_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=approve_time_to]').datepicker(COMMON_DATEPICKER);
        $(RESET_FORM_BTN).on("click", function() {
            window.location.href = "{{ route('merchant.withdraw.history.index.get') }}";
        });

        $(EXPORT_CSV_BTN).on("click", function() {
            let url = window.location.href;
            let str = url.includes("?") ? "&" : "?"
            let param = {
                'export_csv': true
            };
            url = url + str + $.param(param);
            window.open(url);
        });
    </script>
@endpush
