@extends('epay.layouts.base')
@section('title', __('admin_epay.report.report_list'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_07_02.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_table.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_pdf.css') }}">
    <style>
        .container-fluid.bg-white {
            background-color: #F1F1F1 !important;
        }

        .item {
            padding: 5px;
            width: 48%;
            height: 1000px;
            margin-top: 10px;
            font-weight: bold;
            text-align: center;
        }

        #pdfContainer {
            text-align: center;
        }
    </style>
@endpush

@php
    use App\Enums\EpayReportStatus;
@endphp
@section('content')
    <div class="row">
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white d-flex outline-transparent">
                <div class="col-5">
                    <form class="form-detail">
                        <h6 class="title-detail-noti">{{ __('admin_epay.report.report_detail') }}</h6>
                        <div class="form-group row form-item noti-detai-member-store ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.report_code') }}
                            </label>
                            <div class="col col-md-10">
                                <input type="text" class="form-control form-control-w200" disabled
                                    value="{{ $report->report_code }}">
                            </div>
                        </div>
                        <div class="form-group row form-item noti-detai-type ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.merchant') }}
                            </label>
                            <div class="col col-md-10">
                                <input type="text" class="form-control" disabled
                                    value="{{ formatAccountId($report->merchant_code) }} - {{ $report->merchantStore['name'] }}">
                            </div>
                        </div>
                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.period') }}
                            </label>
                            <div class="col col-md-10">
                                <input type="text" class="form-control" disabled
                                    value="{{ convertTimeJapan($report->period_from) }} 〜 {{ convertTimeJapan($report->period_to) }}">
                            </div>
                        </div>
                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.issue_date') }}
                            </label>
                            <div class="col col-md-10">
                                <input type="text" class="form-control" disabled
                                    value="{{ convertTimeJapan($report->issue_date) }}">
                            </div>
                        </div>
                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.email') }}
                            </label>
                            <div class="col col-md-10">
                                <input type="text" class="form-control" disabled value="{{ $report->send_email }}">
                            </div>
                        </div>
                        <div class="form-group row form-item ">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.note') }}
                            </label>
                            <div class="col col-md-10">
                                <textarea class="form-control list-area-contents-remarks" rows="5" disabled>{{ $report->note }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.report.status') }}
                            </label>
                            <div class="col col-md-10">
                                <div class="form-input-action-btn">
                                    <div class="action-popup">
                                        @if ($report->status == EpayReportStatus::SENT->value)
                                            <input type="text" class="form-control form-control-w335" disabled
                                                value="{{ __('admin_epay.report.status_type.sent') }}">
                                        @elseif($report->status == EpayReportStatus::UNSEND->value)
                                            <input type="text" class="form-control form-control-w335" disabled
                                                value="{{ __('admin_epay.report.status_type.un_send') }}">
                                        @endif
                                        <div class="group-text-popup">
                                            <p class="text-popup text-underline" data-toggle="modal"
                                                data-target="#transaction-info-modal">
                                                {{ __('admin_epay.report.transaction_info_confirm') }}</p>
                                            <p class="text-popup text-popup-confirm text-underline" data-toggle="modal"
                                                data-target="#received-info-modal">
                                                {{ __('admin_epay.report.transaction_virtual_info_confirm') }}</p>
                                        </div>
                                    </div>
                                    <div class="action-popup">
                                        <div class="form-button-h52">
                                            <button type="button" class="btn btn-edit-detail" id="send-mail"
                                                onclick="getEmail('{{ $report->send_email }}', '{{ $report->id }}')">
                                                {{ __('common.button.send') }}
                                            </button>
                                        </div>
                                        <p class="text-popup text-popup-btn text-underline" data-toggle="modal"
                                            data-target="#withdraw-info-modal">
                                            {{ __('admin_epay.report.withdraw_info_confirm') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- button -->
                        <div class="form-group row form-item form-group-button mb-0">
                            <label for="" class="col-md-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 ">
                                <div class="button-action">
                                    <div class="btn-w500">
                                        <a class="" href="{{ route('admin_epay.report.edit.get', $report->id) }}">
                                            <button type="button" class="btn btn-edit-detail">
                                                {{ __('common.button.edit') }}
                                            </button>
                                        </a>
                                        <a class="" href="{{ route('admin_epay.report.index.get') }}">
                                            <button type="button" class="btn form-close">
                                                {{ __('common.button.back') }}
                                            </button>
                                        </a>
                                        <button type="button" class="btn btn-primary"
                                            onclick="downloadPDF()">{{ __('common.button.print') }}</button>
                                    </div>
                                    <div class="btn-w500 delete-custom">
                                        <button type="button" class="btn btn-delete-detail " data-toggle="modal"
                                            data-target="#confirm-modal-delete" id="delete-btn">
                                            {{ __('common.button.delete') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-7 mt-25">
                    <div class="pdf-bg pdf-container">
                        <div id="pdfContainer"></div>
                    </div>
                </div>

            </div>
            {{-- modal transaction info  --}}
            @include('epay.report.modal.payment_info', [
                'payment_info' => (object) $report->payment_amount,
            ])

            {{-- modal withdraw info  --}}
            @include('epay.report.modal.withdraw_info', [
                'withdraw_info' => (object) $report->withdraw_amount,
            ])

            {{-- modal transaction virtual info  --}}
            @include('epay.report.modal.receive_info', [
                'receive_info' => (object) $report->received_amount,
            ])

            @include('common.modal.confirm_delete', [
                'title' => __('admin_epay.report.delete_modal_title'),
                'description' => __('admin_epay.report.delete_modal_description'),
                'url' => route('admin_epay.report.delete', $report->id),
                'id' => 'confirm-modal-delete',
            ])

            @include('common.modal.confirm_send', [
                'title' => __('admin_epay.report.send_mail_modal_title'),
                'submit_btn' => __('common.button.send'),
            ])
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        function getEmail(email, id) {
            $('#email_span_report').html(email);
            $('input[name=report_id]').val(id);
            $('input[name=type]').val("detail");
            $('#confirm-send-modal').modal("show");
            $('.modal-backdrop').show();
        }

        function downloadPDF() {
            const pdfBase64 = '{{ $base64Content }}';

            // Create a temporary <a> element
            const link = document.createElement('a');
            link.href = 'data:application/pdf;base64,' + encodeURIComponent(pdfBase64);
            link.download = "{{ $report->merchantStore['name'] }}-{{ $report->report_code }}.pdf";

            link.click();
        }

        $(document).ready(function() {
            $('#submit-form').on('click', function() {
                window.location.href =
                    "{{ route('admin_epay.report.send', ['type' => 'detail', 'id' => $report->id]) }}"
            });

            const pdfBase64 = '{{ $base64Content }}'; // Base64-encoded PDF data
            displayPDF(pdfBase64);
        });
    </script>
@endpush
