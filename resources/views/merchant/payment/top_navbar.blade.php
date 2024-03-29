<nav class="navbar navbar-expand navbar-light bg-white topbar static-top shadow">
    <img class="ml-10" src="/dashboard/img/payment_logo.svg">

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <!-- Nav Item - Language -->
        <li class="nav-item dropdown mx-1">
            <div class="nav-link">
                {{__('merchant.setting.profile.stores')}}: {{formatAccountId($userInfo->getMerchantStore->merchant_code)}} - {{$userInfo->getMerchantStore->name }}
            </div>
        </li>
        <li class="nav-item dropdown mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19">
                    <path id="Vector"
                        d="M20,1.959V9.141A1.912,1.912,0,0,1,18.065,11.1h-7.1v4.57H6.645L2.581,19V15.67H1.935A1.912,1.912,0,0,1,0,13.711V6.529A1.912,1.912,0,0,1,1.935,4.57H7.742V0H18.065A1.912,1.912,0,0,1,20,1.959ZM8.516,12.993,6.387,7.182H4.839L2.71,12.993H4.258l.387-1.045h2l.323,1.045Zm7.032-5.354a5,5,0,0,0,1.419-3.722L16.9,3.265H14.774V1.959h-1.29V3.265H11.548V4.57h3.871a3.391,3.391,0,0,1-1.226,2.416A3.281,3.281,0,0,1,13.161,5.55H11.806a4.475,4.475,0,0,0,1.161,2.089,4.857,4.857,0,0,1-1.355.2l.065,1.306a6.849,6.849,0,0,0,2.581-.653,5.77,5.77,0,0,0,2.516.653V7.835a4.336,4.336,0,0,1-1.226-.2Z"
                        transform="translate(0 0)" fill="#64748b" />
                </svg>
                <span>&nbsp;
                    @if (app()->getLocale() == 'en')
                        English
                    @else
                        日本語
                    @endif
                </span>
            </a>
            <!-- Dropdown - Messages -->
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="messagesDropdown">
                <a class="dropdown-item d-flex align-items-center" href="{{ route('change_language', ['ja']) }}">
                    <div class="{{ app()->getLocale() === 'ja' ? 'font-weight-bold' : '' }}">
                        <span>日本語</span>
                    </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="{{ route('change_language', ['en']) }}">
                    <div class="{{ app()->getLocale() === 'en' ? 'font-weight-bold' : '' }}">
                        <span>English</span>
                    </div>
                </a>
            </div>
        </li>
    </ul>
</nav>
