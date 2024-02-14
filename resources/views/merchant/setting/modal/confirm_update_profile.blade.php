<div class="popup-confirm">
    <div class="modal modal-popup-confirm fade"  id="confirm-update-profile-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('common.setting.profile.update_profile_title') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 content-change-pass">
                            <img src="/dashboard/img/question.svg"
                                 class="rounded mx-auto d-block icon" alt="...">

                            <p class="title-change-pass">{{ __('common.setting.profile.update_profile_confirm') }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button onclick="updateProfile(event)" type="button" class="btn btn-primary btn-yes"
                           >{{ __('common.button.submit') }}</button>
                    <button type="button" class="btn btn-secondary btn-no" data-bs-dismiss="modal">
                        {{ __('common.button.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
