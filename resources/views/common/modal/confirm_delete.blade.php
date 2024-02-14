<div class="popup-confirm">
    <div class="modal modal-popup-confirm fade" id="{{ $id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __($title) }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12 content-change-pass">
                            <img src="/dashboard/img/question.svg" alt="">
                            <p class="title-change-pass">{{ __($description) }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ !empty($url) ? $url : '#' }}"><button type="button" class="btn btn-delete"
                            data-toggle="modal" data-target="#successConfirm"
                            id="delete-btn">{{ __('common.button.delete') }}</button></a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        data-dismiss="modal">{{ __('common.button.cancel') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
