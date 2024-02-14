<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('common.layouts.headers.head')
    @include('common.layouts.headers.rule')
</head>
@php
    $userInfo = auth('epay')->user();
@endphp
<body class="hold-transition sidebar-mini layout-fixed d-none" data-panel-auto-height-mode="height" id="page-top">

<div class="" id="loading-page" >
    <span class="loader"></span>
</div>

<!-- Page Wrapper -->
<div id="wrapper" class="wrapper">
    <!-- Sidebar -->
    @include('epay.layouts.navbars.sidebar')

    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content" class="content-height">
            <!-- Topbar -->
            @include('epay.layouts.navbars.top_navbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">

                <section class="content-header " >
                    <div class="row header-input">
                        <div class="d-flex align-items-center">
                            <h1 class="main-title-page">@yield('title')</h1>
                        </div>
                        @yield('merchant_cash')
                    </div>
                </section>

                @yield('content')

                @if (session()->has('success'))
                    @include('common.modal.result', getPopupInfo(session()->get('success')))
                @endif
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('common.layouts.footers.copyright')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

@include('common.layouts.footers.foot')
</body>
</html>
