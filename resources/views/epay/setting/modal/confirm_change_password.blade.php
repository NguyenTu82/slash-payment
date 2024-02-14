<div class="modal fade common-modal common-modal-confirm" id="confirm-change-password-modal" aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="title">
                    {{ __('common.setting.profile.change_pw_title') }}
                </h1>

                <img src="/dashboard/img/question.svg"
                     class="rounded mx-auto d-block icon" alt="...">

                <p class="desc">{{ __('common.setting.profile.change_pw_confirm') }}</p>

                <div class="modalFooter btn-confirm">
                    <button onclick="changePassword(this)" type="button" class="btn btn-primary btn-yes"
                           >{{ __('common.button.change') }}</button>
                    <button type="button" class="btn btn-secondary btn-no" data-bs-dismiss="modal">
                        {{ __('common.button.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
