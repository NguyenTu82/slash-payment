@extends('epay.layouts.base')
@section('title', __('admin_epay.report.report_list'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_07_02.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_table.css') }}">
    <style>
        .container-fluid.bg-white {
            background-color: #F1F1F1 !important;
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
                    <form class="form-detail" id="edit-report" method="POST"
                        action="{{ route('admin_epay.report.edit.post', $report->id) }}">
                        @csrf
                        <h6 class="title-detail-noti">{{ __('admin_epay.report.report_edit') }}</h6>
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
                                    value="{{ $report->merchantStore['name'] }}">
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
                                <textarea class="form-control list-area-contents-remarks" rows="5" name="note">{{ $report->note }}</textarea>
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
                                            <button type="button" class="btn btn-edit-detail transparent-disable"
                                                id="">
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
                        <div class="form-group row form-item form-group-button">
                            <label for="" class="col-md-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 ">
                                <div class="button-action">
                                    <div class="">
                                        <button type="submit" class="btn btn-edit-detail mr-25">
                                            {{ __('common.button.submit') }}
                                        </button>
                                        <a class=""
                                            href="{{ route('admin_epay.report.detail.get', ['id' => $report->id]) }}">
                                            <button type="button" class="btn form-close">
                                                {{ __('common.button.back') }}
                                            </button>
                                        </a>

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

            @include('common.modal.confirm', [
                'title' => __('admin_epay.report.update_modal_title'),
                'description' => __('admin_epay.report.update_modal_description'),
                'submit_btn' => __('common.button.submit'),
            ])
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#submit-form').on('click', function() {
                $('#edit-report')[0].submit();
            });
            $("#edit-report").validate({
                submitHandler: function() {
                    $('#confirm-modal').modal('show')
                }
            })
            const pdfBase64 = '{{ $base64Content }}'; // Base64-encoded PDF data
            displayPDF(pdfBase64);
        });
    </script>
@endpush
