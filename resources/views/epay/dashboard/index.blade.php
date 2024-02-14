@extends('epay.layouts.base', ['title' => __('admin.titles')])
@section('title', __('admin_epay.admin.dashboard_title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_aggregatedData.css') }}">
    <style>
        a.disabled {
            pointer-events: none;
            /*opacity:0.6;*/
        }
    </style>
@endpush

@php
    use Carbon\Carbon;
    
    $fixedYear = '2023';
    $currentYear = now()->format('Y');
    $currentMonth = +now()->format('m');
    $currentDate = now()->format('d');
    $maxDay = now()->daysInMonth;
    $isLangJapanese = isLangJapanese();
@endphp
@section('content')
    <section class="content content-style">
        <!-- 5 cards -->
        <div class="row">
            <div class="col-12">
                <div class="five-card">
                    <div class="list-card three-card">
                        {{-- TOTAL_TRANSACTIONS  --}}
                        <div class="item card card-transaction-time">
                            <div class="card border-left-primary shadow ">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col info-and-priceNumber">
                                            <div class="text-primary text-uppercase title-transition">
                                                {{ __('common.dashboard.number_of_transactions') }}
                                            </div>
                                            <div class="text-transaction-time text-primary number-transaction number-value"
                                                id="total-transactions">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TOTAL_CRYPTO_RECEIVE --}}
                        <div class="item card card-total-receive">
                            <div class="card border-left-primary shadow ">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="text-primary text-uppercase title-transition">
                                                {{ __('common.dashboard.total_received_amount') }}
                                            </div>

                                            <div class="row card-total-receive-info">
                                                <div class="info-receive-flex info-receive-usdt">
                                                    <div class="text-total-receive-usdt text-primary">
                                                        USDT:
                                                    </div>
                                                    <div class="text-total-receive-money text-primary ml-1 number-value"
                                                        id="total-crypto-receive-usdt">

                                                    </div>
                                                </div>
                                                <div class="info-receive-flex info-receive-dai">
                                                    <div class="text-total-receive-dai text-primary ml-4">
                                                        DAI:
                                                    </div>
                                                    <div class="text-total-receive-money text-primary ml-1 number-value"
                                                        id="total-crypto-receive-dai">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row card-total-receive-info">
                                                <div class="info-receive-flex info-receive-usdc">
                                                    <div class="text-total-receive-usdc text-primary">
                                                        USDC:
                                                    </div>
                                                    <div class="text-total-receive-money text-primary ml-1 number-value"
                                                        id="total-crypto-receive-usdc">

                                                    </div>
                                                </div>
                                                <div class=" info-receive-flex info-receive-usdc">
                                                    <div class="text-total-receive-jpyc text-primary ml-2">
                                                        JPYC:
                                                    </div>
                                                    <div class="text-total-receive-money text-primary ml-1 number-value"
                                                        id="total-crypto-receive-jpyc">

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TOTAL_WITHDRAW  --}}
                        <div class="item card card-total-paid">
                            <div class="card border-left-primary shadow ">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col">
                                            <div class="row item-transaction-paid-bank item-transaction-total-paid">
                                                <div class="text-primary text-uppercase title-transition">
                                                    {{ __('common.dashboard.total_withdrawal_amount') }}
                                                </div>
                                                <div class="info-receive-flex">
                                                    <div class="text-total-paid-bank text-primary">
                                                        BANK:
                                                    </div>
                                                    <div class="text-total-paid-money text-primary ml-1 number-value"
                                                        id="total-withdraw-bank">

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row item-transaction-total-paid">
                                                <div class="text-total-paid-crypto text-primary">
                                                    CRYPTO(USDT):
                                                </div>
                                                <div class="text-total-paid-money text-primary ml-1 number-value"
                                                    id="total-withdraw-crypto">

                                                </div>
                                            </div>
                                            <div class="row item-transaction-total-paid">
                                                <div class="text-total-paid-cash text-primary">
                                                    CASH:
                                                </div>
                                                <div class="text-total-paid-money text-primary ml-1 number-value"
                                                    id="total-withdraw-cash">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list-card two-card">
                        {{-- TOTAL_MERCHANT_STORE  --}}
                        <div class="item card card-merchant-stores">
                            <div class="card border-left-primary shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col info-and-priceNumber">
                                            <div class="text-primary text-uppercase title-transition">
                                                {{ __('common.dashboard.number_of_merchants') }}
                                            </div>
                                            <div class="text-merchant-stores text-primary number-value"
                                                id="total-merchant-stores">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- TOTAL_AFFILIATES  --}}
                        <div class="item card card-amount-af">
                            <div class="card border-left-primary shadow">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col info-and-priceNumber">
                                            <div class="text-primary text-uppercase title-transition">
                                                {{ __('common.dashboard.number_of_AFs') }}
                                            </div>
                                            <div class="text-amount-af text-primary number-value" id="total-affiliates">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <!-- Year month dropdown -->
                <div class="card card-select-search">
                    <div class="card-body">
                        <form action="" method="GET" id="form-seach" class="">
                            <div class="row row-select">
                                <h6 class="text-primary">
                                    {{ __('common.dashboard.aggregation_target') }}
                                </h6>
                                <!-- year dropdown-->
                                <div class="select_search">
                                    <select class="select_list select_option" onchange="changeType(this.value)"
                                        name="view_type">
                                        <option value="by_hour">{{ __('common.dashboard.by_time') }}</option>
                                        <option value="by_day">{{ __('common.dashboard.by_day') }}</option>
                                        <option value="by_month">{{ __('common.dashboard.by_month') }}</option>
                                        <option value="by_year"> {{ __('common.dashboard.by_year') }}</option>
                                    </select>
                                </div>
                                <!-- year dropdown-->
                                <div class="select_search" id="year-box">
                                    <select class="select_list select_option" name="year" id="year-slt">
                                        @for ($i = $currentYear; $i >= $fixedYear; $i--)
                                            <option @if ($i == $currentYear) selected @endif
                                                value="{{ $i }}">
                                                {{ $i }} {{ __('common.date_format_label.year') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <!-- month dropdown-->
                                <div class="select_search" id="month-box" onchange="changeMonth(this.value)">
                                    <select class="select_list select_option" name="month" id="month-slt">
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option @if ($i == $currentMonth) selected @endif
                                                value="{{ formatFullNumber($i) }}">
                                                {{ $i }} {{ __('common.date_format_label.month') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <!-- day dropdown-->
                                <div class="select_search" id="day-box">
                                    <select class="select_list select_option" name="day" id="day-slt">
                                        @for ($i = 1; $i <= $maxDay; $i++)
                                            <option @if ($i == $currentDate) selected @endif
                                                value="{{ formatFullNumber($i) }}">
                                                {{ $i }} {{ __('common.date_format_label.day') }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                                <button class="btn btn-primary confirm-month-year" id="seach-btn" type="button"
                                    onclick="searchData()">
                                    {{ __('common.dashboard.total') }}
                                </button>
                            </div>
                        </form>
                        <h6 class="note-year-month">
                            {{ __('common.dashboard.description_target') }}
                        </h6>
                    </div>
                </div>
            </div>
            <!-- end 5 cards -->

            <!--　Chart -->
            <div class="col-12">
                <div class=" card card-char justify-content-center">

                    <div class="d-flex flex-row justify-content-between">
                        <h6 class="font-weight-bold text-primary title-chart">
                            {{ __('common.dashboard.name_tally_transition') }}
                        </h6>
                        <div class="switch-contain">
                            <h6 class="chart-show-title">{{ __('common.dashboard.graph_display') }}</h6>
                            <label class="switch ml-3">
                                <input id="switch-view-chart-btn" type="checkbox" checked>
                                <span class="slider round hide-off"></span>
                            </label>
                        </div>
                    </div>

                    <div class="hideme" id="hide-chart-btn">
                        <!--hide part-->
                        <div class="card-body card-body-chart">
                            <div class="legendBox">
                                <div class="row item-menu-dot-chart">
                                    <div class="col-sm-4">
                                        <h6 class="left-scale-text left-scale-en">
                                            {{ __('common.dashboard.number_of_times_cases') }}</h6>
                                    </div>

                                    <div class="row legend-all-ja">
                                        <div class="row legend-label">
                                            <div id="bar-first" onClick="toggleData(0)" class="item row">
                                                <span class="dot dot-bar-first"></span>
                                                <div class="chart-circle-text">
                                                    {{ __('common.dashboard.number_of_transactions') }}
                                                </div>
                                            </div>
                                            <div id="bar-second" onClick="toggleData(1)" class="item row">
                                                <span class="dot dot-bar-second"></span>
                                                <div class="chart-circle-text">
                                                    {{ __('common.dashboard.number_of_withdrawals') }}</div>
                                            </div>
                                            <div id="line-first" onClick="toggleData(2)" class="item row">
                                                <span class="dot dot-line-first"></span>
                                                <div class="chart-circle-text">
                                                    {{ __('common.dashboard.paid') }}
                                                </div>
                                            </div>
                                            <div id="line-second" onClick="toggleData(3)" class="item row">
                                                <span class="dot dot-line-second"></span>
                                                <div class="chart-circle-text">
                                                    {{ __('common.dashboard.withdraw_amount') }}</div>
                                            </div>
                                            <div id="line-third" onClick="toggleData(4)" class="item row">
                                                <span class="dot dot-line-third"></span>
                                                <div class="chart-circle-text">
                                                    {{ __('common.dashboard.withdrawal_fee') }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="right-scale-text right-scale-en">{{ __('common.dashboard.unit') }}</h6>
                                        <div id="addItem"></div>
                                    </div>
                                </div>
                            </div>
                            <canvas class="chart-show" id="dashboard-chart-canvas" width="1600"
                                height="290"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!--Table -->
            <div class="col-12">
                <div class="card card-mer-dash-table">
                    <div class="d-flex flex-row justify-content-between">
                        <h6 class="m-3 font-weight-bold text-primary">
                            {{ __('common.dashboard.each_summary_data') }}
                        </h6>
                        <button onclick="exportCSV()" type="button" class="btn btn-primary btn-csv">CSV</button>
                    </div>
                    <!-- Card Body -->
                    <div class="table-responsive p-0">
                        <div class="table-data">
                            <table class="table table-fixed table-hover text-nowrap" id="table-statistic">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="center-table">{{ __('common.dashboard.aggregation_period') }}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('common.dashboard.number_of_transactions') }}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    {{ __('common.dashboard.paid') }}<br><span>({{ __('common.dashboard.only_yen') }})</span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    {{ __('common.dashboard.received_amount') }}<br><span>({{ __('common.dashboard.only_USDT') }})</span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    <p>{{ __('common.dashboard.number_of_withdrawals') }}</p>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    {{ __('common.dashboard.withdraw_amount') }}<br><span>({{ __('common.dashboard.only_yen') }})</span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    {{ __('common.dashboard.withdrawal_fee') }}<span>({{ __('common.dashboard.only_yen') }})</span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                <div class="info-yen">
                                                    {{ __('common.dashboard.trans_unpaid_amount') }}<span>({{ __('common.dashboard.only_yen') }})</span>
                                                </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('common.dashboard.number_of_new_merchants') }}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="center-table">
                                                {{ __('common.dashboard.number_of_merchant_cancellations') }}</div>
                                        </th>
                                        <th class="detail-col">
                                            <div class="center-table">{{ __('common.dashboard.detail') }}</div>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody id="table-statistic-body">
                                </tbody>
                            </table>
                        </div>

                        @include('epay.dashboard.modal.detail')

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@push('script')
    <script>
        const IS_LANG_JAPANESE = @json($isLangJapanese);
        const DAY_LABEL = "{{ __('common.date_format_label.day') }}"
        const MONTH_LABEL = "{{ __('common.date_format_label.month') }}"
        const YEAR_LABEL = "{{ __('common.date_format_label.year') }}"
        const THOUSAND_UNIT = "{{ __('common.dashboard.thousand_unit') }}"
        const MILLION_UNIT = "{{ __('common.dashboard.million_unit') }}"

        const CHART_DASHBOARD_CANVAS = $("#dashboard-chart-canvas");
        const HIDE_CHART_BNT = $("#hide-chart-btn");
        const SWITCH_VIEW_CHART_BTN = $("#switch-view-chart-btn");
        const TOTAL_TRANSACTIONS = $("#total-transactions");
        const TOTAL_MERCHANT_STORES = $("#total-merchant-stores");
        const TOTAL_AFFILIATES = $("#total-affiliates");

        const TOTAL_CRYPTO_RECEIVE_USDT = $("#total-crypto-receive-usdt");
        const TOTAL_CRYPTO_RECEIVE_USDC = $("#total-crypto-receive-usdc");
        const TOTAL_CRYPTO_RECEIVE_DAI = $("#total-crypto-receive-dai");
        const TOTAL_CRYPTO_RECEIVE_JPYC = $("#total-crypto-receive-jpyc");

        const TOTAL_WITHDRAW_BANK = $("#total-withdraw-bank");
        const TOTAL_WITHDRAW_CRYPTO = $("#total-withdraw-crypto");
        const TOTAL_WITHDRAW_CASH = $("#total-withdraw-cash");

        const YEAR_BOX = $("#year-box");
        const MONTH_BOX = $("#month-box");
        const DAY_BOX = $("#day-box");
        const YEAR_SLT = $("#year-slt");
        const MONTH_SLT = $("#month-slt");
        const DAY_SLT = $("#day-slt");
        const CURRENT_YEAR = moment().year();

        const FORM_SEARCH = $("#form-seach");
        const TABLE_STATISTIC = $("#table-statistic");
        const TABLE_STATISTIC_BODY = $("#table-statistic-body");

        const DASHBOARD_DETAIL_MODAL = $("#dashboard-detail-modal");
        const DASHBOARD_DETAIL_CONTENT_MODAL = $("#dashboard-detail-content-modal");
        const INFO_DATE_DETAIL = $("#info-date-detail");
        const INFO_HOUR_DETAIL = $("#info-hour-detail");
        const DATE_DETAIL_VIEWING_INPUT = $("#date-detail-viewing-input");
        const VIEW_DETAIL_PRE_BTN = $("#view-detail-pre-btn");
        const VIEW_DETAIL_NEXT_BTN = $("#view-detail-next-btn");

        const chartArea = document.getElementById('dashboard-chart-canvas').getContext('2d');
        let dashboardChart = new Chart();


        // Make chart
        function makeChart(dataChart, labels) {
            let chartStatus = Chart.getChart("dashboard-chart-canvas");
            if (chartStatus !== undefined) {
                chartStatus.destroy();
            }
            const selectedLanguage = '{{ app()->getLocale() }}';

            // chart 1st: transaction count
            let transCount = dataChart.trans_count ?? [];
            // chart 2nd:  withdraw request count
            let withdrawSuccessCount = dataChart.withdraw_success_count ?? [];
            // chart 3th:  payment amount (payment success)
            let paymentAmount = dataChart.slash_payment_amount ?? [];
            // chart 4th: withdraw success amount
            let withdrawSuccessAmount = dataChart.withdraw_success_amount ?? [];
            // chart 5th: withdraw fee
            let withdrawFee = dataChart.withdraw_fee ?? [];

            let combinedDataBar = transCount.concat(withdrawSuccessCount);
            let maxValueBarChart = Math.max(...combinedDataBar);
            let stepSizeA = maxValueBarChart > 10 ? 0 : 1; //0: auto, 1: manual

            let combinedDataLine = paymentAmount.concat(withdrawSuccessAmount, withdrawFee);
            let maxValueLineChart = Math.max(...combinedDataLine);
            let stepSizeB = maxValueLineChart > 5 ? 0 : 1;
            // console.log('maxValueLineChart:'+maxValueLineChart , stepSizeA, stepSizeB);

            dashboardChart = new Chart(chartArea, config = {
                data: {
                    labels: labels,
                    datasets: [{ // [0]
                            yAxisID: 'A',
                            /* use right y axis*/
                            type: 'bar',
                            label: '{{ __('common.dashboard.number_of_transactions') }}',
                            data: transCount,
                            backgroundColor: 'rgb(78,115,223)',
                            borderColor: 'rgb(78,115,223)',
                            order: 1
                        },
                        { //[1]
                            yAxisID: 'A',
                            /* use right y axis*/
                            type: 'bar',
                            label: '{{ __('common.dashboard.number_of_withdrawals') }}',
                            data: withdrawSuccessCount,
                            backgroundColor: 'rgb(166,147,247)',
                            borderColor: 'rgb(166,147,247)',
                            order: 1
                        },
                        { //[2]
                            yAxisID: 'B',
                            label: '{{ __('common.dashboard.paid') }}',
                            type: 'line',
                            data: paymentAmount,
                            // data: data1,
                            backgroundColor: 'rgb(28,200,138)',
                            borderColor: 'rgb(28,200,138)',
                            pointRadius: 6,
                            pointBorderColor: 'white',
                        },
                        { //[3]
                            yAxisID: 'B',
                            label: '{{ __('common.dashboard.withdraw_amount') }}',
                            type: 'line',
                            data: withdrawSuccessAmount,
                            backgroundColor: 'rgb(246,194,62)',
                            borderColor: 'rgb(246,194,62)',
                            pointRadius: 6,
                            pointBorderColor: 'white',
                        },
                        { //[4]
                            yAxisID: 'B',
                            /* use left y axis*/
                            label: '{{ __('common.dashboard.withdrawal_fee') }}',
                            type: 'line',
                            data: withdrawFee,
                            backgroundColor: 'rgb(255,82,116)',
                            borderColor: 'rgb(255,82,116)',
                            pointRadius: 6,
                            pointBorderColor: 'white'
                        },
                    ]
                },
                options: {
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
                                if (context.datasetIndex === 1 && context.dataset.data[context.dataIndex] ===
                                    0) {
                                    return value;
                                }
                                return '';
                            }
                        },
                        tooltip: {
                            itemSort: (x, y) => {
                                return x.datasetIndex - y.datasetIndex;
                            },
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
                                    let unit = '';
                                    let valueShow;

                                    if (value >= 10000) {
                                        valueShow = (datasetIndex === 0 || datasetIndex === 1) ?
                                            //number_of_transactions: [0], number_of_withdrawals: [1]
                                            value : (thousandValue).toFixed(2);
                                        unit = (datasetIndex === 0 || datasetIndex === 1) ? unit = '' :
                                            '{{ __('common.dashboard.thousand_money_unit') }}';
                                    } else {
                                        valueShow = value;
                                        unit = (datasetIndex === 0 || datasetIndex === 1) ? unit = '' :
                                            '{{ __('common.dashboard.unit') }}';
                                    }
                                    console.log(valueShow, value);
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
                            afterFit(scale) {
                                selectedLanguage === 'ja' ? scale.width = 72 : scale.width = 68;
                            },
                            type: 'linear',
                            position: 'left',
                            ticks: {
                                font: {
                                    size: 14,
                                },
                                color: '#ABAFB3',
                                stepSize: stepSizeA,
                                callback: (value, index, values) => {
                                    let thousandValue = value / (selectedLanguage === 'ja' ? 1000 : 1000);
                                    let valueShow;
                                    if (value >= 1000) {
                                        valueShow = thousandValue + THOUSAND_UNIT;
                                        return ' ' + valueShow + '   ';
                                    } else {
                                        return ' ' + value + '   ';
                                    }
                                },
                            },
                            grid: {
                                display: true,
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
                                selectedLanguage === 'ja' ? scale.width = 70 : scale.width = 65;
                            },
                            beginAtZero: true,
                            type: 'linear',
                            position: 'right',
                            ticks: {
                                font: {
                                    size: 14,
                                },
                                color: '#ABAFB3',
                                stepSize: stepSizeB, // chart [2], [3], [4]
                                callback: value => {
                                    let thousandValue = value / (selectedLanguage === 'ja' ? 10000 : 1000);
                                    let valueShow;
                                    if (value >= 1000) {
                                        valueShow = thousandValue + THOUSAND_UNIT;
                                        return ' ' + valueShow;
                                    } else {
                                        return ' ' + value;
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
                            xAxes: [{}]
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
        }

        // Change class by language
        $(document).ready(function() {
            const selectedLanguage = '{{ app()->getLocale() }}';
            if (selectedLanguage === 'en') {
                $(CHART_DASHBOARD_CANVAS).removeClass("canvas_ja").addClass("canvas_en");
                $(".legend-all-ja").removeClass("legend-all-ja").addClass("legend-all-en");
            } else {
                $(CHART_DASHBOARD_CANVAS).removeClass("canvas_en").addClass("canvas_ja");
                $(".legend-all-en").removeClass("legend-all-en").addClass("legend-all-ja");
                $(".right-scale-en").removeClass("right-scale-en");
                $(".left-scale-en").removeClass("left-scale-en");
            }
        });

        // plugin-legend
        function toggleData(value) {
            const visibilityData = dashboardChart.isDatasetVisible(value);
            if (visibilityData)
                dashboardChart.hide(value);
            else
                dashboardChart.show(value);

            const elementId = ['bar-first', 'bar-second', 'line-first', 'line-second', 'line-third'][value];
            const element = document.getElementById(elementId);
            const chartCircleText = element.querySelector('.chart-circle-text');
            chartCircleText.classList.toggle('strikethrough');
        }

        // scroll chart
        function scroller(scroll, chart) {
            // console.log(scroll)
            const dataLength = dashboardChart.data.labels.length;
            if (scroll.deltaY > 0) {
                if (dashboardChart.config.options.scales.x.max >= dataLength) {
                    dashboardChart.config.options.scales.x.min = dataLength - 13;
                    dashboardChart.config.options.scales.x.max = dataLength - 1;
                } else {
                    dashboardChart.config.options.scales.x.min += 1;
                    dashboardChart.config.options.scales.x.max += 1;
                }
            } else
            if (scroll.deltaY < 0) {
                if (dashboardChart.config.options.scales.x.min <= 0) {
                    dashboardChart.config.options.scales.x.min = 0;
                    dashboardChart.config.options.scales.x.max = 11;
                } else {
                    dashboardChart.config.options.scales.x.min -= 1;
                    dashboardChart.config.options.scales.x.max -= 1;
                }
            } else {
                //do nothing
            }
            dashboardChart.update();
        }

        function renderDayByMonth() {
            let year = $(YEAR_SLT).val();
            let month = formatFullNumber($(MONTH_SLT).val());
            let date = moment(`${year}-${month}`, 'YYYY-MM')
            let endOfMonth = date.endOf('month').format('DD');

            let html = '';
            for (let i = 1; i <= endOfMonth; i++) {
                html += `
                     <option value="${formatFullNumber(i)}">
                          ${i} ${DAY_LABEL}
                    </option>`
            }
            $(DAY_SLT).html(html);
            $(DAY_SLT).selectpicker('refresh');
            $(DAY_SLT).selectpicker('val', '01');
            $(YEAR_SLT).change(renderDayByMonth);
        }

        function changeType(value) {
            switch (value) {
                case 'by_year':
                    $(YEAR_BOX).hide();
                    $(MONTH_BOX).hide();
                    $(DAY_BOX).hide();
                    break;
                case 'by_month':
                    $(YEAR_BOX).show();
                    $(MONTH_BOX).hide();
                    $(DAY_BOX).hide();
                    break;
                case 'by_day':
                    $(YEAR_BOX).show();
                    $(MONTH_BOX).show();
                    $(DAY_BOX).hide();
                    break;
                default:
                    $(YEAR_BOX).show();
                    $(MONTH_BOX).show();
                    $(DAY_BOX).show();
            }
        }

        function changeMonth() {
            renderDayByMonth();
        }

        function getDetailDashboard(element = false, formData = false) {
            showLoadingPage();
            $("td.detail-col a").addClass('disabled');

            if (!formData) {
                formData = JSON.parse(element.getAttribute('data-object'));
            }
            renderBoxDateTimeViewing(formData)

            $.ajax({
                url: "{{ route('admin_epay.dashboard.detail.get') }}",
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                dataType: 'json',
                data: formData
            }).done(function(response) {
                let html = response.html;
                $(DASHBOARD_DETAIL_CONTENT_MODAL).html(html);
                $(DASHBOARD_DETAIL_MODAL).modal('show');

                // set date detail viewing to hidden input
                $(DATE_DETAIL_VIEWING_INPUT).val(JSON.stringify(formData))
            }).fail(function(err) {
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                $("td.detail-col a").removeClass('disabled');
                hideLoadingPage()
            });
        }

        function getDetailChange(type = "next") {
            let val = $(DATE_DETAIL_VIEWING_INPUT).val();
            let dataInfo = JSON.parse(val);
            let {
                year,
                month,
                day,
                hour
            } = dataInfo;
            let baseDate = `${year}-${month}-${day}`;
            let endOfMonth = +moment(baseDate).endOf('month').format('DD');

            if (type === "next") { // button next
                switch (dataInfo.view_type) {
                    case 'by_year':
                        if (+year >= (CURRENT_YEAR - 10) && +year < CURRENT_YEAR) {
                            dataInfo.year = formatFullNumber(parseInt(dataInfo.year) + 1)
                        }
                        break;
                    case 'by_month':
                        if (+month >= 1 && +month < 12) {
                            dataInfo.month = formatFullNumber(parseInt(dataInfo.month) + 1)
                        }
                        break;
                    case 'by_day':
                        if (+day >= 1 && +day < endOfMonth) {
                            dataInfo.day = formatFullNumber(parseInt(dataInfo.day) + 1)
                        }
                        break;
                    default:
                        if (+hour >= 0 && +hour < 23) {
                            dataInfo.hour = formatFullNumber(parseInt(dataInfo.hour) + 1)
                        }
                }
            } else { // button pre
                switch (dataInfo.view_type) {
                    case 'by_year':
                        if (+year > (CURRENT_YEAR - 10) && +year <= CURRENT_YEAR) {
                            dataInfo.year = formatFullNumber(parseInt(dataInfo.year) - 1)
                        }
                        break;
                    case 'by_month':
                        if (+month > 0 && +month <= 12) {
                            dataInfo.month = formatFullNumber(parseInt(dataInfo.month) - 1)
                        }
                        break;
                    case 'by_day':
                        if (+day > 1 && +day <= endOfMonth) {
                            dataInfo.day = formatFullNumber(parseInt(dataInfo.day) - 1)
                        }
                        break;
                    default:
                        if (+hour > 0 && +hour <= 23) {
                            dataInfo.hour = formatFullNumber(parseInt(dataInfo.hour) - 1)
                        }
                }
            }
            // update set date detail viewing to hidden input
            $(DATE_DETAIL_VIEWING_INPUT).val(JSON.stringify(dataInfo))
            renderBoxDateTimeViewing(dataInfo)
            getDetailDashboard(false, dataInfo)
        }

        function renderBoxDateTimeViewing(dataInfo) {
            // moment.locale('ja')
            let {
                year,
                month,
                day,
                hour
            } = dataInfo;
            let baseDate = `${year}-${month}-${day}`;
            let dateFormat = IS_LANG_JAPANESE ? 'YYYY年MM月DD日' : 'YYYY/MM/DD'
            // 2023 年 5 月 30 日

            switch (dataInfo.view_type) {

                case 'by_year':
                    $(INFO_DATE_DETAIL).text(`${year} ${YEAR_LABEL}`);
                    $(INFO_HOUR_DETAIL).addClass('d-none');
                    if (+year === (CURRENT_YEAR - 10)) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', true);
                    }
                    if (+year === CURRENT_YEAR) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', true);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    if ((+year > (CURRENT_YEAR - 10)) && (+year < CURRENT_YEAR)) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    break;
                case 'by_month':
                    $(INFO_DATE_DETAIL).text(`${year} ${YEAR_LABEL} ${month} ${MONTH_LABEL}`);
                    $(INFO_HOUR_DETAIL).addClass('d-none');
                    if (+month === 1) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', true);
                    }
                    if (+month === 12) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', true);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    if (+month > 1 && +month < 12) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }

                    break;
                case 'by_day':
                    $(INFO_DATE_DETAIL).text(moment(baseDate).format(dateFormat));
                    $(INFO_HOUR_DETAIL).addClass('d-none');
                    let endOfMonth = +moment(baseDate).endOf('month').format('DD');
                    if (+day === 1) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', true);
                    }
                    if (+day === endOfMonth) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', true);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    if (+day > 1 && +day < endOfMonth) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    break;
                default:
                    $(INFO_DATE_DETAIL).text(moment(baseDate).format(dateFormat));
                    $(INFO_HOUR_DETAIL).removeClass('d-none').text(`${hour}:00`);
                    if (+hour === 0) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', true);
                    }
                    if (+hour === 23) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', true);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    if (+hour > 0 && +hour < 23) {
                        $(VIEW_DETAIL_NEXT_BTN).prop('disabled', false);
                        $(VIEW_DETAIL_PRE_BTN).prop('disabled', false);
                    }
                    break;
            }
        }

        function searchData() {
            let formData = $(FORM_SEARCH).serializeArray();
            // formData.push({name: 'day', value: 15});
            getDataDashboard(formData);
        }

        function getDataDashboard(formData) {
            $.ajax({
                url: "{{ route('admin_epay.dashboard.index.get') }}",
                type: 'GET',
                headers: {
                    'Accept': 'application/json'
                },
                dataType: 'json',
                data: formData
            }).done(function(response) {
                let data = response?.data;
                TOTAL_TRANSACTIONS.text(
                    formatNumberInt(data?.total_transactions || 0)
                );
                TOTAL_CRYPTO_RECEIVE_USDT.text(
                    formatNumberDecimal(data?.total_crypto_receive?.USDT || 0)
                );
                TOTAL_CRYPTO_RECEIVE_USDC.text(
                    formatNumberDecimal(data?.total_crypto_receive?.USDC || 0)
                );
                TOTAL_CRYPTO_RECEIVE_DAI.text(
                    formatNumberDecimal(data?.total_crypto_receive?.DAI || 0)
                );
                TOTAL_CRYPTO_RECEIVE_JPYC.text(
                    formatNumberInt(data?.total_crypto_receive?.JPYC || 0)
                );
                TOTAL_WITHDRAW_BANK.text(
                    formatNumberDecimal(data?.total_money_withdraw?.banking || 0)
                );
                TOTAL_WITHDRAW_CASH.text(
                    formatNumberDecimal(data?.total_money_withdraw?.cash || 0)
                );
                TOTAL_WITHDRAW_CRYPTO.text(
                    formatNumberDecimal(data?.total_money_withdraw?.crypto || 0)
                );
                TOTAL_MERCHANT_STORES.text(
                    formatNumberInt(data?.total_merchant_stores || 0)
                );
                TOTAL_AFFILIATES.text(
                    formatNumberInt(data?.total_affiliates || 0)
                );

                makeChart(
                    data?.chart?.data || [],
                    data?.chart?.labels || [],
                );

                renderTable(data?.table || []);
            }).fail(function(err) {
                toastr.error(PROCESS_FAILED_MSG_COMMON);
            }).always(function(xhr) {
                // Todo
            });
        }

        function renderTable(data) {
            let html = '';
            let dataArray = $(FORM_SEARCH).serializeArray();
            let formData = {};
            $(dataArray).each(function(i, field) {
                formData[field.name] = field.value;
            });

            html = data.map((item, index) => {
                console.log(item.payment_amount_success, 'p1payment_amount_success')
                let data = {
                    ...formData
                }
                switch (formData.view_type) {
                    case 'by_year':
                        data.year = parseInt(item.period);
                        break;
                    case 'by_month':
                        data.month = formatFullNumber(parseInt(++index)); //format full number: 01, 02,...
                        break;
                    case 'by_day':
                        data.day = formatFullNumber(parseInt(++index));
                        break;
                    default:
                        data.hour = formatFullNumber(parseInt(index));
                }

                return `
                      <tr>
                            <td> ${ item.period ?? '' } </td>
                            <td> ${formatNumberInt(item.trans_count ?? 0)} </td>
                            <td> ￥ ${formatNumberInt(item.payment_amount_success ?? 0)} </td>
                            <td> ${formatNumberDecimal(item.received_amount ?? 0)} </td>
                            <td> ${formatNumberInt(item.withdraw_success_count ?? 0)} </td>
                            <td> ￥ ${formatNumberInt(item.withdraw_success_amount ?? 0)} </td>
                            <td> ￥ ${formatNumberInt(item.withdraw_fee ?? 0)} </td>
                            <td> ￥ ${formatNumberInt(item.trans_unpaid ?? 0)} </td>
                            <td> ${formatNumberInt(item.merchant_store ?? 0)} </td>
                            <td> ${formatNumberInt(item.merchant_store_cancel ?? 0)} </td>
                            <td class='detail-col'>
                                <a class="show-popup-data" onclick="getDetailDashboard(this)" data-object='${JSON.stringify(data)}' >
                                    {{ __('common.dashboard.detail') }}
                                </a>
                            </td>
                        </tr>`
            })

            if (!html) {
                html = `
                    <td colspan='11'>
                        <div class="center-table">{{ __('common.messages.no_data') }}</div>
                    </td>`
            }
            $(TABLE_STATISTIC_BODY).html(html)
        }

        function closeModal() {
            $(DASHBOARD_DETAIL_MODAL).modal('hide');
        }

        function exportCSV() {
            $(TABLE_STATISTIC).table2csv({
                filename: 'dashboard_' + Date.now() + '.csv',
                separator: ',',
                newline: '\n',
                quoteFields: true,
                excludeColumns: '.detail-col',
                excludeRows: '',
                trimContent: true
            });
        }

        $(document).ready(function() {
            // get data dashboard
            searchData();

            $(SWITCH_VIEW_CHART_BTN).on("change", function(e) {
                const isOn = e.currentTarget.checked;
                if (isOn) {
                    $(HIDE_CHART_BNT).show();
                } else {
                    $(HIDE_CHART_BNT).hide();
                }
            });
        });
    </script>
@endpush
