@php
    $route = Route::currentRouteName();
@endphp
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link rule rule_merchant_profile @if ($route == 'merchant.setting.profile.index') active @endif" aria-current="page"
           href="{{route('merchant.setting.profile.index')}}">
            {{ __('common.setting.profile.profile_info') }}
        </a>
        @php
            $accountRoutes = ['merchant.account.index.get', 'merchant.account.create.get', 'merchant.account.detail.get', 'merchant.account.edit.get'];
        @endphp
        <a class="nav-link rule rule_merchant_account_list @if (in_array($route, $accountRoutes)) active @endif" aria-current="page"
           href="{{route('merchant.account.index.get')}}">
            {{ __('common.setting.profile.account_management') }}
        </a>
        @if(!empty(auth('merchant')->user()->getMerchantStore))
            <a class="nav-link rule rule_merchant_account_init_setting_edit @if ($route == 'merchant.setting.account_init_setting.get') active @endif" aria-current="page"
            href="{{route('merchant.setting.account_init_setting.get')}}">
                {{ __('common.setting.profile.account_init_setting') }}
            </a>
        @endif
    </div>
</nav>
