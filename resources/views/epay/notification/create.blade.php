@extends('epay.layouts.base', ['title' => __('common.setting.profile.profile_info')])
@section('title', __('common.notification.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP_04_04.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="account account-list bg-white">
                @include('epay.notification.navbar')
            </div>

            {{-- tab content  --}}
            <div class="tab-content" id="nav-tabContent">
                <div class="profile-box">
                    <div class="account bg-white">
                        <form class="form-detail form-dropdown-input" action="{{ route('admin_epay.notification.storeSendNotification.post') }}" method="POST" id="createSendNotification">
                        @csrf
                            <h6 class="title-detail-noti">
                                {{ __('admin_epay.notifications.createNew.title') }}
                            </h6>

                            {{-- 通知種類 --}}
                            <div class="form-group row form-item noti-detai-type">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('admin_epay.notifications.createNew.receiver') }}
                                </label>
                                <div class="col col-md-10">
                                    <div class="select_info">
                                        <select class="form_control select_form" id="my-role" name="merchant_all_or_part">
                                        @php
                                            use \App\Enums\NotiTypeSend;
                                        @endphp
                                            <option value="{{NotiTypeSend::ALL->value}}"
                                                @if($request->merchant_all_or_part == NotiTypeSend::ALL->value)
                                                    selected
                                                @endif>
                                                {{ __('admin_epay.notifications.type_send.all') }}
                                            </option>
                                            <option value="{{NotiTypeSend::PART->value}}"
                                                @if($request->merchant_all_or_part == NotiTypeSend::PART->value)
                                                    selected
                                                @endif>
                                                {{ __('admin_epay.notifications.type_send.part') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- グループ --}}
                            <div id="hiddenDiv" style="display:none">
                                <div class="form-group row form-item">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('admin_epay.notifications.createNew.group.title') }}
                                    </label>
                                    <div class="col col-md-10 form-note-textarea border-erro">
                                        <div class="form-control list-area-members">
                                            @if($errors->any())
                                                @foreach(old('merchant_store_ids') as $key => $value)
                                                    <p class="members-item">{{$key}}</p>
                                                    <div class="line-item"></div>
                                                @endforeach
                                            @endif
                                        </div>
                                        <div class="note-pass note-pass-select">
                                            <input type="hidden" name="store_latest" value="{{old('merchant_store_ids')}}">
                                            <div><p class="note-pass-error"></p></div>
                                            <button type="button" class="btn form-select" data-toggle="modal" data-target="#selectMerchant">
                                                {{ __('admin_epay.notifications.createNew.group.selectStore') }}
                                            </button>

                                            <!-- Modal Select Merchant -->
                                            @include('common.modal.select_merchant', [
                                                'stores' => $allMerchantStores,
                                                'selectedStores' => old('merchant_store_ids'),
                                            ])
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- 送信日時指定 --}}
                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('admin_epay.notifications.createNew.time.title') }}
                                </label>
                                <div class="col col-md-10 form-edit-input">
                                    <div class="turnoff-datetime">
                                        <div class="switch-span-content">
                                            <label class="switch">
                                                <input type="checkbox" checked id="toggle" name="is_has_send_time">
                                                <span class="slider round hide-off"></span>
                                            </label>
                                            <span class="specified" id="displayText">
                                                {{ __('admin_epay.notifications.createNew.time.timeSet') }}
                                            </span>
                                        </div>
                                        <input class="date-time input_time" type="datetime-local" id="datetime" name="schedule_send_date">
                                    </div>
                                    <div class="note-pass"></div>
                                </div>
                            </div>

                            {{-- タイトル --}}
                            <div class="form-group row form-item">
                                <label for="" class="col col-md-2 col-form-label label-custom">
                                    {{ __('admin_epay.notifications.createNew.notiTitle') }}
                                </label>
                                <div class="col col-md-10 form-edit-input" >
                                    <input type="text" name="title" class="form-control {{ $errors->has('title') ? 'border-error' : '' }}">
                                    <div class="note-pass"></div>
                                </div>
                            </div>

                            {{-- 通知内容 --}}
                            <div class="form-group row form-item noti-content-detail">
                                <label for="" class="col col-md-2 col-form-label label-custom noti-content-title">
                                    {{ __('admin_epay.notifications.createNew.content') }}
                                </label>
                                <div class="col col-md-10 form-editor-input">
                                    <div class="editor-custom">
                                        <input type="hidden" id="quillHtml" name="content" value="{{ old('content') }}"/>
                                        <div id="editor"></div>
                                    </div>
                                    <div class="note-pass note-error-editor ml-15"></div>
                                </div>
                            </div>

                            {{-- Button --}}
                            <div class="form-group row form-item">
                                <label for="" class="col-sm-2 col-form-label label-custom"></label>
                                <div class="col col-md-10">
                                    <div class="button-action">
                                        <button type="submit" class="btn btn-edit-detail">
                                            {{ __('common.button.send') }}
                                        </button>
                                        <a href="{{ route('admin_epay.notification.index.get') }}">
                                            <button type="button" class="btn form-close">
                                            {{ __('common.button.back') }}
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal confirm -->
                        @include('common.modal.confirm', [
                            'title' => __('admin_epay.notifications.common.title_confirm_create_send_noti'),
                            'description' => __('admin_epay.notifications.common.content_confirm_create_send_noti'),
                            'submit_btn' => __('common.button.send'),
                        ])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('dashboard/libs/quill.min.js') }}"></script>

    {{-- toolbar --}}
    <script type="text/javascript">
        const datetimeInput = document.getElementById('datetime');
        const toggleSwitch = document.getElementById('toggle');
        const displayText = document.getElementById('displayText');

        toggleSwitch.addEventListener('click', function() {
            datetimeInput.disabled = !toggleSwitch.checked;
            displayText.textContent = toggleSwitch.checked ?
            "{{ __('admin_epay.notifications.createNew.time.timeSet') }}" :
            "{{ __('admin_epay.notifications.createNew.time.timeNotSet') }}";
        });
        let currentTime = new Date();
        currentTime.setSeconds(currentTime.getSeconds() + 60);

        let formattedCurrentTime = currentTime.toISOString().slice(0, 16);
        datetimeInput.setAttribute('min', formattedCurrentTime);

        const MERCHANT_STORE = $('.merchant-item');
        const STORE_SELECTED = $('.list-area-members');
        const CREATE_SEND_NOTIFICATION_FORM = $('#createSendNotification');
        const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-modal");
        const MERCHANT_SELECTED =  $('.form-note-textarea');
        const CANCEL_CREATE_ACCOUNT_BTN = $('.form-close');

        $(document).ready(function () {
            {{-- Choose merchant store --}}
            MERCHANT_STORE.on('click', function () {
                STORE_SELECTED.children().remove();
                $('input[name=store_latest]').val('');
                $('.merchant-item:checked').each(function () {
                    let name = $(this).data('name');
                    $('input[name=store_latest]').val(name);
                    STORE_SELECTED.append(`<p class="members-item">${name}</p><div class="line-item"></div>`);
                });

                if ($('input:checked').length > 0) {
                    MERCHANT_SELECTED.find('.border-error').removeClass('border-error');
                    MERCHANT_SELECTED.find('.note-pass-error').html('');
                }
            });

            SUBMIT_BUTTON_COMMON.on('click', function () {
                CREATE_SEND_NOTIFICATION_FORM[0].submit();
            });

            CANCEL_CREATE_ACCOUNT_BTN.on('click', function () {
                window.location.href = `{{ route('merchant.account.index.get') }}`;
            });

            $('#toggle').change(function() {
                if ($(this).is(':checked')) {
                    $('#datetime').removeClass('border-error');
                }
            });

            {{-- hide group --}}
            $('#my-role').on('change', function() {
                const selectedValue = $(this).val();
                const hiddenDiv = $('#hiddenDiv');
                if (selectedValue === '1')
                    hiddenDiv.css('display', 'block');
                else
                    hiddenDiv.css('display', 'none');
            });

            {{-- Validate form --}}
            $.validator.setDefaults({ignore: []});
            $.validator.addMethod("futureTime", function(value, element) {
                return new Date(value) > new Date();
            },);
            CREATE_SEND_NOTIFICATION_FORM.validate({
                rules: {
                    schedule_send_date: {
                        required: function () {
                            return !!$('input[name=is_has_send_time]').is(':checked');
                        },
                        futureTime: true
                    },
                    title: {
                        required: true,
                    },
                    content: {
                        required: true,
                    },
                    store_latest: {
                        required: function () {
                            return $('#my-role').val() !== '0';
                        },
                    },
                },
                messages: {
                    schedule_send_date: {
                        required: "{{ __('admin_epay.notifications.validation.time.required') }}",
                        futureTime: "{{ __('admin_epay.notifications.validation.time.future') }}",
                    },
                    title: {
                        required: "{{ __('admin_epay.notifications.validation.title.required') }}",
                    },
                    content: {
                        required: "{{ __('admin_epay.notifications.validation.content.required') }}",
                    },
                    store_latest: {
                        required: "",
                    },
                },
                errorElement: 'p',
                errorPlacement: function (error, element) {
                    $(element).parent().parent().find('.serve-error').remove();
                    const name = $(element).attr('name');
                    if (name === 'store_latest') {
                        $('.list-area-members').addClass('border-error');
                        $(element).parent().find('.note-pass-error').html('')
                            .append("{{ __('common.account_management.validation.merchant_store_ids.required') }}");
                    } else if (name === 'content') {
                        $(element).parent().addClass('border-error');
                        $(element).parent().parent().find('.note-pass').append(error);
                    } else {
                        error.addClass('note-pass-error');
                        element.closest('.form-edit-input').find('.note-pass').append(error);
                    }
                },
                highlight: function (element) {
                    const name = $(element).attr('name');
                    if (name === 'content')
                        $(element).parent().addClass('border-error');
                    else
                        $(element).addClass('border-error');
                },
                unhighlight: function (element) {
                    $(element).removeClass('border-error');
                    $(element).parent().removeClass('border-error');
                },
                submitHandler: function () {
                    CONFIRM_UPDATE_PROFILE_MODAL.modal('show');
                }
            });

            const quill = new Quill('#editor', {theme: 'snow'});
            quill.on('text-change', function() {
                let value = quill.root.innerHTML.trim();
                if (value === '<p><br></p>')
                    value = null;

                $('#quillHtml').val(value);
            });
        });
    </script>
@endpush
