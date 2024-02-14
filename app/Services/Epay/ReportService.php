<?php

namespace App\Services\Epay;

use App\Enums\EpayReportStatus;
use App\Enums\EpayReportType;
use App\Enums\TransactionHistoryMoneyUnit;
use App\Enums\WithdrawMethod;
use App\Jobs\SendEmailJob;
use App\Mail\SendReport;
use App\Repositories\EpayReportRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\WithdrawRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Exception;

class ReportService
{
    protected EpayReportRepository $epayReportRepository;

    protected MerchantStoreRepository $merchantStoreRepository;

    protected PaymentSuccessRepository $paymentSuccessRepository;

    protected WithdrawRepository $withdrawRepository;

    public function __construct(
        EpayReportRepository $epayReportRepository,
        MerchantStoreRepository $merchantStoreRepository,
        PaymentSuccessRepository $paymentSuccessRepository,
        WithdrawRepository $withdrawRepository,

    )
    {
        $this->epayReportRepository = $epayReportRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
        $this->paymentSuccessRepository = $paymentSuccessRepository;
        $this->withdrawRepository = $withdrawRepository;
    }

    public function getList($request)
    {
        return $this->epayReportRepository->getList($request);
    }

    public function getReportById($id)
    {
        return $this->epayReportRepository->getReportById($id);
    }

    public function updateReport($request, $id): void
    {
        $this->epayReportRepository->update(['note' => $request->note,], $id);
    }

    public function deleteReport($id): void
    {
        $this->epayReportRepository->delete($id);
    }

