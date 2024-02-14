@extends('merchant.layouts.base')
@section('title', __('merchant.status.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/status-screen.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popupFormData.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <style>
        .modal.modal-popup-confirm.fade.show {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .common-modal-confirm {
            background-color: rgba(0, 0, 0, 0.5);
        }

        .chart-wrapper {
            position: relative;
        }

        .chart-wrapper>canvas {
            position: absolute;
            left: 0;
            top: 0;
            pointer-events: none;
        }

        .chart-area-wrapper {
            width: 1450px;
            /*overflow-x: scroll;*/
        }

        .hideme .card-body {
            height: 350px;
        }

        .legendBox {
            position: relative;
        }

        .unit-right {
            position: absolute;
            right: 32px;
        }

        .right-scale-text {
            padding-left: 0px;
            position: absolute;
            left: 0px;
        }

        .hideme .legend-all-ja,
        .hideme .legend-all-en {
            padding-left: 525px;
            position: absolute;
            right: 40px;
            top: -7px;
        }
    </style>
@endpush

@php
    use Carbon\Carbon;
    $arrUnitPayment = ['USD', 'JPY', 'EUR', 'AED', 'SGD', 'HKD', 'CAD', 'IDR', 'PHP', 'INR', 'KRW'];
    $arrUnitReceived = ['USDT', 'USDC', 'DAI', 'JPYC'];

    // get condtion from input -> calculator range
    $startDateRequest = $request->startDateRequest;
    $endDateRequest = $request->endDateRequest;
    if ($startDateRequest && $endDateRequest) {
        $startDateRequest = Carbon::parse($request->startDateRequest);
        $endDateRequest = Carbon::parse($request->endDateRequest);
        $range = $startDateRequest->diffInDays($endDateRequest) + 1;
    } elseif (!$startDateRequest && !$endDateRequest) {
        $startDateRequest = now()->startOfMonth();
        $endDateRequest = now()->endOfMonth();
        $range = $startDateRequest->diffInDays($endDateRequest) + 1;
    } else {
        $range = 31;
    }
    $calcPixelChart = $range * 48;
    $calcPixelChart = $calcPixelChart >= 1450 ? $calcPixelChart : 1450;
@endphp

@section('content')
    <div class="row">
        <div class="col-12 mt-15">
            <div class="list_search bg-white d-flex">
                <form class="form-search" id="search" method="GET" role="form"
                    action="{{ secure_url(url()->current()) }}">
                    <div class="form-input">
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.usage_situtation.trans_ID') }}</p>
                            <input type="text" name="trans_id" value="{{ $request->trans_id }}"
                                class="form-control input_infor border-1 small" aria-label="Search"
                                aria-describedby="basic-addon2" />
                        </div>

                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.usage_situtation.request_date') }}</p>
                                <div class="input_date">
                                    <input id="startDateRequest" type="text" placeholder="{{ getPlaceholderOfDate() }}"
                                        lang="ja" name="startDateRequest"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->startDateRequest }}" />
                                    <label for="startDateRequest">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="endDateRequest" type="text" placeholder="{{ getPlaceholderOfDate() }}"
                                        lang="ja" name="endDateRequest"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->endDateRequest }}" />
                                    <label for="endDateRequest">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.setting.profile.store') }}</p>
                            <div class="select_search">
                                <select class="select_list select-list-w300 select_option" name="merchant_store_id">
                                    <option value="">{{ __('common.label.all') }}</option>
                                    @foreach ($merchantStores as $store)
                                        <option value="{{ $store->id }}"
                                            @if (isset($request->merchant_store_id) and $request->merchant_store_id == $store->id) selected @endif>
                                            {{ formatAccountId($store->merchant_code) . ' - ' . $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.withdraw_management.unit') }}</p>
                            <div class="select_search">
                                <select class="select_list select-list-w100 select_option" name="unit">
                                    <option value="">{{ __('common.label.all') }}</option>
                                    @foreach ($arrUnitPayment as $key => $value)
                                        <option value="p{{ $value }}"
                                            @if (isset($request->unit) and $request->unit == 'p' . $value) selected @endif>{{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.usage_situtation.amount_money') }}</p>
                                <input class="form-control input_text number" name="startAmount"
                                    value="{{ $request->startAmount }}" />
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <input class="form-control input_text number" name="endAmount"
                                    value="{{ $request->endAmount }}" />
                            </div>
                        </div>
                    </div>
                    <div class="form-select-action">
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.usage_situtation.request_method') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="request_method">
                                    <option value="">{{ __('common.label.all') }}</option>
                                    @php
                                        use App\Enums\TransactionHistoryRequesMethod;
                                    @endphp
                                    <option value="{{ TransactionHistoryRequesMethod::END->value }}"
                                        @if ($request->request_method == TransactionHistoryRequesMethod::END->value) selected @endif>
                                        {{ __('common.usage_situtation.end') }}
                                    </option>
                                    <option value="{{ TransactionHistoryRequesMethod::MERCHANT->value }}"
                                        @if ($request->request_method == TransactionHistoryRequesMethod::MERCHANT->value) selected @endif>
                                        {{ __('common.setting.profile.store') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="search_info d-flex flex-column">
                            <p>{{ __('common.usage_situtation.payment_status') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="status">
                                    <option value="">{{ __('common.label.all') }}</option>
                                    @php
                                        use App\Enums\TransactionHistoryPaymentStatus;
                                    @endphp
                                    <option value="{{ TransactionHistoryPaymentStatus::OUTSTANDING->value }}"
                                        @if ($request->status == TransactionHistoryPaymentStatus::OUTSTANDING->value) selected @endif>
                                        {{ __('common.usage_situtation.unsettled') }}
                                    </option>
                                    <option value="{{ TransactionHistoryPaymentStatus::SUCCESS->value }}"
                                        @if ($request->status == TransactionHistoryPaymentStatus::SUCCESS->value) selected @endif>
                                        {{ __('common.usage_situtation.completion') }}
                                    </option>
                                    <option value="{{ TransactionHistoryPaymentStatus::FAIL->value }}"
                                        @if ($request->status == TransactionHistoryPaymentStatus::FAIL->value) selected @endif>
                                        {{ __('common.usage_situtation.failure') }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('common.usage_situtation.payment_completion_date') }}</p>
                                <div class="input_date">
                                    <input id="startDatePayment" type="text" placeholder="{{ getPlaceholderOfDate() }}"
                                        lang="ja" name="startDatePayment"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->startDatePayment }}" />
                                    <label for="startDatePayment">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="endDatePayment" type="text" placeholder="{{ getPlaceholderOfDate() }}"
                                        lang="ja" name="endDatePayment"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->endDatePayment }}" />
                                    <label for="endDatePayment">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-none">
                            <input type="hidden" name="sort_name" value=''>
                            <input type="hidden" name="sort_type" value=''>
                        </div>
                        <div class="d-flex flex button__click">
                            <div class="action__button d-flex flex">
                                <button type="submit" class="btn btn_ok">
                                    {{ __('common.search') }}
                                </button>
                                <a href="{{ route('merchant.usageSituation.index.get') }}">
                                    <button type="button" class="btn btn_cancel">
                                        {{ __('common.button.reset') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-12">
            <div class="five-card">
                <div class="list-card three-card">
                    <div class="item card card-transaction-time">
                        <div class="card border-left-primary shadow ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col info-and-priceNumber">
                                        <div class="text-primary text-uppercase title-transition">
                                            {{ __('common.dashboard.total_number_of_transactions') }}
                                        </div>
                                        <div class="text-transaction-time text-primary number-transaction number-value">
                                            {{ $countTrans }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="item card card-total-pay">
                        <div class="card border-left-primary shadow ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col show-data-total">
                                        <div class="text-primary text-uppercase title-transition">
                                            <p>{{ __('common.usage_situtation.total_payment') }}</p>
                                        </div>
                                        <div class="list-data-total-pay">
                                            @for ($i = 0; $i < count($arrUnitPayment); $i = $i + 3)
                                                <div class="item-transaction-three">
                                                    <div class="item-data-trans">
                                                        @if ($i < count($arrUnitPayment))
                                                            <p class="name-trans text-total-receive-usdt text-primary">
                                                                {{ $arrUnitPayment[$i] }}:
                                                            </p>
                                                            <p
                                                                class="price-trans text-total-receive-money text-primary ml-1 number-value">
                                                                {{ number_format($totalPayment[$arrUnitPayment[$i]] ?: '0.00', 2, '.', ',') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="item-data-trans">
                                                        @if ($i + 1 < count($arrUnitPayment))
                                                            <p class="name-trans text-total-receive-usdt text-primary">
                                                                {{ $arrUnitPayment[$i + 1] }}:
                                                            </p>
                                                            <p
                                                                class="price-trans text-total-receive-money text-primary ml-1 number-value">
                                                                {{ number_format($totalPayment[$arrUnitPayment[$i + 1]] ?: '0.00', 2, '.', ',') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                    <div class="item-data-trans">
                                                        @if ($i + 2 < count($arrUnitPayment))
                                                            <p class="name-trans text-total-receive-usdt text-primary">
                                                                {{ $arrUnitPayment[$i + 2] }}:
                                                            </p>
                                                            <p
                                                                class="price-trans text-total-receive-money text-primary ml-1 number-value">
                                                                {{ number_format($totalPayment[$arrUnitPayment[$i + 2]] ?: '0.00', 2, '.', ',') }}
                                                            </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="list-card two-card">
                    <div class="item card card-total-receive">
                        <div class="card border-left-primary shadow ">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="text-primary text-uppercase title-transition">
                                            {{ __('common.dashboard.total_received_amount') }}
                                        </div>
                                        @for ($i = 0; $i < count($arrUnitReceived); $i = $i + 2)
                                            <div class="two-item--receive">
                                                <div class="row card-total-receive-info">
                                                    @if ($i < count($arrUnitReceived))
                                                        <div class="info-receive-flex info-receive-usdt">
                                                            <div class="text-total-receive-usdc text-primary">
                                                                {{ $arrUnitReceived[$i] }}:
                                                            </div>
                                                            <div
                                                                class="text-total-receive-money text-primary ml-1 number-value">
                                                                {{ $totalReceived[$arrUnitReceived[$i]] ?: '0.00' }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if ($i + 1 < count($arrUnitReceived))
                                                        <div class="info-receive-flex info-receive-dai">
                                                            <div class="text-total-receive-dai text-primary ml-4">
                                                                {{ $arrUnitReceived[$i + 1] }}:
                                                            </div>
                                                            <div
                                                                class="text-total-receive-money text-primary ml-1 number-value">
                                                                {{ $totalReceived[$arrUnitReceived[$i + 1]] ?: '0.00' }}
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <!--　Chart -->
            <div class=" card card-char justify-content-center">

                <div class="d-flex flex-row justify-content-between">
                    <h6 class="font-weight-bold text-primary title-chart">
                        {{ __('common.usage_situtation.aggregation_trends') }}</h6>
                    <div class="switch-contain">
                        <h6 class="chart-show-title">{{ __('common.dashboard.graph_display') }}</h6>
                        <label class="switch ml-3"><input type="checkbox" checked><span
                                class="slider round hide-off"></span></label>
                    </div>
                </div>

                <div class="hideme">
                    <!--hide part-->
                    <div class="card-body">
                        <div class="legendBox">
                            <div class="row">
                                <div class="col-sm-4">
                                    <h6 class="left-scale-text">{{ __('common.dashboard.number_of_times_cases') }}</h6>
                                </div>
                                <div class="row legend-all-en">
                                    <div class="row legend-label">
                                        <div id="bar-first" onClick="toggleData(0)" class="item row">
                                            <span class="dot dot-bar-first"></span>
                                            <div class="chart-circle-text">
                                                {{ __('common.dashboard.number_of_transactions') }}</div>
                                        </div>
                                        <div id="line-first" onClick="toggleData(1)" class="item row">
                                            <span class="dot dot-line-first"></span>
                                            <div class="chart-circle-text">
                                                {{ __('common.usage_situtation.payment_amount_yen') }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="unit-right">
                                    <h6 class="right-scale-text">{{ __('common.dashboard.unit') }}</h6>
                                    <div id="addItem"></div>
                                </div>
                            </div>
                        </div>

                        <div class="chart-wrapper">
                            <div class="chart-area-wrapper">
                                <canvas class="chart-show1" id="graph-name" height="290"
                                    width="{{ $calcPixelChart }}"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card card-mer-dash-table">
                <div class="title-csv d-flex flex-row justify-content-between">
                    <h6 class="font-weight-bold text-primary">
                        {{ __('common.usage_situtation.usage_situation') }}
                    </h6>
                    <a class="href"
                        href="{{ route('merchant.usageSituation.index.get', ['csv' => 1] + request()->all()) }}">
                        <button class="btn btn-primary btn-csv">{{ __('common.button.csv') }}</button>
                    </a>
                </div>
                <!-- Card Body -->
                <div class="table-data">
                    <div class="table-responsive p-0">
                        <table class="table table-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="center-table column-name" data-name="id">
                                            {{ __('common.usage_situtation.trans_ID') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="transaction_date">
                                            {{ __('common.usage_situtation.request_datetime') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="name">
                                            {{ __('common.withdraw_management.merchant_store_name') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="payment_amount-payment_asset">
                                            {{ __('common.dashboard.payment') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="received_amount-received_asset">
                                            {{ __('common.dashboard.received_amount') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="request_method">
                                            {{ __('common.usage_situtation.request_method') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="payment_status">
                                            {{ __('common.usage_situtation.payment_status') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="payment_success_datetime">
                                            {{ __('common.usage_situtation.payment_datetime') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($transactionHistories->count() > 0)
                                    @foreach ($transactionHistories as $transaction)
                                        <tr>
                                            <td class="text-number-font">
                                                <a class="show-popup-data rule rule_merchant_usage_situation_detail"
                                                    data-id="{{ $transaction->id }}">
                                                    {{ $transaction->id }}
                                                </a>
                                            </td>
                                            <td>{{ Carbon::parse($transaction->transaction_date)->format(getColumnTableOfDatetime()) }}
                                            </td>
                                            @foreach ($merchantStores as $store)
                                                @if ($transaction->merchant_store_id == $store->id)
                                                    <td>{{ $store->name }}</td>
                                                @endif
                                            @endforeach
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    {{ $transaction->payment_asset }}
                                                    @if ($transaction->paymentSuccess)
                                                        {{ formatNumberDecimal($transaction->paymentSuccess->payment_amount, 3) }}
                                                    @else
                                                        {{ formatNumberDecimal($transaction->payment_amount, 3) }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    {{ $transaction->received_asset }}
                                                    @if ($transaction->paymentSuccess)
                                                        {{ formatNumberDecimal($transaction->paymentSuccess->received_amount, 3) }}
                                                    @else
                                                        {{ formatNumberDecimal($transaction->received_amount, 3) }}
                                                    @endif
                                                </div>
                                            </td>
                                            <td>{{ $transaction->request_method == App\Enums\TransactionHistoryRequesMethod::END->value ? __('common.usage_situtation.end') : __('common.setting.profile.store') }}
                                            </td>
                                            <td class="status_item">
                                                <div class="center-table">
                                                    @if ($transaction->payment_status == App\Enums\TransactionHistoryPaymentStatus::OUTSTANDING->value)
                                                        <div class="status unsettled">
                                                            {{ __('common.usage_situtation.unsettled') }}</div>
                                                    @elseif ($transaction->payment_status == App\Enums\TransactionHistoryPaymentStatus::SUCCESS->value)
                                                        <div class="status completion">
                                                            {{ __('common.usage_situtation.completion') }}</div>
                                                    @else
                                                        <div class="status failure">
                                                            {{ __('common.usage_situtation.failure') }}</div>
                                                    @endif
                                                </div>
                                            </td>
                                            <td>
                                                @if ($transaction->payment_success_datetime)
                                                    {{ Carbon::parse($transaction->payment_success_datetime)->format(getColumnTableOfDatetime()) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="12">
                                            <div class="center-table">{{ __('common.messages.no_data') }}</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="popup-FormData popup-FormData-detail">
                            @include('merchant.usage_situation.detail')
                        </div>
                    </div>
                </div>
                @include('common.pagination', ['paginator' => $transactionHistories])
            </div>
        </div>
        @include('common.modal.confirm_delete', [
            'id' => 'confirm-delete-usage-situation',
            'title' => __('common.usage_situtation.usage_delete_title_confirm'),
            'description' => __('common.usage_situtation.usage_delete_des_confirm'),
        ])

        @include('common.modal.result', [
            'class' => 'result-delete-usage-situation',
            'title' => __('common.usage_situtation.usage_delete_title_confirm'),
            'description' => __('common.usage_situtation.usage_delete_des_result'),
        ])
    </div>
@endsection

@push('script')
    <!-- Chart-->
    <script>
        const THOUSAND_UNIT = "{{ __('common.dashboard.thousand_unit') }}"
        const MILLION_UNIT = "{{ __('common.dashboard.million_unit') }}"
        const selectedLanguage = "{{ app()->getLocale() }}";

        $(".chart-area-wrapper").css({
            "width": "{{ $calcPixelChart }}"
        });
        $(".hideme .card-body").css({
            "width": "{{ $calcPixelChart }}"
        });

        // chart 1st: dayTrans
        let transCount = @json($dayTrans) ?? [];
        // chart 2nd: yenDayPayment
        let paymentAmountYen = @json($yenDayPayment) ?? [];
        // chart 3th: USDTDayReceived
        let receiveAmountUSDT = @json($USDTDayReceived) ?? [];

        let maxValueBarChart = Math.max(...transCount);
        let stepSizeA = maxValueBarChart > 10 ? 0 : 1; //0: auto, 1: manual

        let combinedDataLine = paymentAmountYen.concat(receiveAmountUSDT);
        let maxValueLineChart = Math.max(...combinedDataLine);
        let stepSizeB = maxValueLineChart > 5 ? 0 : 1;
        console.log('maxValueLineChart:' + maxValueLineChart, stepSizeA, stepSizeB);

        var ctx = $("#graph-name")[0].getContext('2d');
        var epay_chart = new Chart(ctx, config = {
            data: {
                labels: Object.values(<?php echo json_encode($label); ?>),
                datasets: [{ // [0]
                        yAxisID: 'A',
                        type: 'bar',
                        label: '{{ __('common.dashboard.number_of_transactions') }}',
                        data: Object.values(<?php echo json_encode($dayTrans); ?>),
                        backgroundColor: 'rgb(78,115,223)',
                        borderColor: 'rgb(78,115,223)',
                        barThickness: 30,
                        order: 1,
                    },
                    { //[1]
                        yAxisID: 'B',
                        label: '{{ __('common.dashboard.payment') }}',
                        type: 'line',
                        pointRadius: 6,
                        data: Object.values(<?php echo json_encode($yenDayPayment); ?>),
                        backgroundColor: 'rgb(28,200,138)',
                        borderColor: 'rgb(28,200,138)',
                        pointBorderColor: 'white'
                    },
                ]
            },
            options: {
                intersect: false,
                maintainAspectRaito: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value, context) {
                            if (context.datasetIndex === 1 && context.dataset.data[context.dataIndex] === 0) {
                                return value;
                            }
                            return '';
                        }
                    },
                    tooltip: {
                        intersect: false,
                        boxWidth: '0',
                        boxHeight: '0',
                        usePointStyle: true,
                        titleFont: {
                            size: '14',
                        },
                        bodyFont: {
                            size: '14',
                        },
                        callbacks: {
                            labelTextColor: (context) => {
                                return context.dataset.borderColor[context.datasetIndex]
                            },
                            label: (context) => {
                                const datasetIndex = context.datasetIndex;
                                const dataIndex = context.dataIndex;
                                const value = context.dataset.data[dataIndex];
                                const label = context.dataset.label;

                                let thousandValue = value / (selectedLanguage === 'ja' ? 10000 : 1000);
                                let millionValue = value / (selectedLanguage === 'ja' ? 100000000 : 1000000);
                                let unit = '';
                                let valueShow;

                                console.log(datasetIndex, 'datasetIndexdatasetIndex')

                                if (value >= 1000 && value < 1000000) {
                                    if (datasetIndex === 0) { //dayTrans count: [0]
                                        valueShow = value
                                        unit = '';
                                    } else if (datasetIndex === 1) { // yenDayPayment: [1]
                                        valueShow = (thousandValue % 1 === 0) ? (thousandValue).toFixed(0) :
                                            formatNumberChart(thousandValue, 1);
                                        unit = "{{ __('common.dashboard.thousand_money_unit') }}";
                                    } else { // $USDTDayReceived: [2]
                                        valueShow = (thousandValue % 1 === 0) ? (thousandValue).toFixed(0) :
                                            formatNumberChart(thousandValue, 1);
                                        unit = '{{ __('common.dashboard.thousand_unit_usdt') }}';
                                    }
                                } else if (value >= 1000000) {
                                    if (datasetIndex === 0) {
                                        valueShow = value
                                        unit = '';
                                    } else if (datasetIndex === 1) {
                                        valueShow = (millionValue % 1 === 0) ? (millionValue).toFixed(0) :
                                            formatNumberChart(millionValue, 3);
                                        unit = '{{ __('common.dashboard.million_money_unit') }}';
                                    } else {
                                        valueShow = (millionValue % 1 === 0) ? (millionValue).toFixed(0) :
                                            formatNumberChart(millionValue, 3);
                                        unit = '{{ __('common.dashboard.million_unit_usdt') }}';
                                    }
                                } else {
                                    if (datasetIndex === 0) {
                                        valueShow = value
                                        unit = '';
                                    } else if (datasetIndex === 1) {
                                        valueShow = value
                                        unit = '{{ __('common.dashboard.unit') }}';
                                    } else {
                                        valueShow = value
                                        unit = '{{ __('common.dashboard.unit_usdt') }}';
                                    }
                                }

                                return label + ': ' + parseFloat(valueShow) + '' + unit;
                            }
                        },
                    },
                    zoom: {
                        zoom: {
                            enable: true,
                            mode: 'x',
                            sensitivity: 3
                        }
                    }
                },
                scales: {
                    A: {
                        type: 'linear',
                        position: 'left',
                        ticks: {
                            font: {
                                size: 14,
                            },
                            color: '#ABAFB3',
                            stepSize: stepSizeA, // chart [0]
                            callback: (value, index, values) => {
                                let thousandValue = value / (selectedLanguage === 'ja' ? 10000 : 1000);
                                let millionValue = value / (selectedLanguage === 'ja' ? 100000000 : 1000000);
                                let valueShow;
                                if (value >= 1000 && value < 1000000) {
                                    valueShow = thousandValue % 1 === 0 ?
                                        (thousandValue).toFixed(0) + THOUSAND_UNIT :
                                        formatNumberChart(thousandValue, 1) + THOUSAND_UNIT;
                                    return ' ' + valueShow + '   ';
                                } else if (value >= 1000000) {
                                    valueShow = millionValue % 1 === 0 ?
                                        (millionValue).toFixed(0) + MILLION_UNIT :
                                        formatNumberChart(millionValue, 3) + MILLION_UNIT;
                                    return ' ' + valueShow + '   ';
                                } else {
                                    return ' ' + value + '   ';
                                }
                            },
                        },
                        grid: {
                            display: true
                        },
                        paddingLeft: '10',
                        paddingRight: '10',
                        layout: 'absolute',
                        border: {
                            display: false,
                        },
                    },
                    B: {
                        afterFit(scale) {
                            scale.width = 81
                        },
                        beginAtZero: true,
                        type: 'linear',
                        position: 'right',
                        ticks: {
                            font: {
                                size: 14,
                            },
                            color: '#ABAFB3',
                            stepSize: stepSizeB, // chart [1], [2]
                            callback: value => {
                                let thousandValue = value / (selectedLanguage === 'ja' ? 10000 : 1000);
                                let millionValue = value / (selectedLanguage === 'ja' ? 100000000 : 1000000);
                                let valueShow;
                                if (value >= 1000 && value < 1000000) {
                                    valueShow = thousandValue % 1 === 0 ?
                                        (thousandValue).toFixed(0) + THOUSAND_UNIT :
                                        formatNumberChart(thousandValue, 3) + THOUSAND_UNIT;
                                    return ' ' + valueShow + '   ';
                                } else if (value >= 1000000) {
                                    valueShow = millionValue % 1 === 0 ?
                                        (millionValue).toFixed(0) + MILLION_UNIT :
                                        formatNumberChart(millionValue, 3) + MILLION_UNIT;
                                    return ' ' + valueShow + '   ';
                                } else {
                                    return ' ' + value + '   ';
                                }
                            }
                        },
                        grid: {
                            display: false
                        },
                        border: {
                            display: false,
                        },
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 14,
                            },
                            color: '#ABAFB3',
                        },
                        grid: {
                            drawBorder: false,
                            lineWidth: 0,
                            borderColor: 'white',
                            display: false,
                            drawOnChartArea: false,
                        },
                        xAxes: [{
                            ticks: {
                                padding: 20
                            }
                        }]
                    }
                },
                interaction: {
                    mode: 'index',
                    titleAlign: 'center',
                    backgroundColor: 'white',
                    titleColor: 'rgb(171,175,179)',
                    reverse: true
                },
                categoryPercentage: 0.55,
                barPercentage: 1
            }
        });

        // Change class by language
        $(document).ready(function() {
            const selectedLanguage = '{{ app()->getLocale() }}';
            if (selectedLanguage === 'en') {
                $(".right-scale-en").addClass("right-scale-en");
                $(".legend-all-ja").removeClass("legend-all-ja").addClass("legend-all-en");
            } else {
                $(".right-scale-en").removeClass("right-scale-en");
                $(".legend-all-en").removeClass("legend-all-en").addClass("legend-all-ja");
            }
        });

        //plugin-legend
        function toggleData(value) {
            var barFirstElement = document.getElementById('bar-first');
            var lineFirstElement = document.getElementById('line-first');

            var barChartCircleText = barFirstElement.querySelector('.chart-circle-text');
            var lineFirstChartCircleText = lineFirstElement.querySelector('.chart-circle-text');

            var barVisibility = epay_chart.isDatasetVisible(0);
            var lineFirstVisibility = epay_chart.isDatasetVisible(1);

            var unitYenElement = document.querySelector('.right-scale-text');
            var unitUsdt = "{{ __('common.dashboard.unit_usdt') }}";
            var unitYen = "{{ __('common.dashboard.unit') }}";

            if (value === 0) { // bar is clicked
                if (barVisibility) {
                    epay_chart.hide(0);
                    barChartCircleText.classList.add('strikethrough');
                } else {
                    epay_chart.show(0);
                    barChartCircleText.classList.remove('strikethrough');
                }
            } else if (value === 1) { // line1 is clicked
                if (lineFirstVisibility) {
                    epay_chart.hide(1);
                    lineFirstChartCircleText.classList.add('strikethrough');
                } else {
                    epay_chart.show(1);
                    lineFirstChartCircleText.classList.remove('strikethrough');
                }
            }
        }

        //hidechart
        $(document).ready(function() {
            $(".switch input").on("change", function(e) {
                const isOn = e.currentTarget.checked;

                if (isOn) {
                    $(".hideme").show();
                } else {
                    $(".hideme").hide();
                }
            });
        });

        // scroll chart
        function scroller(scroll, chart) {
            const dataLength = epay_chart.data.labels.length;
            if (scroll.deltaY > 0) {
                if (epay_chart.config.options.scales.x.max >= dataLength) {
                    epay_chart.config.options.scales.x.min = dataLength - 13;
                    epay_chart.config.options.scales.x.max = dataLength - 1;
                } else {
                    epay_chart.config.options.scales.x.min += 1;
                    epay_chart.config.options.scales.x.max += 1;
                }
            } else
            if (scroll.deltaY < 0) {
                if (epay_chart.config.options.scales.x.min <= 0) {
                    epay_chart.config.options.scales.x.min = 0;
                    epay_chart.config.options.scales.x.max = 11;
                } else {
                    epay_chart.config.options.scales.x.min -= 1;
                    epay_chart.config.options.scales.x.max -= 1;
                }
            } else {
                //do nothing
            }
            epay_chart.update();
        }

        epay_chart.canvas.addEventListener('wheel', (e) => {
            scroller(e, epay_chart);
        });

        // detail usage process
        var arrUnitPayment = <?php echo json_encode($arrUnitPayment); ?>;
        var arrUnitReceived = <?php echo json_encode($arrUnitReceived); ?>;
        var current_url = <?php echo json_encode(url()->current()); ?>;
        const DETAIL_MODAL = $("#showDataFormDetail");
        const CONFIRM_DELETE_MODAL = $("#confirm-delete-usage-situation");
        const DELETE_BUTTON = $("#delete-btn");
        const RESULT_DELETE_MODAL = $(".result-delete-usage-situation");
        const RETURN_DELETE_BUTTON = $(".result-delete-usage-situation .btn-yes");

        // open detail modal
        $('.show-popup-data').on('click', function() {
            $('input[name = "paymentSuccessDatetimeForm"]').val("");
            var dataId = $(this).data('id');
            $.ajax({
                url: current_url + "/detail/" + dataId,
                method: 'GET',
                success: function(response) {
                    // detail popup
                    $('input[name = "transIdForm"]').val(response.id);
                    $('input[name = "paymentForm"]').val((response.payment_asset ? response
                            .payment_asset : '') +
                        ' ' + (response.payment_amount ? formatNumberDecimal(response
                            .payment_amount, 3) : ''));
                    $('input[name = "receivedForm"]').val((response.received_asset ? response
                            .received_asset : '') +
                        ' ' + (response.received_amount ? formatNumberDecimal(response
                            .received_amount, 3) : ''));
                    $('input[name = "networkForm"]').val(response.network);

                    if (response.request_method == <?php echo json_encode(App\Enums\TransactionHistoryRequesMethod::END->value); ?>)
                        $('input[name = "requestMethodForm"]').val(
                            "{{ __('common.usage_situtation.end') }}");
                    else
                        $('input[name = "requestMethodForm"]').val(
                            "{{ __('common.setting.profile.store') }}");

                    if (response.payment_status == <?php echo json_encode(App\Enums\TransactionHistoryPaymentStatus::OUTSTANDING->value); ?>) {
                        $('input[name = "paymentStatusForm"]').val(
                            "{{ __('common.usage_situtation.unsettled') }}");
                    } else if (response.payment_status == <?php echo json_encode(App\Enums\TransactionHistoryPaymentStatus::SUCCESS->value); ?>) {
                        $('input[name = "paymentStatusForm"]').val(
                            "{{ __('common.usage_situtation.completion') }}");
                    } else {
                        $('input[name = "paymentStatusForm"]').val(
                            "{{ __('common.usage_situtation.failure') }}");
                    }
                    $('input[name = "hashForm"]').val(response.hash);

                    if (<?php echo json_encode(app()->getLocale()); ?> == "ja") {
                        $('input[name = "dateRequestForm"]').val((response.transaction_date)
                            .substring(0, 16).replace(response.transaction_date[4], "年")
                            .replace(response.transaction_date[7], "月")
                            .replace(response.transaction_date[10], "日 "));
                        if (response.payment_success_datetime) {
                            $('input[name = "paymentSuccessDatetimeForm"]').val((response
                                    .payment_success_datetime).substring(0, 16).replace(response
                                    .transaction_date[4], "年")
                                .replace(response.transaction_date[7], "月")
                                .replace(response.transaction_date[10], "日 "));
                        }
                    } else {
                        $('input[name = "dateRequestForm"]').val((response.transaction_date).substring(
                            0,
                            16).replace(response.transaction_date[4], "/").replace(response
                            .transaction_date[7], "/"));
                        if (response.payment_success_datetime) {
                            $('input[name = "paymentSuccessDatetimeForm"]').val((response
                                .payment_success_datetime).substring(0, 16).replace(response
                                .payment_success_datetime[4], "/").replace(response
                                .payment_success_datetime[7], "/"));
                        }
                    }

                    let url = '{{ route('merchant.merchant-store.detail.get', '_merchantStoreId') }}';
                    url = url.replace('_merchantStoreId', response.merchant_store_id);

                    $.ajax({
                        url: url,
                        type: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        },
                        dataType: 'json',
                        data: {}
                    }).done(function(responseData) {
                        $('input[name = "merchantForm"]').val(responseData.merchant);

                    }).fail(function(err) {}).always(function(xhr) {});

                    DETAIL_MODAL.modal('show');

                    // delete modal
                    DELETE_BUTTON.on("click", function() {
                        $.ajax({
                            url: current_url + "/delete/" + dataId + "?status=" +
                                response.payment_status,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr(
                                    'content')
                            },
                            success: function(response) {
                                CONFIRM_DELETE_MODAL.modal("hide");
                                RESULT_DELETE_MODAL.modal("show");
                            },
                            error: function(xhr) {
                                console.log(xhr.responseText);
                            }
                        });
                    })
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        function showModalDelete() {
            DETAIL_MODAL.modal('hide');
            CONFIRM_DELETE_MODAL.modal("show");
        }

        RETURN_DELETE_BUTTON.on("click", function() {
            location.reload();
        })

        $('input[name=startDateRequest]').datepicker(COMMON_DATEPICKER);
        $('input[name=endDateRequest]').datepicker(COMMON_DATEPICKER);
        $('input[name=startDatePayment]').datepicker(COMMON_DATEPICKER);
        $('input[name=endDatePayment]').datepicker(COMMON_DATEPICKER);

        @if (isset($request->sort_name))
            var itemSort = $('[data-name="{{ $request->sort_name }}"]');
            console.log("itemSort", '{{ $request->sort_name }}');
            itemSort.find("img").removeClass("opacity-30");
            @if ($request->sort_type === 'asc')
                itemSort.find("img").filter(".asc").removeClass("d-none")
                itemSort.find("img").filter(".desc").addClass("d-none");
            @elseif ($request->sort_type === 'desc')
                itemSort.find("img").filter(".desc").removeClass("d-none")
                itemSort.find("img").filter(".asc").addClass("d-none");
            @endif
        @endif

        $(".column-name").click(function() {
            var sortName = $(this).data("name");
            var disableItem = $(this).find("img").filter(".d-none")
            var sortType = disableItem.data("type");
            $(this).find("img:not(.d-none)").addClass("d-none");
            disableItem.removeClass("d-none");
            $('input[name="sort_name"]').val(sortName);
            $('input[name="sort_type"]').val(sortType);
            $('#search').submit();
        });
    </script>
@endpush
