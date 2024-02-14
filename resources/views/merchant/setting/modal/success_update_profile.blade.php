<div class="popup-success">
    <div class="modal modal-success fade" id="success-update-profile-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('common.setting.profile.update_profile_title_done') }}
                    </h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 content-change-pass">
                            <img src="/dashboard/img/checked.svg"
                                 class="rounded mx-auto d-block icon" alt="...">

                            <p class="title-change-pass">
                                {{ __('common.setting.profile.update_profile_successful') }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-ok-success" data-bs-dismiss="modal">
                        {{ __('common.button.back') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
