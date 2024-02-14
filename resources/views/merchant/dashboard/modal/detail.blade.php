<div class="popup-aggregatedData">
    <div class="modal modal-popup-aggregatedData fade" id="dashboard-detail-modal" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('merchant.admin.dashboard_title') }} ＞
                        {{ __('common.dashboard.each_summary_data') }}</h5>
                    <button onclick="closeModal()" type="button" class="close" data-dismiss="modal"
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row infomation-time">
                        <div class="col-12 content-time">
                            <input
                                readonly
                                type="hidden"
                                id="date-detail-viewing-input"
                                name="name"
                                value="100">

                            <button type="button" class="btn" onclick="getDetailChange('pre')" id="view-detail-pre-btn">
                                <img src="{{ asset('dashboard/img/back.svg') }}" alt="">
                            </button>
                            <div class= "time-day-popup">
                                <p class="info-day" id="info-date-detail">2023年4月1日</p>
                                <p class="info-time" id="info-hour-detail">11:00</p>
                            </div>
                            <button type="button" class="btn" onclick="getDetailChange('next')" id="view-detail-next-btn">
                                <img src="{{ asset('dashboard/img/next.svg') }}" alt="">
                            </button>
                        </div>
                    </div>

                    <div class="row infomation-data-transaction" id="dashboard-detail-content-modal">

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
