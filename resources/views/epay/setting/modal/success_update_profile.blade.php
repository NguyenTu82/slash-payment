{{-- modal result --}}
<div class="modal fade common-modal common-modal-confirm" id="success-update-profile-modal" aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body confirmm">
                <h1 class="modal-title title">
                    {{ __('common.setting.profile.update_profile_title_done') }}
                </h1>

                <img src="/dashboard/img/checked.svg"
                     class="rounded mx-auto d-block icon" alt="...">

                <p class="desc">{{ __('common.setting.profile.update_profile_successful') }}</p>

                <div class="modalFooter btn-confirm">
                    <button type="button" class="btn btn-secondary btn-yes" data-bs-dismiss="modal">
                        {{ __('common.button.back') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
