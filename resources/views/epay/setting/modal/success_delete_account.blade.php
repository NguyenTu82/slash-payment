<div class="modal fade common-modal common-modal-confirm" id="success-delete-account-modal" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body confirmm">
                <h1 class="modal-title title">
                    {{ __('admin_epay.setting.modal.delete_account_success_title') }}
                </h1>

                <img src="/dashboard/img/checked.svg" class="rounded mx-auto d-block icon" alt="...">

                <p class="desc"> {{ __('admin_epay.setting.modal.delete_account_success_content') }} </p>

                <div class="modalFooter btn-confirm">
                    <button type="button" class="btn btn-secondary btn-yes" data-dismiss="modal">
                        {{ __('common.button.back') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
