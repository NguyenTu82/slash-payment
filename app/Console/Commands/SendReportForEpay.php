<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Exception;
use Carbon\Carbon;
use App\Enums\MerchantStoreStatus;
use App\Enums\EpayReportType;
use App\Enums\WithdrawMethod;
use App\Enums\TransactionHistoryMoneyUnit;
use App\Enums\EpayReportStatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\WithdrawRepository;
use App\Repositories\EpayReportRepository;
use App\Jobs\SendEmailJob;
use App\Mail\SendReport;
use Storage;

class SendReportForEpay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendReportForEpay {--type=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send report every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): void
    {
        $type = $this->option('type');
        try {
            if ($type === 'daily') {
                $periodFrom = Carbon::now()->startOfDay();
                $periodTo = Carbon::now()->endOfDay();
                $deliveryReport = EpayReportType::DAILY->value;
            } elseif ($type === 'weekly') {
                $periodFrom = Carbon::now()->subWeek()->startOfWeek();
                $periodTo = Carbon::now()->subWeek()->endOfWeek();
                $deliveryReport = EpayReportType::WEEKLY->value;
            } else {
                $periodFrom = Carbon::now()->subMonth()->startOfMonth();
                $periodTo = Carbon::now()->subMonth()->endOfMonth();
                $deliveryReport = EpayReportType::MONTHLY->value;
            }
            $issueDate = Carbon::now();

            DB::beginTransaction();
            $merchantStoreRepository = app()->make(MerchantStoreRepository::class);
            $paymentSuccessRepository = app()->make(PaymentSuccessRepository::class);
            $withdrawRepository = app()->make(WithdrawRepository::class);
            $epayReportRepository = app()->make(EpayReportRepository::class);
            $arrUnitPayment = ['USD', 'JPY', 'EUR', 'AED', 'SGD', 'HKD', 'CAD', 'IDR', 'PHP', 'INR', 'KRW'];
            $arrUnitReceived = ['USDT', 'USDC', 'DAI', 'JPYC'];
            $arrUnitWithdraw = ['JPY', 'USDT', 'USDC', 'DAI', 'JPYC'];

            $merchantStoreDatas = $merchantStoreRepository
                ->whereNotNull('delivery_email_address1')
                ->with('merchantOwner')
                ->with('slashApi')
                ->where('status', MerchantStoreStatus::IN_USE->value)
                ->where('delivery_report', $deliveryReport)
                ->get();

            foreach ($merchantStoreDatas as $merchantStore) {
                $paymentAmount = $paymentSuccessRepository->totalPaymentAmountForReport($merchantStore->id, $periodFrom, $periodTo);
                $receivedAmount = $paymentSuccessRepository->totalRecivedAmountForReport($merchantStore->id, $periodFrom, $periodTo);
                $withdrawAmount = $withdrawRepository->totalAmountForReport($merchantStore->id, $periodFrom, $periodTo);

                // payment amount processing
                $paymentAmountDatas = [];
                foreach ($arrUnitPayment as $asset) {
                    $item = $paymentAmount->firstWhere('payment_asset', '=', $asset);
                    array_push($paymentAmountDatas, [
                        'asset' => $asset,
                        'count' => $item ? $item->count : 0,
                        'total' => $item ? $item->total : 0
                    ]);
                }
                array_push($paymentAmountDatas, [
                    'asset' => 'total',
                    'count' => $paymentAmount->pluck('count')->sum(),
                    'total' => '-'
                ]);

                // received amount processing
                $receivedAmountDatas = [];
                foreach ($arrUnitReceived as $asset) {
                    $item = $receivedAmount->firstWhere('received_asset', '=', $asset);
                    array_push($receivedAmountDatas, [
                        'asset' => $asset,
                        'total' => $item ? $item->total : 0,
                        'count' => $item ? $item->count : 0
                    ]);
                }
                array_push($receivedAmountDatas, [
                    'asset' => 'total',
                    'count' => $receivedAmount->pluck('count')->sum(),
                    'total' => '-',
                ]);

                // withdraw amount processing
                $withdrawAmountDatas = [];
                foreach ($arrUnitWithdraw as $asset) {
                    $withdrawable = '';
                    if ($asset == TransactionHistoryMoneyUnit::JPY->value and $merchantStore->withdraw_method != WithdrawMethod::CRYPTO->value)
                        $withdrawable = $paymentAmount->firstWhere('payment_asset', '=', $asset);
                    elseif ($merchantStore->slashApi->receive_crypto_type == $asset and $merchantStore->withdraw_method == WithdrawMethod::CRYPTO->value) {
                        $withdrawable = $receivedAmount->firstWhere('received_asset', '=', $asset);
                    }

                    if ($withdrawable)
                        $withdrawableAmount = floatval($withdrawable->total);
                    else
                        $withdrawableAmount = 0;

                    $item = $withdrawAmount->firstWhere('asset', '=', $asset);
                    $withdrawnAmount = floatval($item ? $item->amount : 0);
                    $withdrawalFee = floatval($item ? $item->fee : 0);

                    array_push($withdrawAmountDatas, [
                        'asset' => $asset,
                        'withdrawable_amount' => $withdrawableAmount,
                        'withdrawn_amount' => $withdrawnAmount,
                        'withdrawal_fee' => $withdrawalFee,
                        'planned_amount' => $withdrawableAmount - $withdrawnAmount - $withdrawalFee
                    ]);
                }

                $emailList = [
                    $merchantStore->delivery_email_address1,
                    $merchantStore->delivery_email_address2,
                    $merchantStore->delivery_email_address3,
                ];
                foreach ($emailList as $email) {
                    if (!empty($email)) {
                        $reportCodeCount = $epayReportRepository->where('merchant_store_id', $merchantStore->id)->count();
                        $reportCode = formatAccountId($merchantStore->merchant_code) . Carbon::now()->format('_Ymd_') . $reportCodeCount + 1;
                        $fileName = '加盟店報告書_' . $reportCode . '.pdf';

                        if ($type === 'daily') {
                            $filePath = "Report/" . $merchantStore->id . '/day';
                        } elseif ($type === 'weekly') {
                            $filePath = "Report/" . $merchantStore->id . '/week';
                        } else {
                            $filePath = "Report/" . $merchantStore->id . '/month';
                        }
                        // add data to DB
                        $data = [
                            'report_code' => $reportCode,
                            'merchant_store_id' => $merchantStore->id,
                            'period_from' => $periodFrom,
                            'period_to' => $periodTo,
                            'issue_date' => $issueDate,
                            'send_email' => $email,
                            'note' => '',
                            'status' => EpayReportStatus::UNSEND->value,
                            'type' => $deliveryReport,
                            'payment_amount' => json_encode($paymentAmountDatas),
                            'received_amount' => json_encode($receivedAmountDatas),
                            'withdraw_amount' => json_encode($withdrawAmountDatas),
                            'pdf_link' => '/' . $filePath . '/' . $fileName,
                        ];

                        $report = $epayReportRepository->create($data);

                        try {
                            $data = array_merge($data, [
                                'merchant_name' => $merchantStore->name,
                                'filename' => $fileName,
                                'merchant_code' => $merchantStore->merchant_code,
                                'withdraw_method' => $merchantStore->withdraw_method,
                            ]);
                            $pdfContent = \PDF::loadView('epay.report.reportPDF', $data);
                            Storage::disk('s3')->put($filePath . '/' . $fileName, $pdfContent->output());

                            SendEmailJob::dispatch(new SendReport($data, $filePath . '/' . $fileName, $fileName), $email)->onQueue('emails');

                            $epayReportRepository->find($report->id)->update(["status" => EpayReportStatus::SENT->value]);
                        } catch (Exception $e) {
                            Storage::disk('s3')->delete($filePath . '/' . $fileName);
                            Log::error("JOB-ERROR:" . $e->getMessage());
                        }
                    }
                }
                DB::commit();
            }

        } catch (Exception $e) {
            DB::rollBack();
            Log::error("JOB-ERROR:" . $e->getMessage());
        }
    }
}