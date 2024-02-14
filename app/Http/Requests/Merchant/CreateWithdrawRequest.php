<?php

namespace App\Http\Requests\Merchant;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\WithdrawMethod;

class CreateWithdrawRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
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
            'wallet_address' => [
                'required_if:withdraw_method,' . WithdrawMethod::CRYPTO->value,
            ],
            'network' => [
                'required_if:withdraw_method,' . WithdrawMethod::CRYPTO->value,
            ],
            'bank_code' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'financial_institution_name' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'branch_code' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'branch_name' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'bank_account_type' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'bank_account_number' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
            'bank_account_holder' => [
                'required_if:withdraw_method,' . WithdrawMethod::BANKING->value,
            ],
        ];
    }
}