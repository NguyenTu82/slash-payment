<!-- modal 受付金額情報確認-->
<div class="popup-table popup-table-information-details">
    <div
        class="modal modal-popup-table fade"
        id="received-info-modal"
        tabindex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
    >
        <div
            class="modal-dialog modal-dialog-centered"
        >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('admin_epay.report.receive_info_detail') }}</h5>
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
                                                <th><div class="center-table">{{ __('admin_epay.report.transaction_number') }}</div></th>
                                                <th><div class="center-table">{{ __('admin_epay.report.transaction_amount') }}</div></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($receive_info as $item)
                                            @php
                                                $item = json_decode($item, true);
                                            @endphp
                                            @foreach($item as $data)
                                                <tr>
                                                    <td><div class="center-table">@if($data['asset'] != 'total') {{ $data['asset'] }} @else {{ __('admin_epay.report.total') }} @endif </div></td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['count'] }}
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="center-table text-number-font text-right-number">
                                                            {{ $data['total'] }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
