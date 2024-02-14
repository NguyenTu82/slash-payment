@extends('merchant.layouts.base')
@section('title', __('merchant.notification.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/detail_noti.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_form.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        #content{
            background-color: #FFFFFF !important;
        }
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
    <div class="row">
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white">
                <form class="form-detail">
                    <h6 class="title-detail-noti">{{ __('merchant.notification.title_noti_detail') }}</h6>
                    <div class="form-group row form-item noti-detai-member-store ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.notification.noti.merchant') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$merchant->name}}">
                        </div>
                    </div>
                    <div class="form-group row form-item noti-detai-type ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.notification.noti.noti_type') }}
                        </label>
                        <div class="col col-md-10">
                                   @php
                                use App\Enums\MerchantNotiType;
                            @endphp
                            @if ($noti->type == \App\Enums\MerchantNotiType::WITHDRAW->value)
                            <input disabled type="text" class="form-control " id="input-name"
                                name="type" value="{{ __('merchant.notification.noti.type_withdraw') }}">
                                    @elseif ($noti->type == \App\Enums\MerchantNotiType::OTHER->value)
                                    <input disabled type="text" class="form-control " id="input-name"
                                    name="type" value="{{ __('merchant.notification.noti.type_other_noti') }}">
                                    @endif
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.notification.noti.send_date') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$noti->send_date}}">
                        </div>
                    </div>
                    <div class="form-group row form-item ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('merchant.notification.noti.title') }}
                        </label>
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                   value="{{$noti->title}}">
                        </div>
                    </div>

                    <div class="form-group row form-item noti-content-detail">
                        <label for="" class="col col-md-2 col-form-label label-custom noti-content-title">
                            {{ __('merchant.notification.noti.content') }}
                        </label>
                        <div class="col col-md-10 form-item-ip form-note">
                            <div  class="form-control list-area-contents disabled" id="input-note">{!! (($noti->content)) !!}</div>
                        </div>
                    </div>

                    <div class="form-group row form-item">
                        <label for="" class="col-sm-2 col-form-label label-custom"></label>
                        <div class="col col-md-10 ">
                            <div class="button-action">
                                <a href="{{ route('merchant.notification.index.get') }}">
                                    <button onclick="returnEditAccount()" type="button" class="btn form-close"
                                        id="return-edit-account"> {{ __('common.button.back') }}
                                    </button>
                                </a>
                                <a>
                                    <button data-toggle="modal" data-target="#confirm-modal-delete" type="button"
                                        class="btn btn-delete-detail rule rule_merchant_notification_delete" id="delete-account"> {{ __('common.button.delete') }}
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            {{-- modal confirm  --}}
            @include('common.modal.confirm_delete', [
                'title' => __('merchant.notification.title_confirm_modal_delete'),
                'description' => __('merchant.notification.description_confirm_modal_delete'),
                'url' => route('merchant.notification.delete.get', ['id' => object_get($noti, 'id')]),
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
