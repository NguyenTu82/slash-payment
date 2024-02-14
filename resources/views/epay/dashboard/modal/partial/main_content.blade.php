@php
    // dd($slashPaymentAmountInfo);
@endphp

<div class="summary-data content-info-data">
    <div class="col title-data">
        <h6 class="title">
            {{ __('common.dashboard.transaction_summary_data') }}
        </h6>
    </div>

    {{-- Number of Transactions Box --}}
    <div class="col item-data-transcation content-data-withdraw bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.total_number_of_transactions') }}
            </p>
        </div>
        <p class="total-number">
            {{ formatNumberInt($totalTransactions ?? 0) }}
        </p>
    </div>

    {{-- Payment amount Box --}}
    <div class="col item-transcation">
        <div class="name-icon-data item-data-transcation bdBottomDashed">
            <p class="name-data">{{ __('common.dashboard.paid') }}</p>
        </div>
        <ul class="list-data-trans">
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">USD</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['USD'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">CAD</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['CAD'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">JPY</p>
                    <p class="value-trans">
                        {{ formatNumberInt($slashPaymentAmountInfo['JPY'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans ">
                    <p class="name-trans">IDR</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['IDR'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">EUR</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['EUR'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">PHP</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['PHP'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">AED</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['AED'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">INR</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['INR'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">SGD</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['SGD'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">KRW</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['KRW'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans ">
                <div class="item-trans">
                    <p class="name-trans">HKD</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashPaymentAmountInfo['HKD'] ?? 0) }}
                    </p>
                </div>
            </li>
        </ul>
    </div>

    {{-- Payment received Box --}}
    <div class="col item-transcation">
        <div class="name-icon-data item-data-transcation bdBottomSolid">
            <p class="name-data">
                {{ __('common.dashboard.receipt_amount') }}</p>
        </div>
        <ul class="list-data-trans">
            <li class="two-item-trans ">
                <div class="item-trans">
                    <p class="name-trans">USDT</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashReceiveAmountInfo['USDT'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">DAI</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashReceiveAmountInfo['DAI'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans ">
                <div class="item-trans">
                    <p class="name-trans">USDC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashReceiveAmountInfo['USDC'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans ">
                    <p class="name-trans">JPYC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($slashReceiveAmountInfo['JPYC'] ?? 0) }}
                    </p>
                </div>
            </li>
        </ul>
    </div>

    {{-- Payment unpaid Box --}}
    <div class="col data-unpaid-amount bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.trans_unpaid_amount_detail') }}</p>
        </div>
        <p class="total-number">
            {{ formatNumberDecimal($transUnpaidAmount) }}
        </p>
    </div>
</div>

<div class="summary-data content-info-data">
    <div class="col title-data">
        <h6 class="title">
            {{ __('common.dashboard.payment_summary_data') }}</h6>
    </div>

    {{-- Number of payment success Box --}}
    <div class="col item-data-transcation content-data-withdraw bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.total_number_of_withdrawals') }}
            </p>
        </div>
        <p class="total-number">
            {{ formatNumberDecimal($withdrawSuccessCount ?? 0) }}
        </p>
    </div>

    {{--  Withdrawal amount Box --}}
    <div class="col item-transcation">
        <div class="name-icon-data item-data-transcation bdBottomDashed">
            <p class="name-data">
                {{ __('common.dashboard.total_payment_amounts') }}</p>
        </div>
        <ul class="list-data-trans">
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">JPY</p>
                    <p class="value-trans">
                        {{-- Yen by BANK --}}
                        {{ formatNumberDecimal($withdrawSuccessByYenAmounInfo['banking'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">DAI</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoAmounInfo['DAI'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">USDT</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoAmounInfo['USDT'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans ">
                    <p class="name-trans">JPYC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoAmounInfo['JPYC'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">USDC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoAmounInfo['USDC'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">
                        {{ __('common.dashboard.cash_yen') }}
                    </p>
                    <p class="value-trans">
                        {{-- Yen by CASH --}}
                        {{ formatNumberDecimal($withdrawSuccessByYenAmounInfo['cash'] ?? 0) }}
                    </p>
                </div>
            </li>
        </ul>
    </div>

    {{--  Withdrawal fee Box --}}
    <div class="col item-transcation">
        <div class="name-icon-data item-data-transcation bdBottomSolid">
            <p class="name-data">
                {{ __('common.dashboard.withdrawal_fee') }}</p>
        </div>
        <ul class="list-data-trans">
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">JPY</p>
                    <p class="value-trans">
                        {{-- Yen by BANK --}}
                        {{ formatNumberInt($withdrawSuccessByYenFeeInfo['banking'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">DAI</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoFeeInfo['DAI'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">USDT</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoFeeInfo['USDT'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans ">
                    <p class="name-trans">JPYC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoFeeInfo['JPYC'] ?? 0) }}
                    </p>
                </div>
            </li>
            <li class="two-item-trans bdBottomDashed">
                <div class="item-trans">
                    <p class="name-trans">USDC</p>
                    <p class="value-trans">
                        {{ formatNumberDecimal($withdrawSuccessByCryptoFeeInfo['USDC'] ?? 0) }}
                    </p>
                </div>
                <div class="item-trans">
                    <p class="name-trans">
                        {{ __('common.dashboard.cash_yen') }}</p>
                    <p class="value-trans">
                        {{-- Yen by CASH --}}
                        {{ formatNumberDecimal($withdrawSuccessByYenFeeInfo['cash'] ?? 0) }}
                    </p>
                </div>
            </li>
        </ul>
    </div>

    {{--   Number of new merchants Box --}}
    <div class="col data-unpaid-amount bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.number_of_new_merchants') }}</p>
        </div>
        <p class="total-number">
            {{ formatNumberInt($totalMerchantStores ?? 0) }}
        </p>
    </div>

    {{--  Number of New Affiliates Box --}}
    <div class="col data-unpaid-amount bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.number_of_AFs_detail') }}</p>
        </div>
        <p class="total-number"> - </p>
    </div>

    {{-- Number of merchant Cancellations Box --}}
    <div class="col data-unpaid-amount bdBottomSolid">
        <div class="name-icon-data">
            <p class="name-data">
                {{ __('common.dashboard.number_of_merchant_cancellations') }}
            </p>
        </div>
        <p class="total-number">
            {{ formatNumberInt($totalStoresCancel ?? 0) }}
        </p>
    </div>
</div>
