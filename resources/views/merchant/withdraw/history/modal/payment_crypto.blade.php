<div class="popup-PayeeInfomation popup-FormData-edit">
    <div class="modal modal-popup-DataForm fade background-popup" id="crypto-modal" tabindex="-1"
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row m-0">
                        <div class="col-12 p-0">
                            <div class="account bg-white ">
                                <div class="form-detail form-dropdown-input">
                                    <h6 class="title-detail-noti">
                                        {{ __('merchant.withdraw.payment_crypto.title') }}
                                    </h6>
                                    <div class="form-group form-item info-detail-popup">
                                        <label for="" class="col-form-label label-custom minw-160">
                                            {{ __('merchant.withdraw.payment_crypto.network') }}
                                        </label>
                                        <div class="info-input">
                                            @if ($withdraw->crypto_info && $withdraw->crypto_info['network'] == 1)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Ethereum（ETH）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 2)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('BNB Chain（BNB）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 3)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Polygon（Matic）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 4)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Avalanche C-Chain（AVAX）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 5)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Fantom（FTM）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 6)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Arbitrum One（ETH）') }}">
                                            @elseif($withdraw->crypto_info && $withdraw->crypto_info['network'] == 7)
                                                <input type="text" class="form-control form-w300" disabled
                                                    value="{{ __('Solana (SOL)') }}">
                                            @else
                                                <input type="text" class="form-control form-w300" disabled value="">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group form-item info-detail-popup">
                                        <label for="" class="col-form-label label-custom minw-160">
                                            {{ __('merchant.withdraw.payment_crypto.wallet_address') }}
                                        </label>
                                        <div class="info-input">
                                            <input value="{{ $withdraw->crypto_info['wallet_address'] ?? '' }}"
                                                type="text" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="form-group form-item info-detail-popup">
                                        <label for="" class="col-form-label label-custom minw-160">
                                            {{ __('merchant.withdraw.payment_crypto.note') }}
                                        </label>
                                        <div class="info-input">
                                            <textarea disabled class="form-control height-control" id="note" name="note" rows="4">{{ $withdraw->crypto_info['note_crypto'] ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group form-item info-detail-popup">
                                        <div class="button-action button-action-detail">
                                            <button data-toggle="modal" data-target="#crypto-modal" type="button"
                                                class="btn form-close">
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