    public function createReport($merchantId, $periodFrom, $periodTo): void
    {
        try {
            $issueDate = Carbon::now();
            $periodFrom = Carbon::createFromFormat('Y/m/d', $periodFrom)->startOfDay();
            $periodTo = Carbon::createFromFormat('Y/m/d', $periodTo)->endOfDay();

            DB::beginTransaction();
            $arrUnitPayment = ['USD', 'JPY', 'EUR', 'AED', 'SGD', 'HKD', 'CAD', 'IDR', 'PHP', 'INR', 'KRW'];
            $arrUnitReceived = ['USDT', 'USDC', 'DAI', 'JPYC'];
            $arrUnitWithdraw = ['JPY', 'USDT', 'USDC', 'DAI', 'JPYC'];

            $merchantStoreDatas = $this->merchantStoreRepository
                ->whereNotNull('merchant_user_owner_id')
                ->where('id',$merchantId)
                ->with('merchantOwner')
                ->with('slashApi')
                ->get();

            foreach ($merchantStoreDatas as $merchantStore) {
                $paymentAmount = $this->paymentSuccessRepository->totalPaymentAmountForReport($merchantStore->id, $periodFrom, $periodTo);
                $receivedAmount = $this->paymentSuccessRepository->totalRecivedAmountForReport($merchantStore->id, $periodFrom, $periodTo);
                $withdrawAmount = $this->withdrawRepository->totalAmountForReport($merchantStore->id, $periodFrom, $periodTo);
                $reportCodeCount = $this->epayReportRepository->where('merchant_store_id', $merchantStore->id)->count();

                // payment amount processing
                $paymentAmountDatas = [];
                foreach ($arrUnitPayment as $asset) {
                    $item = $paymentAmount->firstWhere('payment_asset', '=', $asset);
                    $paymentAmountDatas[] = [
                        'asset' => $asset,
                        'count' => $item ? $item->count : 0,
                        'total' => $item ? $item->total : 0
                    ];
                }

                $paymentAmountDatas[] = [
                    'asset' => 'total',
                    'count' => $paymentAmount->pluck('count')->sum(),
                    'total' => '-'
                ];

                // received amount processing
                $receivedAmountDatas = [];
                foreach ($arrUnitReceived as $asset) {
                    $item = $receivedAmount->firstWhere('received_asset', '=', $asset);
                    $receivedAmountDatas[] = [
                        'asset' => $asset,
                        'total' => $item ? $item->total : 0,
                        'count' => $item ? $item->count : 0
                    ];
                }
                $receivedAmountDatas[] = [
                    'asset' => 'total',
                    'count' => $receivedAmount->pluck('count')->sum(),
                    'total' => '-',
                ];

                // withdraw amount processing
                $withdrawAmountDatas = [];
                foreach ($arrUnitWithdraw as $asset) {
                    $withdrawable = '';
                    if ($asset == TransactionHistoryMoneyUnit::JPY->value and $merchantStore->withdraw_method != WithdrawMethod::CRYPTO->value)
                        $withdrawable = $paymentAmount->firstWhere('payment_asset', '=', $asset);
                    elseif (!empty($merchantStore->slashApi) and $merchantStore->slashApi->receive_crypto_type == $asset and $merchantStore->withdraw_method == WithdrawMethod::CRYPTO->value) {
                        $withdrawable = $receivedAmount->firstWhere('received_asset', '=', $asset);
                    }

                    if ($withdrawable)
                        $withdrawableAmount = floatval($withdrawable->total);
                    else
                        $withdrawableAmount = 0;

                    $item = $withdrawAmount->firstWhere('asset', '=', $asset);
                    $withdrawnAmount = floatval($item ? $item->amount : 0);
                    $withdrawalFee = floatval($item ? $item->fee : 0);

                    $withdrawAmountDatas[] = [
                        'asset' => $asset,
                        'withdrawable_amount' => $withdrawableAmount,
                        'withdrawn_amount' => $withdrawnAmount,
                        'withdrawal_fee' => $withdrawalFee,
                        'planned_amount' => $withdrawableAmount - $withdrawnAmount - $withdrawalFee
                    ];
                }

                $reportCode = formatAccountId($merchantStore->merchant_code) . Carbon::now()->format('_Ymd_') . $reportCodeCount + 1;
                $fileName = '加盟店報告書_' . $reportCode . '.pdf';

                $filePath = 'Report/' . $merchantStore->id . '/custom';

                // Add data to DB
                $data = [
                    'report_code' => $reportCode,
                    'merchant_store_id' => $merchantStore->id,
                    'period_from' => $periodFrom,
                    'period_to' => $periodTo,
                    'issue_date' => $issueDate,
                    'send_email' => $merchantStore->merchantOwner->email,
                    'note' => '',
                    'status' => EpayReportStatus::UNSEND->value,
                    'type' => EpayReportType::CUSTOM->value,
                    'payment_amount' => json_encode($paymentAmountDatas),
                    'received_amount' => json_encode($receivedAmountDatas),
                    'withdraw_amount' => json_encode($withdrawAmountDatas),
                    'pdf_link' =>  '/' . $filePath.'/'.$fileName,
                ];

                $this->epayReportRepository->create($data);

                $data['withdraw_method'] = $merchantStore->withdraw_method;
                $data['merchant_name'] = $merchantStore->name;
                $data['merchant_code'] = $merchantStore->merchant_code;

                try {
                    $pdfContent = PDF::loadView('epay.report.reportPDF', $data);
                    Storage::disk('s3')->put($filePath . '/' . $fileName, $pdfContent->output());
                } catch (Exception $e) {
                    DB::rollBack();
                    Storage::disk('s3')->delete($filePath . '/' . $fileName);
                    throw new Exception($e->getMessage());
                }

                DB::commit();
            }
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    /**
     * @throws Exception
     */
    public function sendEmail($id): void
    {
        $report = $this->epayReportRepository->with('merchantStore')->find($id);
        $sendData = [];
        try {
            SendEmailJob::dispatch(new SendReport(array_merge($sendData, [
                'report_code' => $report->report_code,
                'period_from' => $report->period_from,
                'period_to' => $report->period_to,
                'merchant_name' => $report->merchantStore->name,
            ]), $report->pdf_link, $report->report_code . '.pdf'), $report->send_email)->onQueue('emails');
            $this->epayReportRepository->find($report->id)->update(["status" => EpayReportStatus::SENT->value]);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
