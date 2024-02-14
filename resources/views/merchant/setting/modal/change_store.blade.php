<div class="note-pass note-pass-select">
    <div class="modal modal-select fade" id="change-stores-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('common.setting.profile.select_merchant_store') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 my_checkbox merchant-list">
                            @foreach($allMerchantStores as $store)
                                @php
                                    $selected = in_array($store->id, $myStoresIds) ? true : false;
                                @endphp
                                <div class="row merchant-select checkbox icheck-primary {{ $selected ? 'active' : '' }}" >
                                    <input
                                        onclick="changeStores(this, '{{$store->id}}')"
                                        {{ $selected ? 'checked' : '' }}
                                        type="checkbox"
                                        class="merchant-item item-store-select"
                                        id="{{$store->id}}"
                                        value="{{ $store->id }}">
                                    <label class="name-merchant-item"for="{{$store->id}}">{{$store->name}}</label>
                                </div>
                            @endforeach
                            @if (!empty($allMerchantStores) && count($allMerchantStores) == 0)
                            <div class="row merchant-select checkbox icheck-primary active text-center">
                                <label class="name-merchant-item" id="screenshots_label"
                                    style="color:#FF5274">{{ __('admin_epay.merchant.common.can_not_merchant') }}</label>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="confirmChangeStores(this)" type="button" class="btn btn-primary">
                        <span>{{ __('common.button.confirm') }}</span>
                    </button>
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">
                        <span>{{ __('common.button.cancel') }}</span></button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.merchant-item').on('change', function () {
                if($(this).is(':checked'))
                    $(this).parent().addClass('active');
                else
                    $(this).parent().removeClass('active');
            });
        });
    </script>
@endpush
