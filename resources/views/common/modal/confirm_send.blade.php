<div class="modal fade common-modal common-modal-confirm {{!empty($class) ? $class :''}}" id="confirm-send-modal" aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{route('admin_epay.report.send')}}" method="post">
            @csrf
            <div class="modal-content">
                <div class="modal-body">
                    <h1 class="title" id="">
                        {{ $title }}
                    </h1>
                    <input type="hidden" name="type" value=""/>
                    <input type="hidden" name="report_id" value=""/>
                    <img src="/dashboard/img/question.svg"
                         class="rounded mx-auto d-block icon" alt="...">

                    <p class="desc"> {{__('admin_epay.report.send_mail_modal_description_before')}} <span id="email_span_report"></span> {{__('admin_epay.report.send_mail_modal_description_after')}}</p>

                    <div class="modalFooter btn-confirm">
                        <button type="submit" class="btn btn-primary btn-yes {{!empty($class) ? $class :''}}-submit"
                                id="send-email"
                        >{{ __($submit_btn) }}</button>
                        <button type="button" class="btn btn-secondary btn-no" data-bs-dismiss="modal">
                            {{ __('common.button.cancel') }}
                        </button>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
