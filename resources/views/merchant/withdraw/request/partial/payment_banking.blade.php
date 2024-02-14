<div class="form-group row form-item ">
    <p class="col payment_information">
        {{ __('merchant.withdraw.payment_info_banking') }}
    </p>
</div>
<div class="form-group row form-item  ">
    <label for="" class="col col-md-2 col-form-label label-custom">
        {{ __('merchant.withdraw.finance_name') }}*
    </label>
    <div class="col col-md-10 form-edit-input">
        <div class="form-two-input-withdraw">
            <input value="{{ $fiatAccount->financial_institution_name }}"
                   type="text"
                   class="form-control form-control-w311"
                   disabled>

            <div class="form-input-mini-item form-input-payment-info">
                <label for="" class="col-form-label label-custom">
                    {{ __('merchant.withdraw.bank_code') }}*
                </label>
                <input value="{{ $fiatAccount->bank_code }}"
                       type="text"
                       class="form-control form-control-Wmini form-control-w62"
                       disabled>
            </div>
        </div>
    </div>
</div>

<div class="form-group row form-item  ">
    <label for="" class="col col-md-2 col-form-label label-custom">
        {{ __('merchant.withdraw.branch') }}*
    </label>
    <div class="col col-md-10 form-edit-input">
        <div class="form-two-input-withdraw">
            <input value="{{ $fiatAccount->branch_name }}"
                   type="text"
                   class="form-control form-control-w311"
                   disabled>
            <div class="form-input-mini-item form-input-payment-info">
                <label for="" class="col-form-label label-custom">
                    {{ __('merchant.withdraw.branch_code') }}*
                </label>
                <input value="{{ $fiatAccount->branch_code }}"
                       type="text"
                       class="form-control form-control-Wmini form-control-w62"
                       disabled>
            </div>
        </div>
    </div>
</div>

<div class="form-group row form-item  ">
    <label for="" class="col col-md-2 col-form-label label-custom">
        {{ __('merchant.withdraw.account_type') }}*
    </label>
    <div class="col col-md-10 form-edit-input">
        <div class="form-two-input-withdraw">
            <input value="{{ $fiatAccount->bank_account_type }}"
                   type="text"
                   class="form-control form-control-w311"
                   disabled>
            <div class="form-input-mini-item form-input-payment-info">
                <label for="" class="col-form-label label-custom">
                    {{ __('merchant.withdraw.account_number') }}*
                </label>
                <input value="{{ $fiatAccount->bank_account_number }}"
                       type="text"
                       class="form-control form-control-Wmini form-control-w94"
                       disabled>
            </div>
        </div>
    </div>
</div>

<div class="form-group row form-item ">
    <label for="" class="col col-md-2 col-form-label label-custom">
        {{ __('merchant.withdraw.account_holder') }}*
    </label>
    <div class="col col-md-10">
        <input value="{{ $fiatAccount->bank_account_holder }}"
               type="text"
               class="form-control"
               disabled>
    </div>
</div>
