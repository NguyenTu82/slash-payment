<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        <a class="nav-link {{$active =="profile" ? "active" : ""}}" aria-current="page"
            href="{{ route('admin_epay.setting.profile.index') }}">
            {{ __('common.setting.profile.profile_info') }}
        </a>
        <a class="nav-link {{$active =="account" ? "active" : ""}}" aria-current="page"
            href="{{ route('admin_epay.account.index') }}">
            {{ __('common.setting.profile.account_management') }}
        </a>
    </div>
</nav>