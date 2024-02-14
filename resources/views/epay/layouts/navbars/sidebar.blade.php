@php
    $currentRoute = Route::currentRouteName();
@endphp

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <img class="img-sidebar" src="{{ asset('/dashboard/img/sidebar_logo.svg') }}" alt="" />

    <!-- Divider -->
    <hr class="sidebar-divider my-0" />
    <li class="nav-item rule rule_epay_dashboard {{ activeMenuSidebar('admin_epay.dashboard.index.get') }}">
        <div class="nav-hover">
            <a class="nav-link" href="{{ route('admin_epay.dashboard.index.get') }}">
                <img src="{{ asset('/dashboard/img/dashboard.svg') }}" alt="" />
                <span>{{ __('common.sidebar.dashboard') }}</span>
            </a>
        </div>
    </li>

    @php
        $checkMenuMerchant = in_array($currentRoute, ['admin_epay.usageSituation.index.get', 'admin_epay.merchantStore.index.get', 'admin_epay.merchantStore.view_edit']);
        $checkMenuMerchantCreate = in_array($currentRoute, ['admin_epay.merchantStore.view_create']);
        $checkMenuMerchantReport = in_array($currentRoute, ['admin_epay.report.index.get', 'admin_epay.report.detail.get', 'admin_epay.report.edit.get']);
        $checkMenuMerchantDetail = in_array($currentRoute, ['admin_epay.merchantStore.detail']);
    @endphp

    <li
        class="nav-item rule rule_epay_merchant @if ($checkMenuMerchant) active @endif  @if ($checkMenuMerchantReport) active @endif @if ($checkMenuMerchantDetail) active @endif {{ activeMenuSidebar('admin_epay.merchantStore.view_create') }}">
        <div class="nav-hover">
            <a class="nav-link @if (!($checkMenuMerchant || $checkMenuMerchantCreate || $checkMenuMerchantReport || $checkMenuMerchantDetail)) collapsed @endif" href="#" data-toggle="collapse"
                data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <img src="{{ asset('/dashboard/img/merchant.svg') }}" alt="" />
                <span>{{ __('common.sidebar.merchant') }}</span>
            </a>
        </div>
        <div id="collapseTwo"
            class="collapse @if ($checkMenuMerchant) show @endif @if ($checkMenuMerchantCreate) show @endif @if ($checkMenuMerchantReport) show @endif @if ($checkMenuMerchantDetail) show @endif"
            aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white-nav py-2 collapse-inner rounded">
                <a class="collapse-item rule rule_epay_merchant_list @if ($checkMenuMerchant) active @endif @if ($checkMenuMerchantDetail) active @endif {{ activeMenuSidebar('admin_epay.merchantStore.index.get') }}"
                    href="{{ route('admin_epay.merchantStore.index.get') }}">
                    {{ __('common.sidebar.merchant_list') }}
                </a>
                <a class="collapse-item rule rule_epay_merchant_report @if ($checkMenuMerchantReport) active @endif {{ activeMenuSidebar('admin_epay.report.index.get') }}"
                    href="{{ route('admin_epay.report.index.get') }}">
                    {{ __('common.sidebar.report') }}
                </a>
                <a class="collapse-item rule rule_epay_merchant_create {{ activeMenuSidebar('admin_epay.merchantStore.view_create') }}"
                    href="{{ route('admin_epay.merchantStore.view_create') }}">
                    {{ __('common.sidebar.merchant_regis') }}
                </a>
            </div>
        </div>
    </li>
    <li class="nav-item rule rule_epay_af">
        <div class="nav-hover">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                aria-expanded="true" aria-controls="collapseUtilities">
                <img src="{{ asset('/dashboard/img/AF_gray_out.svg') }}" alt="" />
                {{-- <img src="{{ asset('/dashboard/img/AF.svg') }}" alt="" /> --}}
                <span class="gray-color">{{ __('common.sidebar.AF') }}</span>
            </a>
        </div>
        <div id="collapseUtilities" class="collapse-custom collapse" aria-labelledby="headingUtilities"
            data-parent="#accordionSidebar">
            <div class="bg-white-nav py-2 collapse-inner rounded">
                <a class="collapse-item rule rule_epay_af_list" href="">
                    <span class="gray-color">{{ __('common.sidebar.AF_list') }}</span>
                </a>
                <a class="collapse-item rule rule_epay_af_create" href="">
                    <span class="gray-color">{{ __('common.sidebar.AF_regis') }}</span>
                </a>
            </div>
        </div>
    </li>
    @php
        $checkMenu = in_array($currentRoute, ['admin_epay.withdraw.history.index.get', 'admin_epay.withdraw.history.detail.get', 'admin_epay.withdraw.request.create.get', 'admin_epay.withdraw.history.edit.get']);
        $checkMenuDetail = in_array($currentRoute, ['admin_epay.withdraw.history.detail.get', 'admin_epay.withdraw.history.edit.get']);
    @endphp
    <li class="nav-item rule rule_epay_withdraw @if ($checkMenu) active @endif">
        <div class="nav-hover">
            <a class="nav-link @if (!$checkMenu) collapsed @endif" href="#"
                data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <img src="{{ asset('/dashboard/img/payment.svg') }}" alt="" />
                <span>{{ __('common.sidebar.payment') }}</span>
            </a>
        </div>
        <div id="collapsePages" class="collapse-custom collapse  @if ($checkMenu) show @endif"
            aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white-nav py-2 collapse-inner rounded">
                <a class="collapse-item rule rule_epay_withdraw_create {{ activeMenuSidebar('admin_epay.withdraw.request.create.get') }}"
                    href="{{ route('admin_epay.withdraw.request.create.get') }}">
                    {{ __('common.sidebar.payment_request') }}</a>
                <a class="collapse-item rule rule_epay_withdraw_list @if ($checkMenuDetail) active @endif {{ activeMenuSidebar('admin_epay.withdraw.history.index.get') }}"
                    href="{{ route('admin_epay.withdraw.history.index.get') }}">
                    {{ __('common.sidebar.payment_history') }}</a>
            </div>
        </div>
    </li>
    @php
        $checkMenu = in_array($currentRoute, ['admin_epay.notification.index.get', 'admin_epay.notification.detail.get', 'admin_epay.notification.createNotification.get', 'admin_epay.notification.view_template.get']);
    @endphp
    <li
        class="nav-item rule rule_epay_notification {{ activeMenuSidebar('admin_epay.notification.index.get') }} @if ($checkMenu) active @endif">
        <div class="nav-hover rule rule_epay_notification_list">
            <a class="nav-link notification " href="{{ route('admin_epay.notification.index.get') }}">
                <div class="img-noti">
                    <img src="{{ asset('/dashboard/img/noti.svg') }}" alt="" />
                    @if (auth('epay')->user()->have_unread_notification)
                        <div class="icon-dot-noti"></div>
                    @endif
                </div>
                <span>{{ __('common.sidebar.notification') }}</span>
            </a>
        </div>
    </li>
    @php
        $checkMenu = in_array($currentRoute, ['admin_epay.account.index.get', 'admin_epay.account.create.get', 'admin_epay.account.detail.get']);
    @endphp
    <li
        class="nav-item rule rule_epay_setting {{ activeMenuSidebar('admin_epay.setting.profile.index') }} @if ($checkMenu) active @endif">
        <div class="nav-hover ">
            <a class="nav-link" href="{{ route('admin_epay.setting.profile.index') }}">
                <img src="{{ asset('/dashboard/img/setting.svg') }}" alt="" />
                <span>{{ __('common.sidebar.setting') }}</span>
            </a>
        </div>
    </li>
</ul>
