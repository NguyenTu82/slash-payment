<?php

namespace App\Form\Merchant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Enums\WithdrawMethod;

class CreateWithdrawRequestForm
{
    /**
     * validate
     *
     * @param \Illuminate\Http\Request $request
     */
    public function validate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merchant_store_id' => [
                'bail',
                'required',
            ],
            'withdraw_method' => [
                'bail',
                'required',
            ],
            'amount' => [
                'bail',
                'required',
            ],
            'company_member_code' => [
                'nullable',
                'string',
            ],
            'asset' => [
                'nullable',
                'string',
            ],
        ]);

        $validator->sometimes([
            'bank_code',
            'financial_institution_name',
            'branch_code',
            'branch_name',
            'bank_account_type',
            'bank_account_number',
            'bank_account_holder',
        ], 'required', function ($input) {
            return $input->withdraw_method == WithdrawMethod::BANKING->value;
        });

        $validator->sometimes(['wallet_address', 'network'], 'required', function ($input) {
            return $input->withdraw_method == WithdrawMethod::CRYPTO->value;
        });

        return $validator->validate();
    }
}
