@php
    $route = Route::currentRouteName();
@endphp
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @php
            $accountRoutes = [
                'admin_epay.notification.index.get',
                'admin_epay.notification.detail.get',
                'admin_epay.notification.createNotification.get',
                'admin_epay.notification.send_detail.get',
                'admin_epay.notification.send_edit.get'
            ];
        @endphp
        <a class="nav-link @if (in_array($route, $accountRoutes)) active @endif" aria-current="page"
           href="{{route('admin_epay.notification.index.get')}}">
            {{ __('common.screens.notification_list') }}
        </a>

        <a class="nav-link @if ($route == 'admin_epay.notification.view_template.get') active @endif" aria-current="page"
           href="{{route('admin_epay.notification.view_template.get')}}">
            {{ __('common.screens.system_notification_list') }}
        </a>
    </div>
</nav>
