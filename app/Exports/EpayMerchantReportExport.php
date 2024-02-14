<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Collection;

class EpayMerchantReportExport implements WithHeadings, FromCollection, WithMapping, WithCustomCsvSettings
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
            __('admin_epay.report.report_code'),
            __('admin_epay.report.merchant_id'),
            __('admin_epay.report.merchant_name'),
            __('admin_epay.report.period'),
            __('admin_epay.report.issue_date'),
            __('admin_epay.report.status'),
            __('admin_epay.report.transaction_number'),
            __('admin_epay.report.transaction_amount') . "\n" . __('admin_epay.report.only_yen'),
            __('admin_epay.report.planned_withdrawal_amount') . "\n" . __('admin_epay.report.only_yen'),
            __('admin_epay.report.withdraw_fee') . "\n" . __('admin_epay.report.only_yen'),
            __('admin_epay.report.email'),
        ];
    }

    public function map($row): array
    {
        $periodFrom = formatDateHour(object_get($row, 'period_from'));
        $periodTo = formatDateHour(object_get($row, 'period_to'));
        $period = $periodFrom . ' ~ ' . $periodTo;
        $status = getReportStatus(object_get($row, 'status'));
        $statusLabel = $status['label'];
        $merchantCode = "\t" . formatAccountId(object_get($row, 'merchant_code'));

        $payment = object_get($row, 'payment_amount');
        $data = json_decode($payment, true);
        $paymentAmount = $data ? (string) $data[1]['count'] : '0';
        $withdraw = object_get($row, 'withdraw_amount');
        $data = json_decode($withdraw, true);
        $withdrawAmount = $data ? (string) $data[0]['withdrawn_amount'] : 0;
        $plannedAmount = $data ? (string) $data[0]['planned_amount'] : 0;
        $withdrawalFee = $data ? (string) $data[0]['withdrawal_fee'] : 0;

        return [
            object_get($row, 'report_code'),
            $merchantCode,
            object_get($row, 'merchant_store_name'),
            $period,
            formatDateHour(object_get($row, 'issue_date')),
            $statusLabel,
            $paymentAmount,
            $withdrawAmount,
            $plannedAmount,
            $withdrawalFee,
            object_get($row, 'send_email'),
        ];
    }

    public function getCsvSettings(): array
    {
        return [
            'use_bom' => true
        ];
    }
}
