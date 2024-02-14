<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Enums\TransactionHistoryPaymentStatus;
use App\Enums\TransactionHistoryRequesMethod;
use App\Enums\TransactionHistoryNetwork;
use Illuminate\Support\Collection;

class TransactionHistoryExport implements FromCollection, WithMapping, WithHeadings, WithCustomCsvSettings
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
            __('common.usage_situtation.trans_ID'),
            __('common.usage_situtation.request_datetime'),
            __('common.dashboard.payment'),
            __('common.dashboard.received_amount'),
            __('common.usage_situtation.network'),
            __('common.usage_situtation.request_method'),
            __('common.usage_situtation.payment_status'),
            __('common.usage_situtation.payment_datetime'),
            __('common.usage_situtation.hash'),
        ];
    }

    public function map($row): array
    {
        return [
            object_get($row, 'id'),
            Carbon::parse(object_get($row, 'transaction_date'))->format(getColumnTableOfDatetime()),
            $row->payment_asset.' '. object_get($row, 'payment_amount'),
            $row->received_asset.' '.object_get($row, 'received_amount'),
            $this->getNetwork($row->network),
            $this->getRequestMethod($row->request_method),
            $this->getPaymentStatus($row->payment_status),
            Carbon::parse(object_get($row, 'payment_success_datetime'))->format(getColumnTableOfDatetime()),
            object_get($row, 'hash'),
        ];
    }

    public function getRequestMethod($request_method): string
    {
        return match ($request_method) {
            TransactionHistoryRequesMethod::END->value => __('common.usage_situtation.end'),
            TransactionHistoryRequesMethod::MERCHANT->value => __('common.setting.profile.store'),
            default => "",
        };
    }

    public function getPaymentStatus($payment_status): string
    {
        return match ($payment_status) {
            TransactionHistoryPaymentStatus::OUTSTANDING->value => __('common.usage_situtation.unsettled'),
            TransactionHistoryPaymentStatus::SUCCESS->value => __('common.usage_situtation.completion'),
            TransactionHistoryPaymentStatus::FAIL->value => __('common.usage_situtation.failure'),
            default => "",
        };
    }

    public function getNetwork($network): string
    {
        return match ($network) {
            TransactionHistoryNetwork::ETH->value => __('common.usage_situtation.network_type.ETH'),
            TransactionHistoryNetwork::BNB->value => __('common.usage_situtation.network_type.BNB'),
            TransactionHistoryNetwork::Matic->value => __('common.usage_situtation.network_type.Matic'),
            TransactionHistoryNetwork::AVAX->value => __('common.usage_situtation.network_type.AVAX'),
            TransactionHistoryNetwork::FTM->value => __('common.usage_situtation.network_type.FTM'),
            TransactionHistoryNetwork::ARBITRUM_ETH->value => __('common.usage_situtation.network_type.ARBITRUM_ETH'),
            TransactionHistoryNetwork::SOL->value => __('common.usage_situtation.network_type.SOL'),
            default => "",
        };
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
