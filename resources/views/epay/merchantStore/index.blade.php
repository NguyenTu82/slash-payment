@extends('epay.layouts.base')
@section('title', __('common.merchant_stores.list.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/admin_epay/EP05.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="account account-list bg-white">
                <div class="list_search d-flex">
                    <form class="form-search" id="search" method="GET" role="form" action="{{secure_url(url()->current())}}">
                        <div class="form-input">
                            <div class="search_info search_info__input d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.info.id') }}</p>
                                <input type="text" class="form-control input_infor input_w200 border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" name="id"
                                    value="{{ $request->id }}" />
                            </div>
                            <div class="search_info search_info__input d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.info.name') }}</p>
                                <input type="text" class="form-control input_infor input_w200 border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" name="name"
                                    value="{{ $request->name }}" />
                            </div>
                            <div class="search_info search_info__input d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.info.group') }}</p>
                                <input type="text" class="form-control input_infor input_infor2 border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" name="group"
                                    value="{{ $request->group }}" />
                            </div>
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.info.status') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="status">
                                        @php
                                            use App\Enums\MerchantStoreStatus;
                                        @endphp
                                        <option value="">{{ __('common.status.stores.default') }}</option>
                                        <option value="{{ MerchantStoreStatus::TEMPORARILY_REGISTERED->value }}"
                                            @if ($request->status == MerchantStoreStatus::TEMPORARILY_REGISTERED->value) selected @endif>
                                            {{ __('common.status.stores.temporarily_registered') }}
                                        </option>
                                        <option value="{{ MerchantStoreStatus::UNDER_REVIEW->value }}"
                                            @if ($request->status == MerchantStoreStatus::UNDER_REVIEW->value) selected @endif>
                                            {{ __('common.status.stores.under_review') }}
                                        </option>
                                        <option value="{{ MerchantStoreStatus::IN_USE->value }}"
                                            @if ($request->status == MerchantStoreStatus::IN_USE->value) selected @endif>
                                            {{ __('common.status.stores.in_use') }}
                                        </option>
                                        <option value="{{ MerchantStoreStatus::SUSPEND->value }}"
                                            @if ($request->status == MerchantStoreStatus::SUSPEND->value) selected @endif>
                                            {{ __('common.status.stores.stopped') }}
                                        </option>
                                        <option value="{{ MerchantStoreStatus::WITHDRAWAL->value }}"
                                            @if ($request->status == MerchantStoreStatus::WITHDRAWAL->value) selected @endif>
                                            {{ __('common.status.stores.withdrawal') }}
                                        </option>
                                        <option value="{{ MerchantStoreStatus::FORCED_WITHDRAWAL->value }}"
                                            @if ($request->status == MerchantStoreStatus::FORCED_WITHDRAWAL->value) selected @endif>
                                            {{ __('common.status.stores.forced_withdrawal') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.payment_info.payment_currency') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="withdraw_method">
                                        @php
                                            use App\Enums\MerchantPaymentType;
                                        @endphp
                                        <option value="">{{ __('common.label.all') }}</option>
                                        <option value="{{ MerchantPaymentType::FIAT->value }}"
                                            @if ($request->withdraw_method == MerchantPaymentType::FIAT->value) selected @endif>
                                            {{ __('common.merchant_stores.payment_currency.fiat') }}
                                        </option>
                                        <option value="{{ MerchantPaymentType::CRYPTO->value }}"
                                            @if ($request->withdraw_method == MerchantPaymentType::CRYPTO->value) selected @endif>
                                            {{ __('common.merchant_stores.payment_currency.crypto') }}
                                        </option>
                                        <option value="{{ MerchantPaymentType::CASH->value }}"
                                            @if ($request->withdraw_method == MerchantPaymentType::CASH->value) selected @endif>
                                            {{ __('common.merchant_stores.payment_currency.cash') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="search_info d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.payment_info.payment_cycle') }}</p>
                                <div class="select_search">
                                    <select class="select_list select_option" name="payment_cycle">
                                        @php
                                            use App\Enums\MerchantStorePaymentCycle;
                                        @endphp
                                        <option value="">
                                            {{ __('common.label.all') }}
                                        </option>
                                        <option value="{{ MerchantStorePaymentCycle::THREE_DAYS_END->value }}"
                                            @if (isset($request->payment_cycle) and $request->payment_cycle == MerchantStorePaymentCycle::THREE_DAYS_END->value) selected @endif>
                                            {{ __('admin_epay.merchant.payment_cycle.end_3_days') }}
                                        </option>
                                        <option value="{{ MerchantStorePaymentCycle::WEEKEND->value }}"
                                            @if ($request->payment_cycle == MerchantStorePaymentCycle::WEEKEND->value) selected @endif>
                                            {{ __('common.merchant_stores.payment_cycle.weekend_payment') }}
                                        </option>
                                        <option value="{{ MerchantStorePaymentCycle::MONTH_END->value }}"
                                            @if ($request->payment_cycle == MerchantStorePaymentCycle::MONTH_END->value) selected @endif>
                                            {{ __('common.merchant_stores.payment_cycle.month_end_payment') }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-select-action">
                            <div class="search_info search_info__input d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.info.register_email') }}</p>
                                <input type="text" class="form-control input_infor input_infor2 border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" name="email"
                                    value="{{ $request->email }}" />
                            </div>
                            <div class="search_info search_info__input d-flex flex-column">
                                <p>{{ __('admin_epay.merchant.affiliate_info.id') }}</p>
                                <input type="text" class="form-control input_infor input_infor2 border-1 small"
                                    aria-label="Search" aria-describedby="basic-addon2" name="af_id"
                                    value="{{ $request->af_id }}" />
                            </div>
                            <div class="d-none">
                                <input type="hidden" name="sort_name" value=''>
                                <input type="hidden" name="sort_type" value=''>
                            </div>
                            <div class="d-flex flex button__click">
                                <div class="action__button d-flex flex">
                                    <button type="submit" class="btn btn_ok">
                                        {{ __('common.button.search') }}
                                    </button>
                                    <button type="button" class="btn btn_cancel reset">
                                        {{ __('common.button.reset') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="account bg-white mt-15 mb-15">
                <div class="title-table-and-action">
                    <p class="title_table">{{ __('admin_epay.merchant.common.merchant_list') }}</p>
                    <div class="action-table">
                        <a class="href rule rule_epay_merchant_create"
                            href="{{ route('admin_epay.merchantStore.create') }}">
                            <button class="btn btn-primary btn-add">{{ __('common.button.create_store') }}</button>
                        </a>
                        <a class="href"
                            href="{{ route('admin_epay.merchantStore.index.get', ['csv' => 1] + request()->all()) }}">
                            <button class="btn btn-primary btn-csv">{{ __('common.button.csv') }}</button>
                        </a>
                    </div>
                </div>
                <div class="account-table">
                    <div class="table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="center-table column-name" data-name="merchant_code">
                                            {{ __('admin_epay.merchant.info.id') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="email">
                                            {{ __('admin_epay.merchant.info.register_email') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="name">
                                            {{ __('admin_epay.merchant.info.name') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table" data-name="groups">
                                            {{ __('admin_epay.merchant.info.group') }}
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="status">
                                            {{ __('admin_epay.merchant.info.status') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="contract_interest_rate">
                                            {{ __('admin_epay.merchant.payment_info.contract_interest_rate') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none" alt="..."
                                                data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="account_balance">
                                            {{ __('admin_epay.merchant.common.account_balance') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="paid_balance">
                                            {{ __('admin_epay.merchant.common.paid_balance') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="withdraw_method">
                                            {{ __('admin_epay.merchant.payment_info.payment_currency') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="payment_cycle">
                                            {{ __('admin_epay.merchant.payment_info.payment_cycle') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table column-name" data-name="affiliate_id">
                                            {{ __('admin_epay.merchant.affiliate_info.id') }}
                                            <img src="/dashboard/img/desc.svg" class="desc opacity-30" alt="..."
                                                data-type="desc">
                                            <img src="/dashboard/img/asc.svg" class="asc d-none opacity-30"
                                                alt="..." data-type="asc">
                                        </div>
                                    </th>
                                    <th>
                                        <div class="center-table">{{ __('common.button.detail') }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($stores->count() > 0)
                                    @foreach ($stores as $store)
                                        <tr>
                                            <td>
                                                <div class="center-table">
                                                    <a class="rule rule_epay_merchant_detail"
                                                        href="{{ route('admin_epay.merchantStore.detail', $store->id) }}">
                                                        {{ formatAccountId($store->merchant_code) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table">
                                                    {{ $store->merchantOwner ? $store->merchantOwner->email : '' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table">
                                                    {{ $store->name }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table">
                                                    <p class="text-title"
                                                        title="{{ implode(', ', $store->groups->pluck('name')->toArray()) }}">
                                                        @if (count($store->groups) > 0)
                                                            {{ implode(', ', $store->groups->pluck('name')->toArray()) }}
                                                        @endif
                                                    </p>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($store->status)
                                                    @case(\App\Enums\MerchantStoreStatus::TEMPORARILY_REGISTERED->value)
                                                        <div class="center-table">
                                                            {{ __('common.status.stores.temporarily_registered') }}</div>
                                                    @break

                                                    @case(\App\Enums\MerchantStoreStatus::UNDER_REVIEW->value)
                                                        <div class="center-table">
                                                            {{ __('common.status.stores.under_review') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStoreStatus::IN_USE->value)
                                                        <div class="center-table">{{ __('common.status.stores.in_use') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStoreStatus::SUSPEND->value)
                                                        <div class="center-table">{{ __('common.status.stores.stopped') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStoreStatus::WITHDRAWAL->value)
                                                        <div class="center-table">{{ __('common.status.stores.withdrawal') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStoreStatus::FORCED_WITHDRAWAL->value)
                                                        <div class="center-table">
                                                            {{ __('common.status.stores.forced_withdrawal') }}</div>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    {{ $store->contract_interest_rate ? $store->contract_interest_rate . '%' : '-' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                        ￥
                                                        {{ formatNumberDecimal($store->total_adjusted_amount, 3) }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                        ￥
                                                        {{ formatNumberDecimal($store->payment_successes_sum_payment_amount, 3) }}
                                                </div>
                                            </td>
                                            <td>
                                                @switch($store->withdraw_method)
                                                    @case(\App\Enums\MerchantPaymentType::FIAT->value)
                                                        <div class="center-table">
                                                            {{ __('common.merchant_stores.payment_currency.fiat') }}</div>
                                                    @break

                                                    @case(\App\Enums\MerchantPaymentType::CRYPTO->value)
                                                        <div class="center-table">
                                                            {{ __('common.merchant_stores.payment_currency.crypto') }}</div>
                                                    @break

                                                    @case(\App\Enums\MerchantPaymentType::CASH->value)
                                                        <div class="center-table">
                                                            {{ __('common.merchant_stores.payment_currency.cash') }}</div>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                @switch($store->payment_cycle)
                                                    @case(\App\Enums\MerchantStorePaymentCycle::THREE_DAYS_END->value)
                                                        <div class="center-table">
                                                            {{ __('admin_epay.merchant.payment_cycle.end_3_days') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStorePaymentCycle::WEEKEND->value)
                                                        <div class="center-table">
                                                            {{ __('common.merchant_stores.payment_cycle.weekend_payment') }}
                                                        </div>
                                                    @break

                                                    @case(\App\Enums\MerchantStorePaymentCycle::MONTH_END->value)
                                                        <div class="center-table">
                                                            {{ __('common.merchant_stores.payment_cycle.month_end_payment') }}
                                                        </div>
                                                    @break
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="center-table text-number-font text-right-number">
                                                    {{ $store->affiliate_id }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="center-table">
                                                    <a class="rule rule_epay_merchant_detail"
                                                        href="{{ route('admin_epay.merchantStore.detail', $store->id) }}">{{ __('common.button.detail') }}</a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="14">
                                            <div class="center-table">{{ __('common.messages.no_data') }}</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    @include('common.pagination', ['paginator' => $stores])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        @if (isset($request->sort_name))
            var itemSort = $('[data-name="{{ $request->sort_name }}"]');
            itemSort.find("img").removeClass("opacity-30");
            @if ($request->sort_type === 'asc')
                itemSort.find("img").filter(".asc").removeClass("d-none")
                itemSort.find("img").filter(".desc").addClass("d-none");
            @elseif ($request->sort_type === 'desc')
                itemSort.find("img").filter(".desc").removeClass("d-none")
                itemSort.find("img").filter(".asc").addClass("d-none");
            @endif
        @endif

        $('.reset').on('click', function() {
            $('input[name="id"]').val('');
            $('input[name="name"]').val('');
            $('input[name="email"]').val('');
            $('select[name="status"]').val('');
            $('select[name="withdraw_method"]').val('');
            $('select[name="payment_cycle"]').val('');
            $('input[name="group"]').val('');
            $('input[name="af_id"]').val('');
            $('#search').submit();
        });
        $(".column-name").click(function() {
            var sortName = $(this).data("name");
            var disableItem = $(this).find("img").filter(".d-none")
            var sortType = disableItem.data("type");
            $(this).find("img:not(.d-none)").addClass("d-none");
            disableItem.removeClass("d-none");
            $('input[name="sort_name"]').val(sortName);
            $('input[name="sort_type"]').val(sortType);
            $('#search').submit();
        });
    </script>
@endpush
