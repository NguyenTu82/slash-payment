<div class="popup-PayeeInfomation popup-FormData-edit">
    <!-- Modal -->
    <div class="modal modal-popup-DataForm fade background-popup" id="payment-modal" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row m-0">
                        <div class="col-12 p-0">
                            <div class="account bg-white ">
                                <div class="form-detail form-dropdown-input">
                                    <h6 class="title-detail-noti">
                                        {{ __('admin_epay.merchant.fiat_payment.title') }}
                                    </h6>
                                    <div class="form-group form-item info-detail-popup info-detail-popup-transfer">
                                        <div class="transfer-two-input-data">
                                            <label for="" class="col-form-label label-custom label-custom-detail ">
                                                {{ __('admin_epay.merchant.fiat_payment.financial_institution_name') }}
                                            </label>
                                            <input value="{{ $bankingInfo->financial_institution_name ? $bankingInfo->financial_institution_name : '' }}"
                                                   type="text"
                                                   class="form-control form-w300"
                                                   readonly>
                                        </div>

                                        <div class="transfer-two-input-data transfer-two-input">
                                            <label for="" class="col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_code_short') }}
                                            </label>
                                            <div class="info-input">
                                                <input value="{{ $bankingInfo->bank_code ? $bankingInfo->bank_code : '' }}"
                                                       type="text"
                                                       class="form-control form-w62"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group form-item info-detail-popup info-detail-popup-transfer">
                                        <div class="transfer-two-input-data">
                                            <label for="" class="col-form-label label-custom label-custom-detail ">
                                                {{ __('admin_epay.merchant.fiat_payment.branch_name') }}
                                            </label>
                                            <input value="{{ $bankingInfo->branch_name ? $bankingInfo->branch_name : '' }}"
                                                   type="text"
                                                   class="form-control form-w300"
                                                   readonly>
                                        </div>

                                        <div class="transfer-two-input-data transfer-two-input">
                                            <label for="" class="col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.branch_code') }}
                                            </label>
                                            <div class="info-input">
                                                <input value="{{ $bankingInfo->branch_code ? $bankingInfo->branch_code : '' }}"
                                                       type="text"
                                                       class="form-control form-w62"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                        use App\Enums\BankAccountType;
                                    @endphp
                                    <div class="form-group form-item info-detail-popup info-detail-popup-transfer">
                                        <div class="transfer-two-input-data">
                                            <label for="" class="col-form-label label-custom label-custom-detail ">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_account_type') }}
                                            </label>
                                            @if($bankingInfo->bank_account_type == BankAccountType::USUALLY->value )
                                                <input value="{{ __('merchant.withdraw.bank_account_type.usually') }}"
                                                       type="text"
                                                       class="form-control form-w300"
                                                       readonly>
                                            @elseif($bankingInfo->bank_account_type == BankAccountType::REGULAR->value)
                                                <input value="{{ __('merchant.withdraw.bank_account_type.regular') }}"
                                                       type="text"
                                                       class="form-control form-w300"
                                                       readonly>
                                            @elseif($bankingInfo->bank_account_type == BankAccountType::CURRENT->value)
                                                <input value="{{ __('merchant.withdraw.bank_account_type.current') }}"
                                                       type="text"
                                                       class="form-control form-w300"
                                                       readonly>
                                            @endif
                                        </div>

                                        <div class="transfer-two-input-data transfer-two-input">
                                            <label for="" class="col-form-label label-custom">
                                                {{ __('admin_epay.merchant.fiat_payment.bank_account_number') }}
                                            </label>
                                            <div class="info-input">
                                                <input value="{{ $bankingInfo->bank_account_number ? $bankingInfo->bank_account_number : '' }}"
                                                       type="text"
                                                       class="form-control form-w100"
                                                       readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group form-item info-detail-popup">
                                        <label for="" class="col-form-label label-custom">
                                            {{ __('admin_epay.merchant.fiat_payment.bank_account_holder') }}
                                        </label>
                                        <div class="info-input">
                                            <input value="{{ $bankingInfo->bank_account_holder ? $bankingInfo->bank_account_holder : '' }}"
                                                   type="text"
                                                   class="form-control"
                                                   readonly>
                                        </div>
                                    </div>

                                    <div class="form-group form-item info-detail-popup">
                                        <div class="button-action button-action-detail">
                                            <button
                                                data-toggle="modal"
                                                data-dismiss="payment-modal"
                                                data-target="#payment-modal"
                                                type="button"
                                                class="btn form-close"
                                            >
                                                {{ __('common.close') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
