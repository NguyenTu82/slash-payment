@extends('merchant.layouts.base')
@section('title', __('common.setting.title'))

@push('css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/modal.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/merchant/create_account.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_confirm.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/main_html/css/popup/popup_select.css') }}">
    <style>
        .error {
            font-size: 100%;
        }
        .input-custom {
            width: inherit !important;
        }
    </style>
@endpush

@section('content')
    <div class="setting-page page-white">
        <div class="row">
            <div class="col-12 create-new-account p-0">
                <div class="account bg-white mt-20">
                    @include('merchant.setting.navbar')
                </div>
                <div class="form-create-account">
                    <form id="createAccountForm" class="fomr-create" action="{{ route('merchant.account.store.post') }}" data-toggle="validator" method="POST">
                        @csrf
                        <h3 class="title-create-account">{{ __('common.setting.account.create_account_title') }}</h3>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.name') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <input type="text" class="form-control" id="input-name" name="name" value="{{ old('name') }}" required>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.account_type') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form" name="merchant_role_id" required>
                                        <option value=""></option>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}" @if(($request->role_id || old('merchant_role_id')) == $role->id) selected @endif>
                                                @if(app()->getLocale() == 'en')
                                                    {{$role->name}}
                                                @else
                                                    {{$role->name_jp}}
                                                @endif
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.status') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <div class="select_info">
                                    <select class="form-control select_form" name="status" disabled required>
                                        @php
                                            use \App\Enums\MerchantUserStatus;
                                        @endphp
                                        <option  value="{{MerchantUserStatus::VALID->value}}"  selected >{{__('common.status.valid')}}</option>
                                    </select>
                                </div>
                                <div class="note-pass"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.note') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <textarea class="form-control form-area-remarks" name="note" rows="5">{{ old('note') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="input-email" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.mail') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note">
                                <div>
                                    <input type="email" class="form-control @error('email') border-error @enderror" id="input-email" name="email" value="{{ old('email') }}" required>
                                </div>
                                <div class="note-pass">
                                    @error('email')
                                    <p class="serve-error note-pass-error">{{$errors->first('email')}}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row form-item form-note-error-pass">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.password') }}
                            </label>
                            <div class="col col-md-10 pw-current-box form-item-ip form-note form-note-error">
                                <div>
                                    <input type="password" class="form-control" name="password" required>
                                    <p class="noti-input">{{ __('common.account_management.password_description') }}</p>
                                </div>
                                <div class="note-pass note-pass-err"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item form-note-error-pass">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.account.confirm_password') }}
                            </label>
                            <div class="col col-md-10 pw-current-box form-item-ip form-note form-note-error">
                                <div>
                                    <input type="password" class="form-control" name="password_confirm" required>
                                    <p class="noti-input">{{ __('common.account_management.confirm_password_description') }}</p>
                                </div>
                                <div class="note-pass note-pass-err"></div>
                            </div>
                        </div>

                        <div class="form-group row form-item">
                            <label for="" class="col col-md-2 col-form-label label-custom">
                                {{ __('common.setting.profile.store') }}
                            </label>
                            <div class="col col-md-10 form-item-ip form-note form-note-textarea">
                                <div class="form-control list-area-members">
                                    @if($errors->any())
                                        @foreach(old('merchant_store_ids') as $key => $value)
                                            <p class="members-item">{{$key}}</p>
                                            <div class="line-item"></div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="note-pass note-pass-select">
                                    <input type="hidden" name="store_latest" value="{{old('name')}}">
                                    <div><p class="note-pass-error"></p></div>
                                    <button type="button" class="btn form-select" data-toggle="modal" data-target="#selectMerchant">
                                        {{__('merchant.setting.profile.choose_store')}}
                                    </button>

                                    <!-- Modal Select Merchant -->
                                    @include('common.modal.select_merchant', [
                                        'stores' => $merchantStores,
                                        'selectedStores' => old('merchant_store_ids'),
                                    ])
                                </div>
                            </div>
                        </div>
                        <div class="form-group row form-item">
                            <label for="" class="col-sm-2 col-form-label label-custom"></label>
                            <div class="col col-md-7 button-action">
                                <button type="submit" class="btn form-save" form="createAccountForm">{{ __('common.button.create') }}</button>
                                <button type="button" class="btn form-close">{{ __('common.button.cancel') }}</button>
                            </div>
                        </div>
                    </form>

                    <!-- Modal confirm -->
                    @include('common.modal.confirm', [
                        'title' => __('admin_epay.setting.account_management.title_confirm_modal_create'),
                        'description' => __('admin_epay.setting.account_management.description_confirm_modal_create'),
                        'submit_btn' => __('common.button.create'),
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            const MERCHANT_STORE = $('.merchant-item');
            const STORE_SELECTED = $('.list-area-members');
            const CREATE_ACCOUNT_FORM = $('#createAccountForm');
            const CONFIRM_UPDATE_PROFILE_MODAL = $("#confirm-modal");
            const MERCHANT_SELECTED =  $('.form-note-textarea');
            const CANCEL_CREATE_ACCOUNT_BTN = $('.form-close');

            // Show merchant name select to view
            MERCHANT_STORE.on('click', function () {
                STORE_SELECTED.children().remove();
                $('input[name=store_latest]').val('');
                $('input:checked').each(function () {
                    let name = $(this).data('name');
                    $('input[name=store_latest]').val(name);
                    STORE_SELECTED.append(`<p class="members-item">${name}</p><div class="line-item"></div>`);
                });

                if ($('input:checked').length > 0) {
                    MERCHANT_SELECTED.find('.border-error').removeClass('border-error');
                    MERCHANT_SELECTED.find('.note-pass-error').html('');
                }
            });

            SUBMIT_BUTTON_COMMON.on('click', function () {
                CREATE_ACCOUNT_FORM[0].submit();
            });

            CANCEL_CREATE_ACCOUNT_BTN.on('click', function () {
                window.location.href = `{{ route('merchant.account.index.get') }}`;
            });

            // Validate form
            $(function() {
                $('select').on('change', function(e) {
                    $(this).valid();
                });

                $.validator.setDefaults({ ignore: []});

                $(CREATE_ACCOUNT_FORM).validate({
                    rules: {
                        name: {
                            required: true,
                        },
                        merchant_role_id: {
                            required: true,
                        },
                        email: {
                            required: true,
                            email: true,
                        },
                        password: {
                            required: true,
                            checkStringNumber: true,
                        },
                        password_confirmation: {
                            required: true,
                            equalTo: "#password"
                        },
                        store_latest: {
                            required: true,
                        },
                    },
                    messages: {
                        name: {
                            required: "{{ __('common.account_management.validation.name.required') }}",
                        },
                        merchant_role_id: {
                            required: "{{ __('common.account_management.validation.role.required') }}",
                        },
                        email: {
                            required: "{{ __('common.account_management.validation.email.required') }}",
                            email: "{{ __('common.account_management.validation.email.invalid') }}",
                        },
                        password: {
                            required: "{{ __('common.account_management.validation.password.required') }}",
                            checkStringNumber: "{{ __('auth.common.two_fa.verify_check_string') }}"
                        },
                        password_confirm: {
                            required: "{{ __('common.account_management.validation.password_confirm.required') }}",
                            equalTo: "{{ __('auth.common.two_fa.verify_equal_to') }}"
                        },
                        store_latest: {
                            required: "",
                        },
                    },
                    errorElement: 'p',
                    errorPlacement: function(error, element) {
                        $(element).parent().parent().find('.serve-error').remove();
                        const name = $(element).attr('name');
                        if (name === 'store_latest') {
                            $('.list-area-members').addClass('border-error');
                            $(element).parent().find('.note-pass-error').html('')
                                .append("{{ __('common.account_management.validation.merchant_store_ids.required') }}");
                        } else {
                            error.addClass('note-pass-error');
                            element.closest('.form-item-ip').find('.note-pass').append(error);
                        }
                    },
                    highlight: function(element) {
                        if ($(element)[0].tagName === 'SELECT') {
                            $(element).parent().parent().addClass('border-error');
                        } else {
                            $(element).addClass('border-error');
                        }
                    },
                    unhighlight: function(element) {
                        $(element).parent().parent().find('.serve-error').remove();
                        if ($(element)[0].tagName === 'SELECT') {
                            $(element).parent().parent().removeClass('border-error');
                        } else {
                            $(element).removeClass('border-error');
                        }
                    },
                    submitHandler: function() {
                        CONFIRM_UPDATE_PROFILE_MODAL.modal('show');
                    }
                });
            });
        });
    </script>
@endpush
