@extends('epay.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/account_manager_list.css') }}">
    <style>
        .container-fluid.bg-white{
            background-color: #F1F1F1 !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="account bg-white mt-20">
                @include('epay.setting.navbar')
            </div>

            <div class="account bg-white mt-20">
                <div class="list_search d-flex">
                    <form class="form-search form-input" id="search" method="GET" role="form" action="{{secure_url(url()->current())}}">
                        <input name="per_page" type="hidden" value="{{$request->per_page}}">
                        <div class="search_info search_info__input d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.account_info') }}</p>
                            <input type="text" class="form-control input_infor  border-1 small" name="common"
                                   placeholder="{{ __('admin_epay.setting.account_management.search_name') }}" value="{{$request->common}}"/>
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.authority') }}</p>
                            <select class="select_list select_author" name="role_id">
                                <option value="">{{__('common.label.all')}}</option>
                                @foreach($roles as $role)
                                    <option value="{{$role->id}}" @if($request->role_id == $role->id) selected @endif>
                                        @if(app()->getLocale() == 'en')
                                            {{$role->name}}
                                        @else
                                            {{$role->name_jp}}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.status') }}</p>
                            <select class="select_list select_author" name="status">
                                @php
                                    use \App\Enums\AdminAccountStatus;
                                @endphp
                                <option value="">{{__('common.label.all')}}</option>
                                <option value="{{AdminAccountStatus::VALID->value}}" @if($request->status == AdminAccountStatus::VALID->value) selected @endif>{{__('common.status.valid')}}</option>
                                <option value="{{AdminAccountStatus::INVALID->value}}" @if($request->status == AdminAccountStatus::INVALID->value) selected @endif>{{__('common.status.invalid')}}</option>
                            </select>
                        </div>
                        <div class="d-flex flex  button__click">
                            <div class="action__button d-flex flex">
                                <button type="submit" class="btn btn_ok">{{ __('admin_epay.setting.account_management.list.search') }}</button>
                                <button type="button" class="btn btn_cancel reset">{{ __('admin_epay.setting.account_management.list.reset') }}</button>
                            </div>
                        </div>
                    </form>
                    @if(auth('epay')->user()->role->name === \App\Enums\AdminRole::ADMINISTRATOR->value)
                        <form class="form-search form-button-search rule rule_epay_account_create" role="form" action="{{route('admin_epay.account.create.get')}}">
                            <div class="d-flex flex  btn-action-search">
                                <div class="action_search">
                                    <button type="submit" class="btn btn_ok">{{ __('admin_epay.setting.account_management.create_account') }}</button>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <div class="account bg-white mt-20 mb-15">
                <p class="title_table">{{ __('admin_epay.admin.list_account') }}</p>
                <div class="table-data">
                    <div class="table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>{{ __('admin_epay.setting.account_management.list.accountID') }}</th>
                                    <th>{{ __('admin_epay.setting.account_management.list.name') }}</th>
                                    <th>{{ __('admin_epay.setting.account_management.list.mail') }}</th>
                                    <th>{{ __('admin_epay.setting.account_management.list.authority') }}</th>
                                    <th>{{ __('admin_epay.setting.account_management.list.status') }}</th>
                                    <th>{{ __('admin_epay.setting.account_management.list.detail') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($dataUsers->count() > 0)
                                @foreach($dataUsers as $user)
                                    <tr>
                                        <td>{{ formatAccountId($user->user_code) }}</td>
                                        <td>{{ object_get($user, 'name') }}</td>
                                        <td>{{ object_get($user, 'email') }}</td>
                                        <td>
                                            @if(app()->getLocale() == 'en')
                                                {{$user->role_name}}
                                            @else
                                                {{$user->name_jp}}
                                            @endif
                                        </td>
                                        @if($user->status == \App\Enums\AdminAccountStatus::VALID->value)
                                            <td class="status_item"><div class="status invalid">{{ __('common.status.valid') }}</div></td>
                                        @else
                                            <td class="status_item"><div class="status valid">{{ __('common.status.invalid') }}</div></td>
                                        @endif
                                        <td><a class="rule rule_epay_account_detail" href="{{ route('admin_epay.account.detail.get', ['id' => object_get($user, 'id')]) }}">{{ __('admin_epay.setting.account_management.list.detail') }}</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <td colspan="6"><div class="center-table">{{__('common.messages.no_data')}}</div></td>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('common.pagination', ['paginator' => $dataUsers])
            </div>
        </div>
    </div>

    @include('epay.setting.modal.success_delete_account')
@endsection

@push('script')
    <script type="text/javascript">
        const SUCCESS_DELETE_ACCOUNT_MODAL = $("#success-delete-account-modal");
        $('.reset').on('click', function () {
            $('input[name="common"]').val('');
            $('select[name="status"]').val('').selectpicker('refresh');
            $('select[name="role_id"]').val('').selectpicker('refresh');
            $('#search').submit();
        });

        @if (session('deleteSuccess'))
            $(SUCCESS_DELETE_ACCOUNT_MODAL).modal('show');
        @endif
    </script>
@endpush
