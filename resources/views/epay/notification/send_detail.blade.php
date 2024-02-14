@extends('epay.layouts.base', ['title' => __('common.notification.title')])
@section('title', __('common.notification.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_04_05.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="account account-list bg-white">
            @include('epay.notification.navbar')
        </div>
        <div class="col-12 detail-list-manager">
            <div class="account bg-white page-white">
                <form class="form-detail">
                    <h6 class="title-detail-noti">{{ __('admin_epay.notifications.createNew.title') }}</h6>
                    <div class="form-group row form-item noti-detai-member-store ">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.createNew.receiver') }}
                        </label>
                        @php
                            use \App\Enums\NotiTypeSend;
                        @endphp
                        <div class="col col-md-10">
                            <input  type="text" class="form-control" disabled
                                    value="{{$notificationSend->type == NotiTypeSend::ALL->value ? __('admin_epay.notifications.type_send.all') : __('admin_epay.notifications.type_send.part')}}">
                        </div>
                    </div>
                    @if($notificationSend->type == NotiTypeSend::PART->value)
                        <div id="hiddenDiv">
                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('admin_epay.notifications.createNew.group.title') }}
                                </label>
                                <div class="col col-md-10 form-note-textarea border-erro">
                                    <div class="form-control list-area-members" style="padding: 15px 0 15px 15px; color: #ABAFB3 !important; background: #f0f0f2 !important; font-size: 14px !important">
                                        @foreach($notificationSend->dataMerchantName as $value)
                                            <p class="members-item">{{$value}}</p>
                                            <div class="line-item"></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    @if ($notificationSend->status  == \App\Enums\NotiStatusSend::SEND->value)
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.notifications.send_date') }}
                            </label>
                            <div class="col col-md-10 form-edit-input" >
                                <input type="text" name="title" class="form-control" value="{{$notificationSend->actual_send_date}}" disabled>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                    @else
                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.notifications.schedule_send') }}
                            </label>
                            <div class="col col-md-10 form-edit-input" >
                                <input type="text" name="title" class="form-control" value="{{$notificationSend->schedule_send_date}}" disabled>
                                <div class="note-pass"></div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.status') }}
                        </label>
                        <div class="col col-md-10 form-edit-input" >
                            <input type="text" name="title" class="form-control" value="{{$notificationSend->status == \App\Enums\NotiStatusSend::SEND->value ? __('admin_epay.notifications.status_send.send') : __('admin_epay.notifications.status_send.not_send')}}" disabled>
                            <div class="note-pass"></div>
                        </div>
                    </div>
                    <div class="form-group row form-item">
                        <label for="" class="col col-md-2 col-form-label label-custom">
                            {{ __('admin_epay.notifications.createNew.notiTitle') }}
                        </label>
                        <div class="col col-md-10 form-edit-input" >
                            <input type="text" name="title" class="form-control" value="{{$notificationSend->title}}" disabled>
                            <div class="note-pass"></div>
                        </div>
                    </div>
                    <div class="form-group row form-item noti-content-detail">
                        <label for="" class="col col-md-2 col-form-label label-custom noti-content-title">
                            {{ __('admin_epay.notifications.createNew.content') }}
                        </label>
                        <div class="col col-md-10 orm-item-ip form-note">
                                    <div class="editor-custom list-area-contents" style="padding: 15px 0 15px 15px; color: #ABAFB3 !important; background: #f0f0f2 !important; font-size: 14px !important">
                                        {!!$notificationSend->content!!}
                                    </div>
                        </div>
                    </div>
                    <div class="form-group row form-item">
                        <label for="" class="col-sm-2 col-form-label label-custom"></label>
                        <div class="col col-md-10 ">
                            <div class="button-action">
                                @if ($notificationSend->status == \App\Enums\NotiStatusSend::UNSEND->value && \Carbon\Carbon::parse($notificationSend->schedule_send_date) >= \Carbon\Carbon::now())
                                    <a class="rule rule_epay_notification_edit" href="{{ route('admin_epay.notification.send_edit.get',$notificationSend->id) }}">
                                        <button
                                            type="button"
                                            class="btn btn-edit-detail"

                                        > {{ __('common.button.edit') }}
                                        </button>
                                    </a>
                                @else
                                    <a class="rule rule_epay_notification_edit" href="{{ route('admin_epay.notification.send_edit.get',$notificationSend->id) }}">
                                        <button
                                            type="button"
                                            class="btn btn-edit-detail  transparent-disable "

                                            disabled
                                        > {{ __('common.button.edit') }}
                                        </button>
                                    </a>
                                @endif
                                    <a class="rule rule_epay_notification_detail" href="{{ route('admin_epay.notification.index.get',['select_type' => 1]) }}">
                                        <button
                                            type="button"
                                            class="btn form-close"
                                           > {{ __('common.button.back') }}
                                        </button>
                                    </a>
                                    <button
                                        data-target="#confirm-modal-delete" type="button"
                                        class="btn btn-delete btn-delete-detail form-submit rule rule_epay_notification_delete"
                                        id="delete-account">{{__('common.delete')}}
                                    </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
    @include('common.modal.confirm_delete', [
        'title' => __('admin_epay.notifications.common.title_confirm_delete_send_noti'),
        'description' => __('admin_epay.notifications.common.content_confirm_delete_send_noti'),
        'url' => route('admin_epay.notification.send_delete.get', $notificationSend->id),
        'id' => 'confirm-modal-delete'
    ])
@endsection

@push('script')
    <script src="{{ asset('dashboard/libs/quill.min.js') }}"></script>
    <script>
        $('#delete-account').click(()=>{
            $('#confirm-modal-delete').modal("show")
        })
    </script>
@endpush
