<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class WithdrawHistoryExport implements WithHeadings, FromCollection, WithMapping, WithCustomCsvSettings
{
    use Exportable;

    protected Collection $collection;

    public function __construct(Collection $collection)
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
            __('common.withdraw_management.transaction_id'),
            __('common.withdraw_management.merchant_store_id'),
            __('common.withdraw_management.merchant_store_name'),
            __('common.withdraw_management.withdrawal_amount'),
            __('common.withdraw_management.request_date'),
            __('common.withdraw_management.approve_time'),
            __('common.withdraw_management.withdraw_request_method'),
            __('common.withdraw_management.withdraw_status'),
        ];
    }

    public function map($row): array
    {
        return [
            $row->id,
            formatAccountId($row->merchant_code),
            $row->merchant_store_name,
            $row->asset.' '.formatNumberDecimal($row->amount, 3),
            formatDateHour($row->created_at),
            formatDateHour($row->approve_datetime),
            getWithdrawRequestMethod($row->withdraw_request_method),
            getWithdrawStatus($row->withdraw_status)['label'],
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
