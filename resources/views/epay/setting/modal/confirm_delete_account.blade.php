<form action="{{$url}}" method="POST">
    @csrf
    <input type="hidden" value="{{$id}}" name="id">
<div class="modal fade common-modal common-modal-confirm" id="confirm-delete-account-modal" aria-hidden="true"
    aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered popup-confirm">
        <div class="modal-content">
            <div class="modal-body">
                <h1 class="title">
                    {{ __('admin_epay.setting.modal.confirm_delete_account_title') }}
                </h1>

                <img src="/dashboard/img/question.svg" class="rounded mx-auto d-block icon" alt="...">

                <p class="desc"> {{ __('admin_epay.setting.modal.confirm_delete_account_content') }}
                </p>

                <div class="modalFooter btn-confirm">
                    <button type="submit" class="btn btn-delete"
                       >{{ __('common.button.delete') }}</button>
                    <button type="button" class="btn btn-secondary btn-no" data-bs-dismiss="modal">
                        {{ __('common.button.cancel') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
