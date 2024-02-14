<div class="popup-table">
    <div
        class="modal modal-popup-table fade"
        id="withdraw-info-modal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin_epay.report.withdraw_info_detail') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-data">
                                <div class="table-responsive p-0">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                        <tr>
                                            <th><div class="center-table">{{ __('admin_epay.report.unit') }}</div></th>
                                            <th>
                                                <div class="center-table">
                                                    <div class="info-yen">
                                                        <p>{{ __('admin_epay.report.withdrawable_amount') }}</p>
                                                        <p class="yen-unit">(A)</p>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="center-table">
                                                    <div class="info-yen">
                                                        <p>{{ __('admin_epay.report.withdrawn_amount') }}</p>
                                                        <p class="yen-unit">(B)</p>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="center-table">
                                                    <div class="info-yen">
                                                        <p>{{ __('admin_epay.report.withdraw_fee') }}</p>
                                                        <p class="yen-unit">(C)</p>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="center-table">
                                                    <div class="info-yen">
                                                        <p>{{ __('admin_epay.report.planned_withdrawal_amount') }}</p>
                                                        <p class="yen-unit">(A - B - C)</p>
                                                    </div>
                                                </div>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            use App\Enums\WithdrawAsset;
                                            use App\Enums\WithdrawMethod;
                                        @endphp
                                        @foreach ($withdraw_info as $item)
                                            @php
                                                $item = json_decode($item, true);
                                            @endphp
                                            @foreach($item as $data)
                                                <tr>
                                                    <td>
                                                        <div class="center-table">{{ $data['asset'] }}
                                                            @if((($report->merchantStore->withdraw_method === WithdrawMethod::CASH->value || $report->merchantStore->withdraw_method === WithdrawMethod::BANKING->value)
                                                                && $data['asset'] === WithdrawAsset::JPY->value) ) (*)
                                                            @elseif($report->merchantStore->withdraw_method === WithdrawMethod::CRYPTO->value && $data['asset'] === $crypto_asset) (*)
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['withdrawable_amount'] }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['withdrawn_amount'] }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['withdrawal_fee'] }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['planned_amount'] }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <p class="noti-table">{{ __('admin_epay.report.withdraw_modal_note') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">{{ __('common.button.back') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
