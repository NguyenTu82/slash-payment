@extends('epay.layouts.base')
@section('title', __('merchant.notification.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_04_01.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        .form-control.list-area-contents.disabled{
            color: #ABAFB3 !important;
            background-color: #f0f0f2 !important;
            font-weight: normal;
            letter-spacing: 0.02em;
            line-height: normal;
            text-align: left;
            font-size: 14px !important;
        }
    </style>
@endpush

@section('content')
<div class=" bg-white">
    <!-- Content Row -->
    <div class="row">
        <div class="col-12 ">
            <div class="account account-list bg-white">
                @include('epay.notification.navbar')
            </div>
            <div class="account bg-white ">
                <form class="form-detail">
                    <h6 class="title-detail-noti">{{ __('admin_epay.notifications.receive_noti_detail') }}</h6>
                    <div class="form-group row form-item noti-detai-type">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.noti_type') }}
                        </label>
                        @php
                            use App\Enums\NotiTypeReceive;
                        @endphp
                        <div class="col col-md-10">
                            <input  type="text" class="form-control form-w200" disabled
                            @if ($notificationReceived->type == \App\Enums\NotiTypeReceive::NEW_REGISTER->value)
                                value=" {{ __('admin_epay.notifications.type_receive.new') }}"
                            @elseif ($notificationReceived->type == \App\Enums\NotiTypeReceive::WITHDRAWAL->value)
                            value=" {{ __('admin_epay.notifications.type_receive.withdraw') }}"
                            @elseif ($notificationReceived->type == \App\Enums\NotiTypeReceive::CANCEL->value)
                            value=" {{ __('admin_epay.notifications.type_receive.cancel') }}"
                            @endif
                            >
                        </div>
                    </div>
                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.merchant_id') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control form-w200" disabled
                                   value="{{ formatAccountId($notificationReceived->merchant_code) }}">
                        </div>
                    </div>
                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.merchant_name') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$notificationReceived->name}}">
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.email') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$notificationReceived->email}}">
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.title') }}*
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$notificationReceived->title}}">
                        </div>
                    </div>
                    <div class="form-group row form-item noti-content-detail">
                        <label for="" class="col col-md-2 col-form-label label-custom noti-content-title">
                            {{ __('admin_epay.notifications.content') }}*
                        </label>
                        <div class="col col-md-10 form-item-ip form-note">
                            <div class="form-control list-area-contents disabled">{!! (($notificationReceived->content)) !!}</div>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col-sm-2 col-form-label label-custom"></label>
                        <div class="col col-md-10 ">
                            <div class="button-action">
                                <div class="btn-back-with500">
                                    <a class="rule rule_epay_notification_edit" href="{{ route('admin_epay.notification.index.get') }}">
                                        <button
                                                data-toggle="modal"
                                                data-target="#confirmModal"
                                                type="button"
                                                class="btn form-close"
                                               > {{ __('common.button.back') }}
                                        </button>
                                    </a>
                                </div>

                                <button
                                        type="button"
                                        class="btn btn-delete-detail rule rule_epay_notification_delete"
                                        data-toggle="modal" data-target="#confirm-modal-delete"
                                        id="delete-account">
                                        {{ __('common.button.delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        {{-- modal confirm  --}}
        @include('common.modal.confirm_delete', [
            'title' => __('merchant.notification.title_confirm_modal_delete'),
            'description' => __('merchant.notification.description_confirm_modal_delete'),
            'url' => route('admin_epay.notification.receive_delete.get', ['id' => object_get($notificationReceived, 'id')]),
             'id' => 'confirm-modal-delete'
        ])
    </div>
</div>
@endsection

@push('script')
    <script>
        const CHANGE_PASSWORD_MODAL = $("#change-password-modal");
        const CONFIRM_CHANGE_PASSWORD_MODAL = $("#confirm-modal");
        const CHANGE_PASSWORD_FORM = $("#change-password-form");
    </script>
@endpush
