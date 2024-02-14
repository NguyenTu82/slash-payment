<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\MerchantStoreStatus;
use App\Enums\TransactionHistoryPaymentStatus;
use App\Enums\WithdrawAsset;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawStatus;
use App\Http\Controllers\Controller;
use App\Services\Affiliate\AccountService as AffiliateAccountService;
use App\Services\Merchant\MerchantService;
use App\Services\Merchant\MerchantStoreService;
use App\Services\Merchant\PaymentSuccessService;
use App\Services\Merchant\TransactionHistoryService;
use App\Services\Merchant\WithdrawService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private AffiliateAccountService $affiliateAccountService;

    private MerchantStoreService $merchantStoreService;

    private TransactionHistoryService $transactionHistoryService;

    private PaymentSuccessService $paymentSuccessService;

    private WithdrawService $withdrawService;

    private MerchantService $merchantService;

    public function __construct(
        AffiliateAccountService $affiliateAccountService,
        MerchantStoreService $merchantStoreService,
        TransactionHistoryService $transactionHistoryService,
        PaymentSuccessService $paymentSuccessService,
        WithdrawService $withdrawService,
        MerchantService $merchantService,
    ) {
        $this->affiliateAccountService = $affiliateAccountService;
        $this->merchantStoreService = $merchantStoreService;
        $this->transactionHistoryService = $transactionHistoryService;
        $this->paymentSuccessService = $paymentSuccessService;
        $this->withdrawService = $withdrawService;
        $this->merchantService = $merchantService;
    }

    public function index(Request $request)
    {
        $viewType = $request->view_type ?? 'by_hour';
        $year = $request->year ?? now()->format('Y');
        $month = $request->month ?? now()->format('m');
        $day = $request->day ?? now()->format('d');
        $basePeriod = []; // base range time
        $periodFormatOfChart = []; // range time in chart formatted
        $currentYear = now()->format('Y');
        $startDate = $endDate = '';
        $isLangJapanese = isLangJapanese();
        // $storeActiveIds = $this->merchantStoreService->merchantStoreActiveIds();
        // 1. Box summary
        // 2. Box chart
        // 3. Box table
        $stores = $this->merchantService->getProfile()->merchantStores;
        $selectedStores = $request->merchant_slt ? [$request->merchant_slt] : $stores->pluck('id')->toArray();

        switch ($viewType) {
            case 'by_month':
                $baseDate = Carbon::createFromFormat('Y', $year);
                $startDate = $baseDate->copy()->startOfYear()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfYear()->format('Y-m-d H:i:s');
                for ($i = 1; $i <= 12; $i++) {
                    $basePeriod[] = formatFullNumber($i); // use query below
                    $periodFormatOfChart[] = $i . ($isLangJapanese ? '月' : '');
                }
                break;
            case 'by_day':
                $baseDate = Carbon::createFromFormat('Y-m', "$year-$month");
                $startDate = $baseDate->copy()->startOfMonth()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfMonth()->format('Y-m-d H:i:s');
                $maxDay = $baseDate->copy()->daysInMonth;
                for ($i = 1; $i <= $maxDay; $i++) {
                    $basePeriod[] = formatFullNumber($i);
                    $periodFormatOfChart[] = $i . ($isLangJapanese ? '日' : '');
                }
                break;
            case 'by_hour':
                $baseDate = Carbon::parse("$year-$month-$day");
                $startDate = $baseDate->copy()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfDay()->format('Y-m-d H:i:s');
                for ($i = 0; $i <= 23; $i++) {
                    $basePeriod[] = formatFullNumber($i);
                    $periodFormatOfChart[] = $i . ($isLangJapanese ? '時' : '');
                }
                break;
            default:
                $baseDate = now();
                $startDate = $baseDate->copy()->subYears(10)->startOfYear()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfYear()->format('Y-m-d H:i:s');
                for ($i = $currentYear - 10; $i <= $currentYear; $i++) {
                    $basePeriod[] = $i;
                    $periodFormatOfChart[] = $i . ($isLangJapanese ? '年' : '');
                }
                break;
        }

        $baseCond = [
            'view_type' => $viewType,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'store_ids' => $selectedStores,
        ];
        $baseCondExcludeStartDate = $baseCond;
        unset($baseCondExcludeStartDate['start_date']);

        // ---- Data box summary ----
        $totalTransactions = $this->paymentSuccessService->totalTransactions(
            (object) array_merge($baseCond, [
            ])
        );
        $totalCryptoReceive = $this->paymentSuccessService->totalCryptoReceive(
            (object) array_merge($baseCond, [
            ])
        );
        $totalMoneyWithdraw = $this->withdrawService->totalMoneyWithdraw(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED,
            ])
        );
        $totalMerchantStores = $this->merchantStoreService->totalMerchantStores(
            (object) array_merge($baseCondExcludeStartDate, [
                'status' => [
                    MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                    MerchantStoreStatus::UNDER_REVIEW->value,
                    MerchantStoreStatus::IN_USE->value,
                ],
            ])
        );

        // ---- Data chart vs table ----
        // 2.1 both chart and table
        $transInfo = $this->paymentSuccessService->paymentSuccessStatistic(
            (object) array_merge($baseCond, [
            ])
        );
        $withdrawSuccessCountInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
                'asset' => WithdrawAsset::JPY->value,
            ])
        );
        // 2.3 (Yen) both chart and table
        $slashPaymentByYenAmountInfo = $this->paymentSuccessService->paymentSuccessStatistic(
            (object) array_merge($baseCond, [
                'payment_asset' => WithdrawAsset::JPY->value,
            ])
        );
        // 2.4 (Yen)
        $withdrawSuccessAmountInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
                'asset' => WithdrawAsset::JPY->value,
            ])
        );
        // 2.5 (Yen)
        $withdrawFeeInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
                'fee_asset' => WithdrawAsset::JPY->value,
            ])
        );
        // dd($withdrawFeeInfo->toArray());

        // ---- more query get data table ----
        // 3.1 - base period
        // 3.2 ~ 2.1 (count transactions)
        // 3.3 ~ 2.3 (payment via slash Yen)
        // 3.4 payment via slash USDT - received_asset
        $slashReceiveByUSDTAmountInfo = $this->paymentSuccessService->paymentSuccessStatistic(
            (object) array_merge($baseCond, [
                'received_asset' => WithdrawAsset::USDT->value,
            ])
        );
        // 3.5 ~ 2.2 (withdraw success count Yen)
        // 3.6 ~ 2.4 (total amount withdraw success )
        // 3.7 ~ 2.5 (Fee withdraw success)
        // 3.8 - Transactions unpaid
        $transUnpaidAmountInfo = $this->transactionHistoryService->transStatistic(
            (object) array_merge($baseCond, [
                'payment_status' => TransactionHistoryPaymentStatus::OUTSTANDING->value,
                'payment_asset' => WithdrawAsset::JPY->value,
            ])
        );
        // 3.9 new store (created_at)
        $merchantStoreCountInfo = $this->merchantStoreService->merchantStoreStatistic(
            (object) array_merge($baseCond, [
                'status' => [
                    MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                    MerchantStoreStatus::UNDER_REVIEW->value,
                    MerchantStoreStatus::IN_USE->value,
                ]
            ])
        );
        // 3.10 store cancel (created_at, status = cancel)
        $merchantStoreCancelCountInfo = $this->merchantStoreService->merchantStoreStatistic(
            (object) array_merge($baseCond, [
                MerchantStoreStatus::SUSPEND->value,
                MerchantStoreStatus::WITHDRAWAL->value,
                MerchantStoreStatus::FORCED_WITHDRAWAL->value,
                MerchantStoreStatus::CANCEL->value,
            ])
        );
        // ---- end more query get data table ----

        // use only chart
        $transCountArr = [];
        $withdrawSuccessCountArr = [];
        $slashPaymentByYenAmountArr = [];
        $withdrawSuccessAmountArr = [];
        $withdrawFeeArr = [];

        // use only table
        $tableData = [];

        // Mapping time match base Period for Chart, Table
        foreach ($basePeriod as $value) {
            // 2.1 both chart and table (3.2)
            $checkItem = $transInfo->where('time_number', $value)->first();
            $transCountValue = $checkItem ? $checkItem->count : 0;
            $transCountArr[] = $transCountValue;

            // 2.2 (Yen) both chart and table (3.5)
            $checkItem = $withdrawSuccessCountInfo->where('time_number', $value)->first();
            $withdrawSuccessCountValue = $checkItem ? $checkItem->count : 0;
            $withdrawSuccessCountArr[] = $withdrawSuccessCountValue;

            // 2.3 (Yen) both chart and table (3.3)
            $checkItem = $slashPaymentByYenAmountInfo->where('time_number', $value)->first();
            $slashPaymentByYenAmountValue = $checkItem ? $checkItem->total_payment_amount : 0;
            $slashPaymentByYenAmountArr[] = $slashPaymentByYenAmountValue;

            // 2.4 (Yen) both chart and table (3.6)
            $checkItem = $withdrawSuccessAmountInfo->where('time_number', $value)->first();
            $withdrawSuccessAmountValue = $checkItem ? $checkItem->total_withdraw : 0;
            $withdrawSuccessAmountArr[] = $withdrawSuccessAmountValue;

            // 2.5 (Yen)  both chart and table (3.7)
            $checkItem = $withdrawFeeInfo->where('time_number', $value)->first();
            $withdrawFeeValue = $checkItem ? $checkItem->total_fee : 0;
            $withdrawFeeArr[] = $withdrawFeeValue;
            // dd($withdrawFeeInfo->toArray());

            // ---- more process only table ----
            // 3.4 payment via slash USDT - received_asset
            $checkItem = $slashReceiveByUSDTAmountInfo->where('time_number', $value)->first();
            $slashReceiveByUSDTAmountValue = $checkItem ? $checkItem->total_received_amount : 0;

            // 3.5 (Yen)
            $checkItem = $withdrawSuccessCountInfo->where('time_number', $value)->first();
            $withdrawSuccessCountValue = $checkItem ? $checkItem->count : 0;

            // 3.8 (Yen)
            $checkItem = $transUnpaidAmountInfo->where('time_number', $value)->first();
            $transUnpaidAmountValue = $checkItem ? $checkItem->total_amount : 0;

            // 3.9 merchant store count
            $checkItem = $merchantStoreCountInfo->where('time_number', $value)->first();
            $merchantStoreCountValue = $checkItem ? $checkItem->count : 0;

            // 3.10  merchant store cancel count
            $checkItem = $merchantStoreCancelCountInfo->where('time_number', $value)->first();
            $merchantStoreCancelCountValue = $checkItem ? $checkItem->count : 0;

            // mapping for table
            // Carbon::setLocale('es');
            switch ($viewType) {
                case 'by_hour':
                    $periodFormatOfTable = Carbon::createFromFormat('Y H', "$year $value")->format('H:i');
                    break;
                case 'by_day':
                    $dateInput = Carbon::parse("$year-$month-$value");
                    $dateFormat = $isLangJapanese ? $dateInput->copy()->format('Y年m月d日')
                                                  : $dateInput->copy()->format('Y/m/d');
                    $suffix = $dateInput->format('D');
                    $suffix = getDayName($suffix);
                    $periodFormatOfTable = "$dateFormat ($suffix)";
                    break;
                case 'by_month':
                    $periodFormatOfTable = +($value) . ($isLangJapanese ? '月' : '');
                    break;
                default:
                    $periodFormatOfTable = +($value) . ($isLangJapanese ? '年' : '');
                    break;
            }

            $tableData[] = [
                'period' => $periodFormatOfTable,
                'trans_count' => $transCountValue,
                'payment_amount_success' => $slashPaymentByYenAmountValue,
                'received_amount' => $slashReceiveByUSDTAmountValue,
                'withdraw_success_count' => $withdrawSuccessCountValue,
                'withdraw_success_amount' => $withdrawSuccessAmountValue,
                'withdraw_fee' => $withdrawFeeValue,
                'trans_unpaid' => $transUnpaidAmountValue,
                'merchant_store' => $merchantStoreCountValue,
                'merchant_store_cancel' => $merchantStoreCancelCountValue,
            ];
        }

        if ($request->wantsJson()) {
            $response = [
                'message' => 'successful.',
                'data' => [
                    'total_transactions' => $totalTransactions,
                    'total_crypto_receive' => $totalCryptoReceive,
                    'total_merchant_stores' => $totalMerchantStores,
                    'total_money_withdraw' => $totalMoneyWithdraw,
                    'chart' => [
                        'data' => [
                            'trans_count' => $transCountArr,
                            'withdraw_success_count' => $withdrawSuccessCountArr,
                            'slash_payment_amount' => $slashPaymentByYenAmountArr,
                            'withdraw_success_amount' => $withdrawSuccessAmountArr,
                            'withdraw_fee' => $withdrawFeeArr,
                        ],
                        'labels' => $periodFormatOfChart,
                    ],
                    'table' => collect($tableData),
                ],
            ];

            return response()->json($response);
        }

        return view('merchant.dashboard.index', compact(
            'basePeriod', 'stores'
        ));
    }

    public function detail(Request $request)
    {
        $viewType = $request->view_type ?? 'by_hour';
        $year = $request->year ?? now()->format('Y');
        $month = $request->month ?? now()->format('m');
        $day = $request->day ?? now()->format('d');
        $hour = $request->hour ?? now()->format('H');
        $basePeriod = []; // base range time
        $periodFormatOfChart = []; // range time in chart formatted
        $currentYear = now()->format('Y');
        $stores = $this->merchantService->getProfile()->merchantStores;
        $selectedStores = $request->merchant_slt ? [$request->merchant_slt] : $stores->pluck('id')->toArray();
        switch ($viewType) {
            case 'by_month':
                $baseDate = Carbon::createFromFormat('Y-m', "$year-$month");
                $startDate = $baseDate->copy()->startOfMonth()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfMonth()->format('Y-m-d H:i:s');
                break;
            case 'by_day':
                $baseDate = Carbon::parse("$year-$month-$day");
                $startDate = $baseDate->copy()->startOfDay()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfDay()->format('Y-m-d H:i:s');
                break;
            case 'by_hour':
                $baseDate = Carbon::createFromFormat('Y-m-d H', "$year-$month-$day $hour");
                $startDate = $baseDate->copy()->startOfHour()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfHour()->format('Y-m-d H:i:s');
                break;
            default:
                $baseDate = Carbon::createFromFormat('Y-m', "$year-$month");
                $startDate = $baseDate->copy()->startOfYear()->format('Y-m-d H:i:s');
                $endDate = $baseDate->copy()->endOfYear()->format('Y-m-d H:i:s');
                break;
        }
        $baseCond = [
            'view_type' => $viewType,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'store_ids' => $selectedStores,
        ];
        $baseCondExcludeStartDate = $baseCond;
        // unset($baseCondExcludeStartDate['start_date']);

        // dd($viewType, $year, $month, $day, $hour, $startDate, $endDate);
        // 1.1
        $totalTransactions = $this->paymentSuccessService->totalTransactions(
            (object) array_merge($baseCond, [
            ])
        );
        // dd($totalTransactions);
        // 1.2
        $slashPaymentAmountInfo = $this->paymentSuccessService->paymentSuccessStatistic(
            (object) array_merge($baseCond, [
                'view_detail' => true,
                'group_by' => 'payment_asset',
            ])
        );
        $slashPaymentAmountInfo = $slashPaymentAmountInfo->pluck('total_payment_amount', 'payment_asset');
        // 1.3
        $slashReceiveAmountInfo = $this->paymentSuccessService->paymentSuccessStatistic(
            (object) array_merge($baseCond, [
                'view_detail' => true,
                'group_by' => 'received_asset',
            ])
        );
        $slashReceiveAmountInfo = $slashReceiveAmountInfo->pluck('total_received_amount', 'received_asset');
        // 1.4
        $transUnpaidAmountInfo = $this->transactionHistoryService->transStatistic(
            (object) array_merge($baseCond, [
                'payment_status' => TransactionHistoryPaymentStatus::OUTSTANDING->value,
                'payment_asset' => WithdrawAsset::JPY->value,
            ])
        );
        $transUnpaidAmount = $transUnpaidAmountInfo[0]->total_amount ?? 0;

        // 1.5
        $withdrawSuccessCountInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
            ])
        );
        $withdrawSuccessCount = $withdrawSuccessCountInfo[0]->count ?? 0;
        // 1.6, 1.7
        // Crypto
        $withdrawSuccessByCryptoInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
                'withdraw_method' => WithdrawMethod::CRYPTO->value,
                'view_detail' => true,
                'group_by' => 'asset',
            ])
        );
        $withdrawSuccessByCryptoAmounInfo = (clone $withdrawSuccessByCryptoInfo)->pluck('total_withdraw', 'asset');
        $withdrawSuccessByCryptoFeeInfo = (clone $withdrawSuccessByCryptoInfo)->pluck('total_fee', 'asset');
        // Yen
        $withdrawSuccessByYenInfo = $this->withdrawService->withdrawStatistic(
            (object) array_merge($baseCond, [
                'withdraw_status' => WithdrawStatus::SUCCEEDED->value,
                'asset' => WithdrawAsset::JPY->value,
                'view_detail' => true,
                'group_by' => 'withdraw_method',
            ])
        );
        $withdrawSuccessByYenAmounInfo = (clone $withdrawSuccessByYenInfo)->pluck('total_withdraw', 'withdraw_method');
        $withdrawSuccessByYenFeeInfo = (clone $withdrawSuccessByYenInfo)->pluck('total_fee', 'withdraw_method');
        // 1.8
        $totalMerchantStores = $this->merchantStoreService->totalMerchantStores(
            (object) array_merge($baseCondExcludeStartDate, [
                'status' => [
                    MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                    MerchantStoreStatus::UNDER_REVIEW->value,
                    MerchantStoreStatus::IN_USE->value,
                ],
            ])
        );
        // 1.9
        // 1.10
        $totalStoresCancel = $this->merchantStoreService->totalMerchantStores(
            (object) array_merge($baseCondExcludeStartDate, [
                'status' => [
                    MerchantStoreStatus::SUSPEND->value,
                    MerchantStoreStatus::WITHDRAWAL->value,
                    MerchantStoreStatus::FORCED_WITHDRAWAL->value,
                    MerchantStoreStatus::CANCEL->value,
                ],
            ])
        );

        $html = view('merchant.dashboard.modal.partial.main_content', compact(
            'totalTransactions',
            'slashPaymentAmountInfo',
            'slashReceiveAmountInfo',
            'transUnpaidAmount',
            'withdrawSuccessCount',
            'withdrawSuccessByCryptoAmounInfo',
            'withdrawSuccessByCryptoFeeInfo',
            'withdrawSuccessByYenAmounInfo',
            'withdrawSuccessByYenFeeInfo',
            'totalMerchantStores',
            'totalStoresCancel',
        ))->render();

        return response()->json([
            'html' => $html,
            'message' => 'Getting successful',
        ]);
    }
}
