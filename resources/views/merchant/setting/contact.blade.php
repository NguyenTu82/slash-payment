@extends('merchant.layouts.base', ['title' => __('common.setting.profile.profile_info')])
@section('title', __('common.setting.title'))

@push('css')
@endpush

@section('content')
    <section class="content setting-page">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12 pl-0">
                    {{-- tab --}}
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link" aria-current="page" href="{{route('merchant.setting.profile.index')}}">
                                {{ __('common.setting.profile.profile_info') }}
                            </a>
                            <a class="nav-link active" aria-current="page" href="{{route('merchant.setting.contact.index')}}">
                                {{ __('admin_epay.admin.account_management') }}
                            </a>
                            <a class="nav-link" aria-current="page" href="{{route('merchant.setting.profile.index')}}">
                                {{ __('admin_epay.admin.permission_management') }}
                            </a>
                            <a class="nav-link" aria-current="page" href="{{route('merchant.setting.profile.index')}}">
                                {{ __('admin_epay.admin.fee_setting') }}
                            </a>
                        </div>
                    </nav>


                    {{-- tab content  --}}
                    <div class="tab-content" id="nav-tabContent">
                        {{-- contact-box--}}
                        <div class="profile-box">
                            <form action="" method="POST" id="update-profile-form" class="">
                                AAAAAAAAAAAA
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('script')
@endpush
