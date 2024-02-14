<!-- Modal -->
<div class="modal modal-popup-DataForm fade" id="showDataFormEdit" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('common.usage_situtation.usage_edit') }}</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-12">
                        <div class="account bg-white ">
                            <form class="form-detail form-dropdown-input" action="" method="POST"
                                id="update-form">
                                @csrf
                                <div class="form-group row form-item">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.trans_ID') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" readonly
                                            name="transIdForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.request_datetime') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <input class="date-time input_time-day" type="datetime-local"
                                            name="dateRequestForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.dashboard.payment') }}*
                                    </label>
                                    <div class="col col-md-10">
                                        <div class="currency-unit-value form-item-ip">
                                            <div class="select_info mr-15">
                                                <select class="form_control select_form-currency-unit"
                                                    name="paymentAssetForm">
                                                    @foreach ($arrUnitPayment as $key => $value)
                                                        <option value="{{ $value }}"
                                                            @if (old('paymentAssetForm') == $value) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control form-control-value-cur"
                                                name="paymentAmountForm">
                                            <div class="note-pass d-flex align-items-center">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.dashboard.received_amount') }}*
                                    </label>
                                    <div class="col col-md-10">
                                        <div class="currency-unit-value form-item-ip">
                                            <div class="select_info mr-15">
                                                <select class="form_control select_form-currency-unit"
                                                    name="receivedAssetForm">
                                                    @foreach ($arrUnitReceived as $key => $value)
                                                        <option value="{{ $value }}"
                                                            @if (old('receivedAssetForm') == $value) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <input type="text" class="form-control form-control-value-cur"
                                                name="receivedAmountForm">
                                            <div class="note-pass d-flex align-items-center">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.network') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <div class="select_info">
                                            <select class="form_control select_form" name="networkForm">
                                                @php
                                                    use App\Enums\TransactionHistoryNetwork;
                                                @endphp
                                                <option value="{{ TransactionHistoryNetwork::ETH->value }}">
                                                    {{ __('common.usage_situtation.network_type.ETH') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::BNB->value }}">
                                                    {{ __('common.usage_situtation.network_type.BNB') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::Matic->value }}">
                                                    {{ __('common.usage_situtation.network_type.Matic') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::AVAX->value }}">
                                                    {{ __('common.usage_situtation.network_type.AVAX') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::FTM->value }}">
                                                    {{ __('common.usage_situtation.network_type.FTM') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::ARBITRUM_ETH->value }}">
                                                    {{ __('common.usage_situtation.network_type.ARBITRUM_ETH') }}
                                                </option>
                                                <option value="{{ TransactionHistoryNetwork::SOL->value }}">
                                                    {{ __('common.usage_situtation.network_type.SOL') }}
                                                </option>
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.request_method') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <div class="select_info">
                                            <select class="form_control select_form" name="requestMethodForm">
                                                @php
                                                    use App\Enums\TransactionHistoryRequesMethod;
                                                @endphp
                                                <option value="{{ TransactionHistoryRequesMethod::END->value }}">
                                                    {{ __('common.usage_situtation.end') }}
                                                </option>
                                                <option value="{{ TransactionHistoryRequesMethod::MERCHANT->value }}">
                                                    {{ __('common.setting.profile.store') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.payment_status') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <div class="select_info">
                                            <select class="form_control select_form" name="paymentStatusForm">
                                                @php
                                                    use App\Enums\TransactionHistoryPaymentStatus;
                                                @endphp
                                                <option
                                                    value="{{ TransactionHistoryPaymentStatus::OUTSTANDING->value }}">
                                                    {{ __('common.usage_situtation.unsettled') }}
                                                </option>
                                                <option value="{{ TransactionHistoryPaymentStatus::SUCCESS->value }}">
                                                    {{ __('common.usage_situtation.completion') }}
                                                </option>
                                                <option value="{{ TransactionHistoryPaymentStatus::FAIL->value }}">
                                                    {{ __('common.usage_situtation.failure') }}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.payment_datetime') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <input class="date-time input_time-day" type="datetime-local"
                                            name="paymentSuccessDatetimeForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.hash') }}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="hashForm">
                                    </div>
                                </div>


                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-2 col-form-label label-custom"></label>
                                    <div class="col col-md-10 ">
                                        <div class="button-action">
                                            <div class="btn-back-with500">
                                                <button type="submit"
                                                    class="btn btn-primary ">{{ __('common.button.submit') }}</button>
                                                <button data-bs-dismiss="modal" type="button" class="btn form-close"
                                                   >{{ __('common.button.back') }}
                                                </button>
                                            </div>

                                            <button onclick="showModalDelete()" type="button"
                                                class="btn btn-delete-detail">
                                                {{ __('common.button.delete') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
