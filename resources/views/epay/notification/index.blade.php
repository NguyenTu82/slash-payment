@extends('epay.layouts.base')
@section('title', __('common.screens.notification_list'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/list_notification.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <style>
        .container-fluid.bg-white{
            background-color: #F1F1F1 !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="account account-list bg-white">
                @include('epay.notification.navbar')
            </div>
            <div class="account account-list bg-white">
                <div class="list_search d-flex">
                    <form class="form-search" id="search" method="GET" role="form" action="{{secure_url(url()->current())}}">
                        <input name="per_page" type="hidden" value="{{ $request->per_page }}">
                        <div class="form-input">
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('admin_epay.notifications.type') }}</p>
                                <div class="select_search">
                                    <select id="select_type" onChange="onChangeType()" name="select_type"
                                        class="select_list select_option">
                                        @php
                                            use App\Enums\NotiSelectedType;
                                        @endphp
                                        <option value="">{{ __('admin_epay.notifications.all') }}</option>
                                        <option value="{{ NotiSelectedType::RECEIVE->value }}"
                                            @if ($request->select_type == NotiSelectedType::RECEIVE->value) selected @endif>
                                            {{ __('admin_epay.notifications.receive_noti') }}</option>
                                        <option value="{{ NotiSelectedType::SEND->value }}"
                                            @if ($request->select_type == NotiSelectedType::SEND->value) selected @endif>
                                            {{ __('admin_epay.notifications.send_noti') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- TYPE RECEIVE --}}
                            <div class="search_info flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::SEND->value) d-none @endif"
                                id="type_receive">
                                <p>{{ __('admin_epay.notifications.noti_type') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="type_receive">
                                        @php
                                            use App\Enums\NotiTypeReceive;
                                        @endphp
                                        <option value="">{{ __('admin_epay.notifications.all') }}</option>
                                        <option value="{{ NotiTypeReceive::NEW_REGISTER->value }}"
                                            @if ($request->type_receive == NotiTypeReceive::NEW_REGISTER->value) selected @endif>
                                            {{ __('admin_epay.notifications.type_receive.new') }}</option>
                                        <option value="{{ NotiTypeReceive::WITHDRAWAL->value }}"
                                            @if ($request->type_receive == NotiTypeReceive::WITHDRAWAL->value) selected @endif>
                                            {{ __('admin_epay.notifications.type_receive.withdraw') }}</option>
                                        <option value="{{ NotiTypeReceive::CANCEL->value }}"
                                            @if ($request->type_receive == NotiTypeReceive::CANCEL->value) selected @endif>
                                            {{ __('admin_epay.notifications.type_receive.cancel') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- TYPE SEND --}}
                            <div class="search_info flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value || $request->select_type == null) d-none @endif"
                                id="type_send">
                                <p>{{ __('admin_epay.notifications.noti_type') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="type_send">
                                        @php
                                            use App\Enums\NotiTypeSend;
                                        @endphp
                                        <option value="">{{ __('admin_epay.notifications.all') }}</option>
                                        <option value="{{ NotiTypeSend::ALL->value }}"
                                            @if ($request->type_send == NotiTypeSend::ALL->value) selected @endif>
                                            {{ __('admin_epay.notifications.type_send.all') }}</option>
                                        <option value="{{ NotiTypeSend::PART->value }}"
                                            @if ($request->type_send == NotiTypeSend::PART->value) selected @endif>
                                            {{ __('admin_epay.notifications.type_send.part') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- STATUS RECEIVE --}}
                            <div id="status_receive"
                                class="search_info flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::SEND->value) d-none @endif">
                                <p>{{ __('admin_epay.notifications.status') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="status_receive">
                                        @php
                                            use App\Enums\NotiStatusReceive;
                                        @endphp
                                        <option value="">{{ __('admin_epay.notifications.all') }}</option>
                                        <option value="{{ NotiStatusReceive::ALREADY_READ->value }}"
                                            @if ($request->status_receive == NotiStatusReceive::ALREADY_READ->value) selected @endif>
                                            {{ __('admin_epay.notifications.status_receive.read') }}</option>
                                        <option value="{{ NotiStatusReceive::UNREAD->value }}"
                                            @if ($request->status_receive == NotiStatusReceive::UNREAD->value) selected @endif>
                                            {{ __('admin_epay.notifications.status_receive.unread') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- STATUS SEND --}}
                            <div id="status_send"
                                class="search_info flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value || $request->select_type == null) d-none @endif">
                                <p>{{ __('admin_epay.notifications.status') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="status_send">
                                        @php
                                            use App\Enums\NotiStatusSend;
                                        @endphp
                                        <option value="">{{ __('admin_epay.notifications.all') }}</option>
                                        <option value="{{ NotiStatusSend::SEND->value }}"
                                            @if ($request->status_send == NotiStatusSend::SEND->value) selected @endif>
                                            {{ __('admin_epay.notifications.status_send.send') }}</option>
                                        <option value="{{ NotiStatusSend::UNSEND->value }}"
                                            @if ($request->status_send == NotiStatusSend::UNSEND->value) selected @endif>
                                            {{ __('admin_epay.notifications.status_send.not_send') }}</option>
                                    </select>
                                </div>
                            </div>

                            {{-- MERCHANT ID --}}
                            <div id="input_merchant_id"
                                class="search_info search_info__input flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::SEND->value) d-none @endif">
                                <p>{{ __('admin_epay.notifications.merchant_id') }}</p>
                                <input name="merchant_id" type="text"
                                    class="form-control input_infor input_infor1 border-1 small" aria-label="Search"
                                    aria-describedby="basic-addon2" value="{{ $request->merchant_id }}" />
                            </div>

                            {{-- MERCHANT NAME --}}
                            <div id="input_merchant_name"
                                class="search_info search_info__input flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::SEND->value) d-none @endif">
                                <p>{{ __('admin_epay.notifications.merchant_name') }}</p>
                                <input name="merchant_name" type="text"
                                    class="form-control input_infor input_infor2 border-1 small" aria-label="Search"
                                    aria-describedby="basic-addon2" value="{{ $request->merchant_name }}" />
                            </div>

                            {{-- title --}}
                            <div id="input_title"
                                class="search_info search_info__input input_infor2 flex-column @if ($request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value || $request->select_type == null) d-none @endif">
                                <p>{{ __('admin_epay.notifications.title') }}</p>
                                <input name="title" type="text" class="form-control input_infor border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" value="{{ $request->title }}" />
                            </div>
                        </div>

                        <div class="form-select-action">
                            <div class="date-form-to">
                                <div class="search_info d-flex flex-column">
                                    <p>{{ $request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value ? __('admin_epay.notifications.receive_date') : __('admin_epay.notifications.send_date_time') }}</p>
                                    <div class="input_date">
                                        <input type="text" placeholder="{{getPlaceholderOfDate()}}" name="send_date_from"
                                            class="form-control input_time border-1 small"
                                            value="{{ $request->send_date_from }}" id="sendDateFrom"/>
                                        <label for="sendDateFrom">
                                            <img src="{{ asset('dashboard/img/date.svg') }}" class=" mx-auto icon" alt="">
                                        </label>
                                    </div>
                                </div>
                                <span class="seperate">~</span>
                                <div class="search_info d-flex flex-column">
                                    <div class="input_date">
                                        <input type="text" placeholder="{{getPlaceholderOfDate()}}" name="send_date_to"
                                               class="form-control input_time border-1 small"
                                               value="{{ $request->send_date_to }}" id="sendDateTo"/>
                                        <label for="sendDateTo">
                                            <img src="{{ asset('dashboard/img/date.svg') }}" class=" mx-auto icon" alt="">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex flex button__click">
                                <div class="action__button d-flex flex">
                                    <button type="submit" class="btn btn_ok">
                                        {{ __('admin_epay.notifications.search') }}
                                    </button>
                                    <button type="button" onclick="resetValue(0)" class="btn btn_cancel">
                                        {{ __('admin_epay.notifications.reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form class="form-search form-button-search rule rule_epay_notification_create" role="form"
                        action="{{route('admin_epay.notification.createNotification.get')}}">
                        <div class="d-flex btn-action-search">
                            <div class="action_search">
                                <button type="submit" class="btn btn_ok">
                                    {{ __('admin_epay.notifications.create_noti') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if ($request->select_type == \App\Enums\NotiSelectedType::RECEIVE->value || $request->select_type == null)
                {{-- TABLE RECEIVE --}}
                <div id="table_receive" class="account bg-white mt-20 mb-15">
                    <p class="title_table">{{ __('admin_epay.notifications.list_receive') }}</p>
                    <div class="table-data">
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.type') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.noti_type') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.merchant_id') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.merchant_name') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.receive_date_time') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.status') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.detail') }}</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($dataList->count() > 0)
                                    @foreach ($dataList as $data)
                                        <tr>
                                            <td>
                                                <div class="center-table">{{ __('admin_epay.notifications.receive_noti') }}</div>
                                            </td>
                                            <td>
                                                <div class="center-table">
                                                    @switch($data->type)
                                                        @case(\App\Enums\NotiTypeReceive::NEW_REGISTER->value)
                                                            {{ __('admin_epay.notifications.type_receive.new') }}
                                                            @break
                                                        @case(\App\Enums\NotiTypeReceive::WITHDRAWAL->value)
                                                            {{ __('admin_epay.notifications.type_receive.withdraw') }}
                                                            @break
                                                        @case(\App\Enums\NotiTypeReceive::CANCEL->value)
                                                            {{ __('admin_epay.notifications.type_receive.cancel') }}
                                                        @break
                                                    @endswitch
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table">{{ formatAccountId($data->merchant_code) }}</div>
                                            </td>
                                            <td>
                                                <div class="center-table">{{ $data->name }}</div>
                                            </td>
                                            <td>
                                                <div class="center-table">{{ convertTimeJapan($data->send_date) }}</div>
                                            </td>
                                            @if ($data->status == \App\Enums\NotiStatusReceive::ALREADY_READ->value)
                                                <td class="status_item">
                                                    <div class="center-table">
                                                        <div class="status invalid">
                                                            {{ __('admin_epay.notifications.status_receive.read') }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="status_item">
                                                    <div class="center-table">
                                                        <div class="status unread">
                                                            {{ __('admin_epay.notifications.status_receive.unread') }}</div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="center-table">
                                                    <a class="rule rule_epay_notification_detail" href="{{ route('admin_epay.notification.detail.get', ['id' => $data->id]) }}">{{ __('admin_epay.notifications.detail') }}</a>
                                                </div>
                                            </td>
                                    @endforeach
                                @else
                                    <td colspan="7"><div class="center-table">{{__('common.messages.no_data')}}</div></td>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('common.pagination', ['paginator' => $dataList])
                </div>
            @else
                {{-- TABLE SEND --}}
                <div id="table_send" class="account bg-white mt-20 mb-15">
                    <p class="title_table">{{ __('admin_epay.notifications.list_send') }}</p>
                    <div class="table-data">
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.type') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.noti_type') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.title') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.schedule_send') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.send_date') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.status') }}</div>
                                        </th>
                                        <th>
                                            <div class="center-table">{{ __('admin_epay.notifications.detail') }}</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                @if($dataList->count() > 0)
                                    @foreach ($dataList as $data)
                                        <tr>
                                            <td>
                                                <div class="center-table">{{ __('admin_epay.notifications.send_noti') }}</div>
                                            </td>
                                            @if ($data->type == \App\Enums\NotiTypeSend::ALL->value)
                                                <td>
                                                    <div class="center-table">
                                                        {{ __('admin_epay.notifications.type_send.all') }}</div>
                                                </td>
                                            @else
                                                <td>
                                                    <div class="center-table">
                                                        {{ __('admin_epay.notifications.type_send.part') }}</div>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="center-table">{{ $data->title }}</div>
                                            </td>
                                            <td>
                                                <div class="center-table">{{ convertTimeJapan($data->schedule_send_date) }}</div>
                                            </td>
                                            <td>
                                                <div class="center-table">{{ convertTimeJapan($data->actual_send_date) }}</div>
                                            </td>
                                            @if ($data->status == \App\Enums\NotiStatusSend::SEND->value)
                                                <td class="status_item">
                                                    <div class="center-table">
                                                        <div class="status invalid">
                                                            {{ __('admin_epay.notifications.status_send.send') }}
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="status_item">
                                                    <div class="center-table">
                                                        <div class="status valid">
                                                            {{ __('admin_epay.notifications.status_send.not_send') }}</div>
                                                    </div>
                                                </td>
                                            @endif
                                            <td>
                                                <div class="center-table">
                                                    <a class="rule rule_epay_notification_detail" href="{{ route('admin_epay.notification.send_detail.get', ['id' => $data->id]) }}">{{ __('admin_epay.notifications.detail') }}</a>
                                                </div>
                                            </td>
                                    @endforeach
                                @else
                                    <td colspan="7"><div class="center-table">{{__('common.messages.no_data')}}</div></td>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @include('common.pagination', ['paginator' => $dataList])
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $('input[name=send_date_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=send_date_to]').datepicker(COMMON_DATEPICKER);

        const INPUT_MERCHANT_ID = $("#input_merchant_id");
        const INPUT_MERCHANT_NAME = $("#input_merchant_name");
        const INPUT_TITLE = $("#input_title");
        const TABLE_RECEIVE = $("#table_receive");
        const TABLE_SEND = $("#table_send");
        const STATUS_SEND = $("#status_send");
        const STATUS_RECEIVE = $("#status_receive");
        const TYPE_SEND = $("#type_send");
        const TYPE_RECEIVE = $("#type_receive");

        function resetValue(elm) {
            $('select[name="select_type"]').val(elm)
            $('select[name="type_receive"]').val('');
            $('select[name="type_send"]').val('');
            $('select[name="status_receive"]').val('');
            $('select[name="status_send"]').val('');
            $('input[name="merchant_id"]').val('');
            $('input[name="merchant_name"]').val('');
            $('input[name="title"]').val('');
            $('input[name="send_date_from"]').val('');
            $('input[name="send_date_to"]').val('');
            $('#search').submit();
        }

        function onChangeType() {
            const selected = document.getElementById("select_type");
            resetValue(selected.value);
            if (selected.value == 1) {
                $(INPUT_MERCHANT_ID).addClass('d-none');
                $(INPUT_MERCHANT_NAME).addClass('d-none');
                $(INPUT_TITLE).removeClass('d-none');
                $(STATUS_RECEIVE).addClass('d-none');
                $(STATUS_SEND).removeClass('d-none');
                $(TYPE_RECEIVE).addClass('d-none');
                $(TYPE_SEND).removeClass('d-none');
            } else {
                $(INPUT_MERCHANT_ID).removeClass('d-none');
                $(INPUT_MERCHANT_NAME).removeClass('d-none');
                $(INPUT_TITLE).addClass('d-none');
                $(STATUS_RECEIVE).removeClass('d-none');
                $(STATUS_SEND).addClass('d-none');
                $(TYPE_RECEIVE).removeClass('d-none');
                $(TYPE_SEND).addClass('d-none');
            }
        }
    </script>
@endpush
