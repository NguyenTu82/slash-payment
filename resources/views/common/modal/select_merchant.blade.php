<div class="modal modal-select fade" id="selectMerchant" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.setting.profile.select_merchant_store') }}
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 mb-52 search-container">
                        <input type="text" class="form-control input-custom" name="nameOrID" id="nameOrID"
                            value="{{ old('nameOrID') }}"
                            placeholder="{{ __('common.setting.profile.placeholder_search') }}"
                            onkeyup="searchNameOrID()">
                        <div class="search-icon">
                            <img src="/dashboard/img/search.svg" class="" alt="...">
                        </div>
                    </div>
                    <div class="col-12 my_checkbox merchant-list">
                        @foreach ($stores as $store)
                            <div
                                class="row merchant-select checkbox icheck-primary @if (!is_null($selectedStores) && in_array($store->id, $selectedStores)) active @endif rows row-{{ $store->id }}">
                                <input type="checkbox" class="merchant-item"
                                    name="merchant_store_ids[{{ $store->name }}]" data-name="{{ $store->name }}"
                                    id="{{ $store->id }}" value="{{ $store->id }}"
                                    @if (!is_null($selectedStores) && in_array($store->id, $selectedStores)) checked @endif>
                                <label class="name-merchant-item" for="{{ $store->id }}"
                                    id="screenshots_label">{{ $store->name }}</label>
                            </div>
                        @endforeach
                        @if (count($stores) == 0)
                            <div class="row merchant-select checkbox icheck-primary active text-center">
                                <label class="name-merchant-item" id="screenshots_label"
                                    style="color:#FF5274">{{ __('admin_epay.merchant.common.can_not_merchant') }}</label>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    {{ __('common.button.confirm') }}</button>
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ __('common.button.cancel') }}</button>
            </div>
        </div>
    </div>
</div>
@push('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.merchant-item').on('change', function() {
                if ($(this).is(':checked'))
                    $(this).parent().addClass('active');
                else
                    $(this).parent().removeClass('active');
            });
        });

        var oldValue = '';
        const searchNameOrID = () => {
            var inputValue = document.getElementById("nameOrID").value;
            if (inputValue !== '') {
                var arrStores = <?php echo json_encode($stores); ?>;
                for (var i = 0; i < arrStores.length; i++) {
                    var classRow = '.row-' + arrStores[i]["id"];
                    if (inputValue.length < oldValue.length) {
                        if ((arrStores[i]["name"].indexOf(inputValue) !== -1) || (arrStores[i]["id"].indexOf(
                                inputValue) !== -1)) {
                            $(classRow).removeClass('d-none');
                        }
                    }
                    if ((arrStores[i]["name"].indexOf(inputValue) === -1) && (arrStores[i]["id"].indexOf(inputValue) ===
                            -1)) {
                        $(classRow).addClass('d-none');
                    }
                }
                oldValue = inputValue;
            } else {
                $('.rows').removeClass('d-none');
            }
        }
    </script>
@endpush
