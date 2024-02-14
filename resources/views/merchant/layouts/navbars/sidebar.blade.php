@php
    $currentRoute = Route::currentRouteName();
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <img class="img-sidebar" src="{{ asset('/dashboard/img/sidebar_logo.svg') }}" alt="" />

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />

    <li class="nav-item rule rule_merchant_dashboard {{ activeMenuSidebar('merchant.dashboard.main') }}">
        <div class="nav-hover">
            <a class="nav-link" href="{{ route('merchant.dashboard.index.get') }}">
                <img src="{{ asset('/dashboard/img/dashboard.svg') }}" alt="" />
                <span>{{ __('common.sidebar.dashboard') }}</span>
            </a>
        </div>
    </li>

    <li
        class="nav-item rule rule_merchant_usage_situation {{ activeMenuSidebar('merchant.usageSituation.index.get') }}">
        <div class="nav-hover">
            <a class="nav-link" href="{{ route('merchant.usageSituation.index.get') }}">
                <img src="{{ asset('/dashboard/img/note.svg') }}" alt="" />
                <span>{{ __('merchant.status.title') }}</span>
            </a>
        </div>
    </li>

    @php
        $checkMenu = in_array($currentRoute, ['merchant.withdraw.history.index.get', 'merchant.withdraw.history.detail.get', 'merchant.withdraw.request.create.get']);
        $checkMenuDetail = in_array($currentRoute, ['merchant.withdraw.history.detail.get', 'merchant.withdraw.history.edit.get']);
    @endphp
    <li class="nav-item rule rule_merchant_withdraw @if ($checkMenu) active @endif">
        <div class="nav-hover">
            <a class="nav-link @if (!$checkMenu) collapsed @endif" href="#" data-toggle="collapse"
                data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <img src="{{ asset('/dashboard/img/payment.svg') }}" alt="" />
                <span>{{ __('common.sidebar.payment') }}</span>
            </a>
        </div>
        <div id="collapsePages" class="collapse-custom collapse @if ($checkMenu) show @endif"
            aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white-nav py-2 collapse-inner rounded">
                <a class="collapse-item rule rule_merchant_withdraw_create {{ activeMenuSidebar('merchant.withdraw.request.create.get') }}"
                    href="{{ route('merchant.withdraw.request.create.get') }}">
                    {{ __('common.sidebar.payment_request') }}</a>

                <a class="collapse-item rule rule_merchant_withdraw_list @if ($checkMenuDetail) active @endif {{ activeMenuSidebar('merchant.withdraw.history.index.get') }}"
                    href="{{ route('merchant.withdraw.history.index.get') }}">
                    {{ __('common.sidebar.payment_history') }}
                </a>
            </div>
        </div>
    </li>

    <li
        class="nav-item rule rule_merchant_notification {{ activeMenuSidebar('merchant.notification.index.get') }} {{ activeMenuSidebar('merchant.notification.detail.get') }}">
        <div class="nav-hover">
            <a class="nav-link notification" href="{{ route('merchant.notification.index.get') }}">
                <div class="img-noti">
                    <img src="{{ asset('/dashboard/img/noti.svg') }}" alt="" />
                    @if (auth('merchant')->user()->have_unread_notification)
                        <div class="icon-dot-noti"></div>
                    @endif
                </div>
                <span>{{ __('common.sidebar.notification') }}</span>
            </a>
        </div>
    </li>
    @php
        $checkMenuSetting = in_array($currentRoute, ['merchant.account.index.get', 'merchant.account.create.get', 'merchant.account.detail.get', 'merchant.account.edit.get']);
    @endphp
    <li
        class="nav-item rule rule_merchant_setting @if ($checkMenuSetting) active @endif {{ activeMenuSidebar('merchant.setting.profile.index') }}">
        <div class="nav-hover">
            <a class="nav-link" href="{{ route('merchant.setting.profile.index') }}">
                <img src="{{ asset('/dashboard/img/setting.svg') }}" />
                <span>{{ __('common.sidebar.setting') }}</span>
            </a>
        </div>
    </li>

    @if(!empty(auth('merchant')->user()->getMerchantStore))
        <a class="payment d-flex text-decoration-none" href="{{ route('merchant.payment.index.get') }}">
            <img class="" src="{{ asset('/dashboard/img/payment_logo.svg') }}" alt="" />
            <button>{{ __('common.sidebar.payment_screen') }}</button>
        </a>
    @endif
</ul>
