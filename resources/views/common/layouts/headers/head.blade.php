<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Epay | @yield('title')</title>
<link rel="icon" type="image/x-icon" href="/dashboard/img/favicon.svg">

<!-- Google Font: Source Sans Pro -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap" rel="stylesheet">
<link href='https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@300;400;500;700&display=fallback' rel='stylesheet'>
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/fontawesome-free/css/all.min.css') }}">

<link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/toastr/toastr.min.css') }}">
<!-- overlayScrollbars -->
<link rel="stylesheet"
      href="{{ asset('dashboard/themes/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
<!--sbadmin2-->
<link rel="stylesheet" href="{{ asset('dashboard/themes/dist_sbadmin2/css/sb-admin-2.min.css') }}">

<!--custom css-->
<link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/sidebarr.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/header.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/main_html/css/common/custom.css') }}">

<!--sidebar-->
<link rel="stylesheet" href="{{ asset('dashboard/css/sidebar.css') }}">

<!-- merchant_dashboard-->
<link rel="stylesheet" href="{{ asset('dashboard/main_html/css/bootstrap-select.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select.css') }}">
<link rel="stylesheet" href="{{ asset('dashboard/main_html/css/bootstrap-datepicker.min.css') }}">

<!-- add bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
        crossorigin="anonymous"></script>

<!-- icheck bootstrap -->
<link rel="stylesheet" href="{{ asset('dashboard/themes/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
@stack('css')
