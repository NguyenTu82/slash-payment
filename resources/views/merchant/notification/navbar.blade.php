@php
    $route = Route::currentRouteName();
@endphp
<nav>
    <div class="nav nav-tabs" id="nav-tab" role="tablist">
        @php
            $notificationListRoutes = ['merchant.notification.index.get', 'merchant.notification.receive_delete.get'];
        @endphp
        <a class="nav-link @if (in_array($route, $notificationListRoutes)) active @endif" aria-current="page"
           href="{{route('merchant.notification.index.get')}}">
            {{__('common.screens.notification_list')}}
        </a>
        <a class="nav-link" aria-current="page" href="">
            {{__('common.sidebar.system_notification')}}
        </a>
    </div>
</nav>
