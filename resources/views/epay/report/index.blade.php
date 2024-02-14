@extends('epay.layouts.base')
@section('title', __('admin_epay.report.report_list'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_07_01.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        .container-fluid.bg-white {
            background-color: #F1F1F1 !important;
        }

        #selectMerchant .form-control {
            height: 52px;
        }
        #selectMerchant .merchant-item-custom {
            width: 100%;
        }
    </style>
@endpush

@php
    use App\Enums\EpayReportStatus;
@endphp
@section('content')
    <div class="row">
        <div class="col-12 mt-15">
            <div class="list_search bg-white d-flex">
                <h6 class="font-weight-bold text-primary ml-15">
                    {{ __('admin_epay.report.report_create') }}
                </h6>
                <form class="form-search mr-30" id="create-report">
                    <div class="option-show-table">
                        <div class="date-form-to">
                            <span class="seperate seperate-search">{{ __('admin_epay.report.merchant') }}</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="merchant_store_id" type="text" name="merchant_select"
                                        class="form-control input_time input_time-search"
                                        value="" />
                                    <input type="hidden" name="merchant_store_id" value="{{ $merchantsList[0]->id }}">
                                    <button type="button" class="btn btn-edit-detail merchant-slt-btn ml-15"
                                        data-toggle="modal" data-target="#selectMerchant">
                                        {{ __('merchant.setting.profile.choose_store') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="date-form-to">
                            <span class="seperate seperate-search">{{ __('admin_epay.report.period') }}</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="createIssueDateFrom" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja"
                                        name="create_issue_date_from" class="form-control input_time input_time-search"
                                        value="" />
                                    <label for="createIssueDateFrom">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate seperate-search">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="createIssueDateTo" type="text" placeholder="年/月/日"
                                        name="create_issue_date_to" class="form-control input_time input_time-search"
                                        value="" />
                                    <label for="createIssueDateTo">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="action-table">
                            <button class="btn btn-primary btn-add" data-toggle="modal" id="createReport">
                                {{ __('common.button.create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 mt-15">
            <div class="list_search bg-white d-flex">
                <form class="form-search">
                    <div class="form-input">
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.report.report_code') }}</p>
                            <input type="text" class="form-control input_infor" name="report_code"
                                value="{{ $request->report_code }}" />
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.report.merchant_id') }}</p>
                            <input type="text" class="form-control form-w200 input_infor" name="merchant_code"
                                value="{{ $request->merchant_code }}" />
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.report.merchant_name') }}</p>
                            <input type="text" class="form-control input_infor" name="merchant_name"
                                value="{{ $request->merchant_name }}" />
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.report.email') }}</p>
                            <input type="text" class="form-control input_infor" name="email"
                                value="{{ $request->email }}" />
                        </div>
                    </div>
                    <div class="form-select-action">
                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('admin_epay.report.issue_date') }}</p>
                                <div class="input_date">
                                    <input id="issueDateFrom" type="text" placeholder="年/月/日" name="issue_date_from"
                                        class="form-control input_time border-1 small"
                                        value="{{ $request->issue_date_from }}" />
                                    <label for="issueDateFrom">
                                        <img src="../../../../../dashboard/img/date.svg" class=" mx-auto icon"
                                            alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="issueDateTo" type="text" placeholder="年/月/日" name="issue_date_to"
                                        class="form-control input_time border-1 small"
                                        value="{{ $request->issue_date_to }}" />
                                    <label for="issueDateTo">
                                        <img src="../../../../../dashboard/img/date.svg" class=" mx-auto icon"
                                            alt="">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.report.status') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="status">
                                    <option value="">{{ __('common.label.all') }}</option>
                                    <option value="{{ EpayReportStatus::UNSEND->value }}"
                                        @if ($request->status === (string) EpayReportStatus::UNSEND->value) selected @endif>
                                        {{ __('admin_epay.report.status_type.un_send') }}</option>
                                    <option value="{{ EpayReportStatus::SENT->value }}"
                                        @if ($request->status === (string) EpayReportStatus::SENT->value) selected @endif>
                                        {{ __('admin_epay.report.status_type.sent') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex flex button__click">
                            <div class="action__button d-flex flex">
                                <button type="submit" class="btn btn_ok">{{ __('common.search') }}</button>
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
                        {{ __('admin_epay.report.report_table_title') }}
                    </h6>
                    <button class="btn btn-primary btn-csv" id="export-csv-btn">{{ __('common.button.csv') }}</button>
                </div>
                <!-- Card Body -->
                <div class="table-data">
                    <div class="table-responsive p-0">
                        <table class="table table-fixed table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.report_code') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.merchant_id') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.merchant_name') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.period') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.issue_date') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.status') }}</div>
                                    </th>
                                    <th>
                                        <div class="center-table">
                                            <div class="info-yen">
                                                <p>{{ __('admin_epay.report.transaction_amount') }}</p>
                                                <p class="yen-unit">{{ __('admin_epay.report.only_yen') }}</p>
                                            </div>
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('admin_epay.report.send') }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($dataList->count() > 0)
                                    @foreach ($dataList as $report)
                                        <tr>
                                            <td>
                                                <a class="show-popup-data"
                                                    href="{{ route('admin_epay.report.detail.get', ['id' => $report->id]) }}">
                                                    {{ $report->report_code }}
                                                </a>
                                            </td>
                                            <td class="text-number-font">
                                                <a class="show-popup-data"
                                                    href="{{ route('admin_epay.merchantStore.detail', ['id' => $report->merchant_store_id]) }}">
                                                    {{ formatAccountId($report->merchant_code) }}
                                                </a>
                                            </td>
                                            <td>{{ $report->merchant_store_name }}</td>
                                            <td>{{ $report->period_from->format('Y年n月j日') }}~{{ $report->period_to->format('Y年n月j日') }}
                                            </td>
                                            <td>{{ $report->issue_date->format('Y年n月j日') }}</td>
                                            @php
                                                $reportStatusInfo = getReportStatus($report->status);
                                            @endphp
                                            <td class="status_item">
                                                <div class="center-table">
                                                    <div class="status  {{ $reportStatusInfo['class'] }} ">
                                                        {{ $reportStatusInfo['label'] }}
                                                    </div>
                                                </div>
                                            </td>
                                            @php
                                                $data = json_decode($report->withdraw_amount, true);
                                                $withdrawnValue = $data ? $data[0]['withdrawable_amount'] : '0';
                                            @endphp
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    ￥{{ formatNumberDecimal($withdrawnValue, 3) }}
                                                </div>
                                            </td>
                                            <td>
                                                <a onclick="getEmail('{{ $report->send_email }}', '{{ $report->id }}')"
                                                    class="show-popup-data" id="send">
                                                    {{ __('common.button.send') }}
                                                </a>
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
                @include('common.pagination', ['paginator' => $dataList])
            </div>
        </div>
    </div>
    @include('common.modal.confirm_send', [
        'title' => __('admin_epay.report.send_mail_modal_title'),
        'submit_btn' => __('common.button.send'),
    ])

    @include('common.modal.confirm', [
        'title' => __('admin_epay.report.create_modal_title'),
        'description' => __('admin_epay.report.create_modal_description'),
        'submit_btn' => __('common.button.create'),
    ])

    @include('common.modal.error', [
        'title' => '入力チェックのエラー',
        'description' => __('admin_epay.report.update_modal_description'),
        'submit_btn' => __('admin_epay.merchant.common.rewrite'),
    ])

    @include('epay.withdraw.request.modal.select_merchant', [
        'stores' => $merchantsList,
    ])
@endsection

@push('script')
    <script type="text/javascript">
        $('input[name=create_issue_date_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=create_issue_date_to]').datepicker(COMMON_DATEPICKER);
        $('input[name=issue_date_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=issue_date_to]').datepicker(COMMON_DATEPICKER);
        const SEARCH_FORM = $("#search");
        const RESET_FORM_BTN = $("#reset-form-btn");
        const EXPORT_CSV_BTN = $("#export-csv-btn");
        const MERCHANT_STORE_SLT = $('input[name=merchant_store_id]');
        const ALL_MERCHANT_STORES = @json($merchantsList);

        $(document).ready(function() {
            $('#submit-form').on('click', function() {
                $('#create-report')[0].submit();
                $(this).prop("disabled", true);
            });

            $("#create-report").validate({
                focusInvalid: false,
                rules: {
                    merchant_select: {
                        required: true,
                    },
                    create_issue_date_from: {
                        required: true,
                        checkMaxDate: true,

                    },
                    create_issue_date_to: {
                        required: true,
                        checkMaxToday: true,
                    },
                },
                messages: {
                    merchant_select: {
                        required: "{{ __('admin_epay.report.validate.merchant_required') }}",
                    },
                    create_issue_date_from: {
                        required: "{{ __('admin_epay.report.validate.issue_date_from_required') }}",
                        checkMaxDate: "{{ __('admin_epay.report.validate.max_date') }}",
                    },
                    create_issue_date_to: {
                        required: "{{ __('admin_epay.report.validate.issue_date_to_required') }}",
                        checkMaxToday: "{{ __('admin_epay.report.validate.max_today') }}",
                    },
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    const name = $(element).attr('name');
                    $(`#${name}-error`).find('.error').remove();
                    $(`#${name}-error`).append(error);
                },
                unhighlight: function(element) {
                    const name = $(element).attr('name');
                    $(`#${name}-error`).find('.error').remove();
                },
                submitHandler: function() {
                    $('#confirm-modal').modal('show');
                    $('.modal-backdrop').show();
                },
                invalidHandler: function(event, validator) {
                    $('#error-modal').modal('show');
                    $('.modal-backdrop').show();
                }
            })

            $.validator.addMethod("checkMaxDate", function(value, element) {
                let toDate = $("input[name='create_issue_date_to']").val();
                if (!toDate) return true;

                const fromDate = new Date(value);
                toDate = new Date(toDate);

                return toDate >= fromDate;
            });

            $.validator.addMethod("checkMaxToday", function(value, element) {
                if (!value) return false;

                const toDate = new Date(value);
                const today = new Date();

                return toDate <= today;
            });
        });

        function getEmail(email, id) {
            $('#email_span_report').html(email);
            $('input[name=report_id]').val(id);
            $('input[name=type]').val("list");
            $('#confirm-send-modal').modal("show");
            $('.modal-backdrop').show();
        }

        RESET_FORM_BTN.on("click", function() {
            window.location.href = "{{ route('admin_epay.report.index.get') }}";
        });

        EXPORT_CSV_BTN.on("click", function() {
            let url = window.location.href;
            let str = url.includes("?") ? "&" : "?"
            let param = {
                'export_csv': true
            };
            url = url + str + $.param(param);
            window.open(url);
            return false;
        });

        function handleChangeMerchantStore() {}
    </script>
@endpush
