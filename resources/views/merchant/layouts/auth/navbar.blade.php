<nav class="navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <img src="/dashboard/img/logo.svg"/>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
            <a
                class="nav-link"
                data-widget=""
                href="{{route('merchant.auth.login')}}"
                role="button"
            >{{__('auth.common.login.login')}}</a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-widget=""
                href="{{route('merchant.auth.register.index.get')}}"
                role="button"
            >{{__('auth.common.login.register')}}</a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-widget=""
                href="{{route('merchant.auth.login')}}"
                role="button"
            >{{__('auth.common.login.forget-home')}}</a>
        </li>
        <li class="nav-item">
            <a
                class="nav-link"
                data-widget=""
                href="{{route('merchant.auth.login')}}"
                role="button"
            >{{__('auth.common.login.forget-store')}}</a>
        </li>
        <li class="nav-item dropdown mx-1">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="alertsDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <img class="img-language-icon-nav" src="{{ asset('/dashboard/img/language.svg') }}" alt="">
                <span>&nbsp;
                    @if(app()->getLocale() == 'en')
                        English
                    @else
                        日本語
                    @endif
                </span>
            </a>
            <!-- Dropdown - Alerts -->
            <div
                class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown"
            >
                <a
                    class="dropdown-item d-flex align-items-center"
                    href="{{ route('change_language', ['ja']) }}"
                >
                    <div>
                        <span class="font-weight-bold">日本語</span>
                    </div>
                </a>
                <a
                    class="dropdown-item d-flex align-items-center"
                    href="{{ route('change_language', ['en']) }}"
                >
                    <div>English</div>
                </a>
            </div>
        </li>

        <li class="list-item-responsive nav-item-responsive dropdown mx-1">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="alertsDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <img class="img-language-icon-nav" src="{{ asset('/dashboard/img/language.svg') }}" alt="">
                <span>&nbsp;
                    @if(app()->getLocale() == 'en')
                        English
                    @else
                        日本語
                    @endif
                </span>
            </a>
            <!-- Dropdown - Alerts -->
            <div
                class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown"
            >
                <a
                    class="dropdown-item d-flex align-items-center"
                    href="{{ route('change_language', ['ja']) }}"
                >
                    <div class="{{ app()->getLocale() === 'ja' ? 'font-weight-bold' : '' }}">
                        <span>日本語</span>
                    </div>
                </a>
                <a
                    class="dropdown-item d-flex align-items-center"
                    href="{{ route('change_language', ['en']) }}"
                >
                    <div class="{{ app()->getLocale() === 'en' ? 'font-weight-bold' : '' }}">
                        <span>English</span>
                    </div>
                </a>
            </div>
        </li>
        <li class="list-item-responsive nav-item-responsive dropdown no-arrow">
            <a
                class="nav-link dropdown-toggle"
                href="#"
                id="userDropdown"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >
                <i class="fa fa-bars"></i>
            </a>
            <div
                class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown"
            >
                <a class="dropdown-item" role="button" data-widget="" href="{{route('admin_epay.auth.login')}}">
                    {{__('auth.common.login.login')}}
                </a>
                <a class="dropdown-item" role="button" data-widget="" href="{{route('admin_epay.auth.login')}}">
                    {{__('auth.common.login.register')}}
                </a>
                <a class="dropdown-item" role="button" data-widget="" href="{{route('admin_epay.auth.login')}}">
                    {{__('auth.common.login.forget-home')}}
                </a>
                <!-- <div class="dropdown-divider"></div> -->
                <a class="dropdown-item" role="button" data-widget="" href="{{route('admin_epay.auth.login')}}">
                    {{__('auth.common.login.forget-store')}}
                </a>
            </div>
        </li>
    </ul>
</nav>
