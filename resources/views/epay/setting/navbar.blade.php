@php
    $route = Route::currentRouteName();
@endphp
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link rule rule_epay_setting {{ (strpos($route, 'admin_epay.setting.profile.index') === 0) ? 'active' : '' }}" aria-current="page"
           href="{{route('admin_epay.setting.profile.index')}}">
            {{ __('common.setting.profile.profile_info') }}
        </a>

        @php
            $accountRoutes = [
                'admin_epay.account.index.get',
                'admin_epay.account.create.get',
                'admin_epay.account.detail.get',
            ];
        @endphp
        <a class="nav-link rule rule_epay_account_list @if (in_array($route, $accountRoutes)) active @endif" aria-current="page"
           href="{{route('admin_epay.account.index.get')}}">
            {{ __('common.setting.profile.account_management') }}
        </a>
    </div>
</nav>
