<!-- Modal -->
<div class="modal modal-popup-DataForm fade" id="showDataFormDetail" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> {{ __('common.usage_situtation.usage_details')}} </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row ">
                    <div class="col-12">
                        <div class="account bg-white ">
                            <form class="form-detail">
                                <div class="form-group row form-item">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.trans_ID')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="transIdForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.request_datetime')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="dateRequestFormDetail">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.dashboard.payment')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="paymentForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.dashboard.received_amount')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="receivedForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.network')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="networkForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.request_method')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="requestMethodForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.payment_status')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="paymentStatusForm">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.payment_datetime')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="paymentSuccessDatetimeFormDetail">
                                    </div>
                                </div>
                                <div class="form-group row form-item ">
                                    <label for="" class="col col-md-2 col-form-label label-custom">
                                        {{ __('common.usage_situtation.hash')}}
                                    </label>
                                    <div class="col col-md-10">
                                        <input type="text" class="form-control" disabled
                                            name="hashForm">
                                    </div>
                                </div>

                                <div class="form-group row form-item">
                                    <label for="" class="col-sm-2 col-form-label label-custom"></label>
                                    <div class="col col-md-10">
                                        <div class="button-action pl-0">
                                            <div class="btn-back-with500 d-flex justify-content-between">
                                                <div class="btn-back-with250">
                                                    <button onclick="editUsageSituation()" type="button"
                                                        class="btn btn-primary form-save d-none">{{ __('common.button.edit') }}</button>
                                                </div>
                                                <div class="btn-back-with250">
                                                    <button data-bs-dismiss="modal" type="button"
                                                        class="btn form-close"> {{ __('common.button.back') }}
                                                    </button>
                                                </div>
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
