@extends('merchant.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_success.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/account_manager_list.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="account bg-white mt-20">
                @include('merchant.setting.navbar')
            </div>
            <div class="account bg-white mt-20">
                <div class="list_search d-flex">
                    <form class="form-search form-input" id="search" method="GET" role="form" action="{{secure_url(url()->current())}}">
                        <input name="per_page" type="hidden" value="{{ $request->per_page }}">
                        <div class="search_info search_info__input d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.account_info') }}</p>
                            <input type="text" class="form-control input_infor  border-1 small" name="common"
                                   placeholder="{{ __('admin_epay.setting.account_management.search_name') }}" value="{{$request->common}}"/>
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.authority') }}</p>
                            <select class="select_list select_author" name="role_id">
                                <option value="">{{__('common.label.all')}}</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        @if ($request->role_id == $role->id) selected @endif>
                                        @if (app()->getLocale() == 'en')
                                            {{ $role->name }}
                                        @else
                                            {{ $role->name_jp }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="search_info d-flex flex-column">
                            <p>{{ __('admin_epay.setting.account_management.list.status') }}</p>
                            <select class="select_list select_author" name="status">
                                @php
                                    use App\Enums\MerchantUserStatus;
                                @endphp
                                <option value="">{{__('common.label.all')}}</option>
                                <option value="{{ MerchantUserStatus::VALID->value }}"
                                    @if ($request->status == MerchantUserStatus::VALID->value) selected @endif>{{ __('common.status.valid') }}
                                </option>
                                <option value="{{ MerchantUserStatus::INVALID->value }}"
                                    @if ($request->status == MerchantUserStatus::INVALID->value) selected @endif>{{ __('common.status.invalid') }}
                                </option>
                            </select>
                        </div>
                        <div class="d-flex flex button__click">
                            <div class="action__button d-flex flex">
                                <button type="submit" class="btn btn_ok">{{ __('admin_epay.setting.account_management.list.search') }}</button>
                                <button type="button" class="btn btn_cancel reset">{{ __('admin_epay.setting.account_management.list.reset') }}</button>
                            </div>
                        </div>
                    </form>

                    @if(auth('merchant')->user()->role->name != \App\Enums\MerchantRole::USER->value)
                        <form class="form-search form-button-search" role="form"
                            action="{{ route('merchant.account.create.get') }}">
                            <div class="d-flex flex  btn-action-search rule rule_merchant_account_create">
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
                            @if($accounts->count() > 0)
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ "AC".formatAccountId($account->user_code) }}</td>
                                        <td>{{ $account->name }}</td>
                                        <td>{{ $account->email }}</td>
                                        <td>
                                            @if (app()->getLocale() == 'en')
                                                {{ $account->role->name }}
                                            @else
                                                {{ $account->role->name_jp }}
                                            @endif
                                        </td>
                                        @if ($account->status == \App\Enums\MerchantUserStatus::VALID->value)
                                            <td class="status_item">
                                                <div class="status invalid">{{ __('common.status.valid') }}</div>
                                            </td>
                                        @else
                                            <td class="status_item">
                                                <div class="status valid">{{ __('common.status.invalid') }}</div>
                                            </td>
                                        @endif
                                        <td><a class="rule rule_merchant_account_detail"  href="{{ route('merchant.account.detail.get', ['id'=>$account->id]) }}">{{ __('admin_epay.setting.account_management.list.detail') }}</a></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><div class="center-table">{{__('common.messages.no_data')}}</div></td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('common.pagination', ['paginator' => $accounts])
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $('.reset').on('click', function() {
            $('input[name="common"]').val('');
            $('select[name="status"]').val('').selectpicker('refresh');
            $('select[name="role_id"]').val('').selectpicker('refresh');
            $('#search').submit();
        });
    </script>
@endpush
