<div class="modal fade common-modal common-modal-confirm {{!empty($class) ? $class :''}}" id="cancel-modal" aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="title">
                    {{ __($title) }}
                </h1>

                <img src="/dashboard/img/question.svg"
                     class="rounded mx-auto d-block icon" alt="...">

                <p class="desc">{!! nl2br(e(__($description))) !!}</p>

                <div class="modalFooter btn-confirm">
                    <button type="button" class="btn btn-primary btn-yes {{!empty($class) ? $class :''}}-submit"
                            id="cancel">{{ __($submit_btn) }}</button>
                    <button type="button" class="btn btn-secondary btn-no" data-bs-dismiss="modal">
                        {{ __('common.button.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
