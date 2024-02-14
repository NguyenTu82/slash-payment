{{-- modal result --}}
<div class="modal fade common-modal common-modal-confirm {{!empty($class) ? $class :''}}" id="error-modal" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body confirmm">
                <h1 class="modal-title title" id="">
                    {{ __($title) }}
                </h1>

                <img src="/dashboard/img/checked.svg"
                     class="rounded mx-auto d-block icon" alt="...">
                <div class="note-pass text-center" id="merchant_select-error">
                </div>
                <div class="note-pass text-center" id="create_issue_date_from-error">
                </div>
                <div class="note-pass text-center" id="create_issue_date_to-error">
                </div>
                <div class="modalFooter btn-confirm">
                    <button type="button" class="btn btn-secondary btn-yes" data-bs-dismiss="modal" data-dismiss="modal" id="return-btn">
                        {{ __($submit_btn) }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
