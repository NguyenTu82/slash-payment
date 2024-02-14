<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Enums\MerchantStoreStatus;
use App\Enums\MerchantStorePaymentCycle;
use App\Enums\MerchantPaymentType;
use Illuminate\Support\Collection;

class MerchantStoreExport implements FromCollection, WithMapping, WithHeadings, WithCustomCsvSettings
{
    use Exportable;

    protected Collection $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    public function collection(): Collection
    {
        return $this->collection;
    }

    public function headings(): array
    {
        return [
            __('admin_epay.merchant.info.id'),
            __('admin_epay.merchant.info.name'),
            __('admin_epay.merchant.info.group'),
            __('admin_epay.merchant.info.status'),
            __('admin_epay.merchant.payment_info.contract_interest_rate'),
            __('admin_epay.merchant.common.account_balance'),
            __('admin_epay.merchant.common.paid_balance'),
            __('admin_epay.merchant.payment_info.payment_currency'),
            __('admin_epay.merchant.payment_info.payment_cycle'),
            __('admin_epay.merchant.info.register_email'),
            __('admin_epay.merchant.affiliate_info.id'),
        ];
    }

    public function map($row): array
    {
        $merchantCode = "\t" . formatAccountId(object_get($row, 'merchant_code'));

        return [
            $merchantCode,
            object_get($row, 'name'),
            !empty($row->groupParentStore->childrenStore) ? $row->groupParentStore->childrenStore->pluck('name')->implode(',') : '',
            $this->getStatus($row->status),
            $row->contract_interest_rate ? object_get($row, 'contract_interest_rate') . '%' : '',
            object_get($row, 'account_balance'),
            object_get($row, 'paid_balance'),
            $this->getPaymentCurrency($row->withdraw_method),
            $this->getPaymentCycle($row->payment_cycle),
            $row->merchantOwner ? $row->merchantOwner->email : '',
            object_get($row, 'affiliate_id'),
        ];
    }

    public function getStatus($status): string
    {
        return match ($status) {
            MerchantStoreStatus::TEMPORARILY_REGISTERED->value => __('common.status.stores.temporarily_registered'),
            MerchantStoreStatus::UNDER_REVIEW->value => __('common.status.stores.under_review'),
            MerchantStoreStatus::IN_USE->value => __('common.status.stores.in_use'),
            MerchantStoreStatus::SUSPEND->value => __('common.status.stores.stopped'),
            MerchantStoreStatus::WITHDRAWAL->value => __('common.status.stores.withdrawal'),
            MerchantStoreStatus::FORCED_WITHDRAWAL->value => __('common.status.stores.forced_withdrawal'),
            default => '',
        };
    }

    public function getPaymentCycle($payment_cycle): string
    {
        return match ($payment_cycle) {
            MerchantStorePaymentCycle::WEEKEND->value => __('common.merchant_stores.payment_cycle.weekend_payment'),
            MerchantStorePaymentCycle::MONTH_END->value => __('common.merchant_stores.payment_cycle.month_end_payment'),
            default => '',
        };
    }

    public function getPaymentCurrency($payment_currency): string {
        return match($payment_currency) {
            MerchantPaymentType::FIAT->value => __('common.merchant_stores.payment_currency.fiat'),
            MerchantPaymentType::CRYPTO->value => __('common.merchant_stores.payment_currency.crypto'),
            MerchantPaymentType::CASH->value => __('common.merchant_stores.payment_currency.cash'),
            default => '',
        };
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
