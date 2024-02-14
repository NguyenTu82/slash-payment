@extends('merchant.layouts.base')
@section('title', __('merchant.notification.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/list_noti_management.css') }}">
@endpush

@section('content')
<div class="row">
    <div class="col-12">
        <div class="account account-list bg-white">
            <div class="list_search d-flex">
            <form class="form-search" id="search" method="GET" role="form" action="{{secure_url(url()->current())}}">
                    <div class="form-input">
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('merchant.notification.noti.merchant') }}</p>
                            <div class="select_search">
                                <select class="select_list select_member_store select_option" name="merchant_store_id">
                                    <option value="">{{ __('merchant.notification.noti.select_all') }}</option>
                                    @foreach ($merchants as $merchant)
                                    <option
                                        value="{{$merchant->id}}"
                                        @if ($request->merchant_store_id == $merchant->id) selected @endif
                                        >{{$merchant->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div
                            class="search_info d-flex flex-column"
                        >
                        <p>{{ __('merchant.notification.noti.noti_type') }}</p>
                            <div class="select_search">
                                <select class="select_list select_option" name="type">
                                @php
                                use App\Enums\MerchantNotiType;
                            @endphp
                            <option value="">{{ __('merchant.notification.noti.select_all') }}</option>
                            <option value="{{ MerchantNotiType::WITHDRAW->value }}"
                                @if ($request->type == MerchantNotiType::WITHDRAW->value) selected @endif>{{ __('merchant.notification.noti.type_withdraw') }}
                            </option>
                            <option value="{{ MerchantNotiType::OTHER->value }}"
                                @if ($request->type == MerchantNotiType::OTHER->value) selected @endif>{{ __('merchant.notification.noti.type_other_noti') }}
                            </option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="search_info d-flex flex-column"
                        >
                        <p>{{ __('merchant.notification.noti.status') }}</p>
                            <div class="select_search">
                                <select
                                    class="select_list select_option" name="status"
                                >
                                @php
                                use App\Enums\MerchantNotiStatus;
                            @endphp
                            <option value="">{{ __('merchant.notification.noti.select_all') }}</option>
                            <option value="{{ MerchantNotiStatus::ALREADY_READ->value }}"
                                @if ($request->status == MerchantNotiStatus::ALREADY_READ->value) selected @endif>{{ __('merchant.notification.noti.read') }}
                            </option>
                            <option value="{{ MerchantNotiStatus::UNREAD->value }}"
                                @if ($request->status == MerchantNotiStatus::UNREAD->value) selected @endif>{{ __('merchant.notification.noti.unread') }}
                            </option>
                                </select>
                            </div>
                        </div>
                        <div
                            class="search_info search_info__input d-flex flex-column"
                        >
                        <p>{{ __('merchant.notification.noti.title') }}</p>
                            <input
                                type="text"
                                class="form-control input_infor input_infor1 border-1 small"
                                aria-label="Search"
                                aria-describedby="basic-addon2"name="title"
                                value="{{$request->title}}"
                            />
                        </div>
                        <div
                        class="search_info search_info__input d-flex flex-column"
                        >
                        <p>{{ __('merchant.notification.noti.content') }}</p>
                            <input
                                type="text"
                                class="form-control input_infor input_infor2 border-1 small"
                                aria-label="Search"
                                aria-describedby="basic-addon2"
                                name="content"
                                   value="{{$request->content}}"
                            />
                        </div>
                    </div>
                    <div class="form-select-action">
                        <div class="date-form-to">
                            <div class="search_info d-flex flex-column">
                            <p>{{ __('merchant.notification.noti.send_day') }}</p>
                                <div class="input_date">
                                    <input id="send_date_from" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="send_date_from"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->send_date_from }}" />
                                    <label for="send_date_from">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                            <span class="seperate">~</span>
                            <div class="search_info d-flex flex-column">
                                <div class="input_date">
                                    <input id="send_date_to" type="text"
                                        placeholder="{{ getPlaceholderOfDate() }}" lang="ja" name="send_date_to"
                                        class="form-control input_time input_time-search"
                                        value="{{ $request->send_date_to }}" />
                                    <label for="send_date_to">
                                        <img class="img-date-search mx-auto icon"
                                            src="../../../../../dashboard/img/date.svg" alt="">
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex button__click">
                            <div
                                class="action__button d-flex flex"
                            >
                                <button
                                    type="submit"
                                    class="btn btn_ok"
                                >
                                {{ __('merchant.notification.noti.search') }}
                                </button>
                                <button
                                    type="button"
                                    class="btn btn_cancel reset"
                                >
                                    {{ __('merchant.notification.noti.reset') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="account bg-white mt-20 mb-15">
            <p class="title_table">{{ __('merchant.notification.title_page') }}</p>
            <div class="table-data">
                <div class="table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th><div class="center-table">{{ __('merchant.notification.noti.merchant') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.noti_type') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.title') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.content') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.send_date') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.status') }}</div></th>
                                <th><div class="center-table">{{ __('merchant.notification.noti.detail') }}</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($notifications->count() > 0)
                                @foreach ($notifications as $noti)
                            <tr>
                                <td><div class="center-table text-number-font">{{ $noti->merchantStore->name }}</div></td>

                                @if ($noti->type == \App\Enums\MerchantNotiType::WITHDRAW->value)
                                    <td><div class="center-table text-number-font">{{ __('merchant.notification.noti.type_withdraw') }}</div></td>
                                @else
                                    <td><div class="center-table text-number-font">{{ __('merchant.notification.noti.type_other_noti') }}</div></td>
                                @endif
                                <td><div class="center-table text-over"> <p class="text-title text-number-font">{{ $noti->title }}</p></div></td>
                                <td><div class="center-table text-over">{!! subString($noti->content, 50) !!}</div></td>
                                <td><div class="center-table text-number-font">{{ $noti->send_date }}</div></td>
                                @if ($noti->status == \App\Enums\MerchantNotiStatus::ALREADY_READ->value)
                                <td class="status_item">
                                    <div class="center-table">
                                        <div class="status invalid read">{{ __('merchant.notification.noti.read') }}</div>
                                    </div>
                                </td>
                                @else
                                <td class="status_item">
                                    <div class="center-table">
                                        <div class="status unread">{{ __('merchant.notification.noti.unread') }}</div>
                                    </div>
                                </td>
                                @endif
                                <td>
                                    <div class="center-table">
                                        <a class="rule rule_merchant_notification_detail"  href="{{ route('merchant.notification.detail.get', ['id'=>$noti->id]) }}">{{ __('admin_epay.setting.account_management.list.detail') }}</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @else
                            <tr>
                                <td colspan="7"><div class="center-table">{{__('common.messages.no_data')}}</div></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
            @include('common.pagination', ['paginator' => $notifications])
        </div>
    </div>
</div>
@endsection

@push('script')
    <script type="text/javascript">
        $('input[name=send_date_from]').datepicker(COMMON_DATEPICKER);
        $('input[name=send_date_to]').datepicker(COMMON_DATEPICKER);

        $('.reset').on('click', function () {
            $('select[name="merchant_store_id"]').val('');
            $('select[name="type"]').val('');
            $('select[name="status"]').val('');
            $('input[name="title"]').val('');
            $('input[name="content"]').val('');
            $('input[name="send_date_from"]').val('');
            $('input[name="send_date_to"]').val('');
            $('#search').submit();
        });

    </script>
@endpush
