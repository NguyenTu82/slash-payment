@extends('epay.layouts.base')
@section('title', __('common.screens.notification_list'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_04_03.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <style>
        #input-template-content-disable {
            background-color: #f0f0f2;
        }

        #input-template-content-disable>* {
            color: #ABAFB3;
            font-size: 14px;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12">
                <div class="account account-list bg-white">
                    @include('epay.notification.navbar')
                </div>
                <div class="account bg-white">
                    <form class="form-detail form-dropdown-input" method="POST" role="form" id="update-template-form">
                        @csrf
                        <h6 class="title-detail-noti">{{ __('admin_epay.notifications.noti_detail') }}</h6>
                        <div class="form-group row form-item noti-detai-type">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.notifications.noti_type') }}
                            </label>
                            <div class="col col-md-10">
                                <div class="select_info">
                                    <select class="form_control select_form" id="select_type" onChange="onChangeType()"
                                        name="select_type">
                                        @php
                                            use App\Enums\NotiTypeReceive;
                                        @endphp
                                        @foreach ($notifications as $noti)
                                            <option value="{{ $noti->type }}">
                                                @switch($noti->type)
                                                    @case(NotiTypeReceive::NEW_REGISTER->value)
                                                        {{ __('admin_epay.notifications.type_receive.new') }}
                                                    @break

                                                    @case(NotiTypeReceive::WITHDRAWAL->value)
                                                        {{ __('admin_epay.notifications.type_receive.withdraw') }}
                                                    @break

                                                    @case(NotiTypeReceive::CANCEL->value)
                                                        {{ __('admin_epay.notifications.type_receive.cancel') }}
                                                    @break
                                                @endswitch
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row form-item form-item-error">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('admin_epay.notifications.title') }}*
                            </label>
                            <div class="col col-md-10 form-edit-input">
                                <input type="text" class="form-control editable" id="input_template_title" name="title"
                                    disabled value="【{{ $notifications->first()->title }}】" />
                                <div class="note-pass"></div>
                            </div>
                        </div>
                        <div class="form-group row form-item noti-content-detail form-item-error">
                            <label for="" class="col col-md-2 col-form-label label-custom noti-content-title">
                                {{ __('admin_epay.notifications.content') }}*
                            </label>
                            <div class=" col col-md-10 form-editor-input" id="test">
                                <div contenteditable="false" class="form-control list-area-contents"
                                    id="input-template-content-disable" disabled>
                                    {!! $notifications->first()->content !!}
                                </div>
                                <div class="editor-custom d-none" id="input-template-content-editable">
                                    <input type="hidden" id="quillHtml" name="content" value="{{ old('content') }}" />
                                    <div id="editor"></div>
                                </div>
                                <div class="note-pass note-error-editor ml-15"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom"></label>
                            <div class="col col-md-10 ">
                                <div class="button-action">
                                    <button type="button" class="btn btn-edit-detail" onclick="editTemplate()"
                                        id="edit-template"> {{ __('common.button.edit') }}
                                    </button>
                                    <button onclick="confirmUpdateTemplate()" type="button"
                                        class="btn btn-edit-detail d-none" id="confirm-update-template">
                                        {{ __('common.button.submit') }}
                                    </button>
                                    <button type="button" class="btn form-close" onclick="goBack()" id="go-back">
                                        {{ __('common.button.back') }}
                                    </button>
                                    <button type="button" class="btn form-close d-none" onclick="cancelEdit()"
                                        id="cancel-update-template"> {{ __('common.button.back') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @include('common.modal.confirm', [
        'title' => __('common.notification.title_confirm_modal_update'),
        'description' => __('common.notification.description_confirm_modal_update'),
        'submit_btn' => __('common.button.submit'),
    ])

    @include('common.modal.cancel', [
        'title' => __('common.notification.title_confirm_modal_save'),
        'description' => __('common.notification.description_confirm_modal_save'),
        'submit_btn' => __('common.button.ok'),
    ])

    @include('common.modal.result', getPopupInfo('update_notification_template_success'))
@endsection

@push('script')
    <script src="{{ asset('dashboard/libs/quill.min.js') }}"></script>
    <script type="text/javascript">
        const TITLE = $("#input_template_title");
        const CONTENT = $("#input-template-content-editable");
        const CONTENT_DISABLE = $("#input-template-content-disable");
        const UPDATE_SUCCESSFUL_MSG = "{{ __('common.messages.update_successful') }}";
        const UPDATE_FAILED_MSG = "{{ __('common.messages.update_failed') }}";
        const CONFIRM_UPDATE_TEMPLATE_MODAL = $("#confirm-modal");
        const CANCEL_UPDATE_TEMPLATE_MODAL = $("#cancel-modal");
        const SUCCESS_UPDATE_TEMPLATE_MODAL = $("#result-modal");
        const UPDATE_TEMPLATE_FORM = $("#update-template-form");
        const EDIT_TEMPLATE_BTN = $("#edit-template");
        const CONFIRM_UPDATE_TEMPLATE_BTN = $("#confirm-update-template");
        const CANCEL_UPDATE_TEMPLATE_BTN = $("#cancel-update-template");
        const GO_BACK_BTN = $("#go-back");
        const SELECT_BTN = $("#select_type");
        const QUILL = new Quill('#editor', {
            theme: 'snow'
        });

        const notifications = {!! json_encode($notifications->toArray()) !!};
        let template_id = notifications[0].id;

        function confirmUpdateTemplate() {
            console.log(UPDATE_TEMPLATE_FORM.valid());
            if (UPDATE_TEMPLATE_FORM.valid()) {
                CONFIRM_UPDATE_TEMPLATE_MODAL.modal('show');
            }
        }

        function goBack() {
            history.back()
        }

        function cancelEdit() {
            if ($(UPDATE_TEMPLATE_FORM).valid()) {
                $(CANCEL_UPDATE_TEMPLATE_MODAL).modal('show');
            }
        }

        function editTemplate() {
            let data = notifications.find(value => value.type === $(SELECT_BTN).val());
            $(TITLE).val(data.title);
            $(CONTENT).val(data.content);
            $(".editable").attr("disabled", false).parent().find('button').removeClass("disabled");
            $(CONTENT_DISABLE).addClass('d-none');
            $(CONTENT).removeClass('d-none');
            $(EDIT_TEMPLATE_BTN).addClass('d-none');
            $(CONFIRM_UPDATE_TEMPLATE_BTN).removeClass('d-none');
            $(CANCEL_UPDATE_TEMPLATE_BTN).removeClass('d-none');
            $(GO_BACK_BTN).addClass('d-none');
            QUILL.setContents(QUILL.clipboard.convert(data.content));
        }

        function onChangeType(elm) {
            let data = notifications.find(value => value.type === $(SELECT_BTN).val());
            template_id = data.id;
            $(TITLE).val(data.title);
            CONTENT_DISABLE.html(data.content);
            QUILL.setContents(QUILL.clipboard.convert(data.content));
        }

        function updateTemplate() {
            let url = "{{ route('admin_epay.notification.update_template.post') }}" + '/' + template_id;
            if (UPDATE_TEMPLATE_FORM.valid()) {
                let formData = $(UPDATE_TEMPLATE_FORM).serializeArray();
                $.ajax({
                    url: url,
                    type: 'POST',
                    headers: {
                        'Accept': 'application/json'
                    },
                    dataType: 'json',
                    data: formData
                }).done(function(response) {
                    $(SUCCESS_UPDATE_TEMPLATE_MODAL).modal('show');
                    $(".editable").attr("disabled", true).parent().find('button').addClass("disabled");
                    $(EDIT_TEMPLATE_BTN).removeClass('d-none');
                    $(CONFIRM_UPDATE_TEMPLATE_BTN).addClass('d-none');
                    $(CANCEL_UPDATE_TEMPLATE_BTN).addClass('d-none');
                    $(GO_BACK_BTN).removeClass('d-none');
                }).fail(function(err) {
                    toastr.options.timeOut = 10000;
                    toastr.error(UPDATE_FAILED_MSG);
                }).always(function(xhr) {
                    $(CONFIRM_UPDATE_TEMPLATE_MODAL).modal('hide');
                });
            }
        }

        function cancelUpdateTemplate() {
            window.location.reload()
        }

        $(document).ready(function() {
            QUILL.on('text-change', function() {
                $("#quillHtml").val(QUILL.root.innerHTML.trim());
            });

            // 確認ボタン押すと編集進む
            $('#submit-form').on('click', function() {
                if ($(UPDATE_TEMPLATE_FORM).valid()) {
                    updateTemplate();
                }
            });

            $('#cancel').on('click', function() {
                if ($(UPDATE_TEMPLATE_FORM).valid()) {
                    window.location.reload()
                }
            });

            $('#return-btn').on('click', function() {
                if ($(UPDATE_TEMPLATE_FORM).valid()) {
                    window.location.reload()
                }
            });

            {{-- Validate form --}}
            $.validator.setDefaults({
                ignore: []
            });
            UPDATE_TEMPLATE_FORM.validate({
                rules: {
                    title: {
                        required: true,
                    },
                    content: {
                        required: true
                    },
                },
                messages: {
                    title: {
                        required: "{{ __('admin_epay.notifications.validation.title.required') }}",
                    },
                    content: {
                        required: "{{ __('admin_epay.notifications.validation.content.required') }}",
                    },
                },
                errorElement: 'p',
                errorPlacement: function(error, element) {
                    const name = $(element).attr('name');
                    console.log(name);
                    if (name === 'content') {
                        $(element).parent().addClass('border-error');
                        $(element).parent().parent().find('.note-pass').append(error);
                    } else {
                        error.addClass('note-pass-error');
                        element.closest('.form-item-error').find('.note-pass').append(error);
                    }
                },
                highlight: function(element) {
                    const name = $(element).attr('name');
                    if (name === 'content')
                        $(element).parent().addClass('border-error');
                    else
                        $(element).addClass('border-error');
                },
                unhighlight: function(element) {
                    $(element).removeClass('border-error');
                    $(element).parent().removeClass('border-error');
                },
            });

            QUILL.on('text-change', function() {
                let value = QUILL.root.innerHTML.trim();
                if (value === '<p><br></p>')
                    value = null;

                $("#quillHtml").val(value);
            });
        });
    </script>
@endpush
