<div class="modal fade common-modal common-modal-form" id="change-password-modal-common" aria-hidden="true"
     aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <h3 class="title">
                    {{ __('auth.common.change_password.change_password_tittle') }}
                </h3>
                <!-- form -->
                <form action="" method="POST" id="change-password-form-common" class="">
                    @csrf
                    <input type="hidden"
                    value="{{!empty($id) ? $id : ''}}" name="id">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="label-custom"
                                   for="input-name">{{ __('auth.common.change_password.new_pass') }}</label>
                            <input type="password" name="password"
                                   class="form-control"
                                   id="password" value="">
                            <p class="input-description">{{ __('auth.common.change_password.new_pass_validate') }}</p>
                        </div>

                        <div class="form-group">
                            <label class="label-custom"
                                   for="inputEmail">{{ __('auth.common.forgot_password.pass_confirm') }}</label>
                            <input type="password" name="password_confirmation"
                                   class="form-control"
                                   id="password-confirmation" value="">
                            <p class="input-description">{{ __('admin_epay.setting.account_management.confirm_password_description') }}</p>
                        </div>
                    </div>
                </form>

                <div class="modalFooter btn-confirm">
                    <button onclick="confirmChangePassword(this)" type="button" class="btn btn-primary btn-yes"
                           >
                        <span>{{ __('auth.common.change_password.save_button') }}</span>
                    </button>
                    <button type="button" class="btn btn-secondary btn-no"
                            data-bs-dismiss="modal">
                        <span>{{ __('auth.common.change_password.close_button') }}</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
