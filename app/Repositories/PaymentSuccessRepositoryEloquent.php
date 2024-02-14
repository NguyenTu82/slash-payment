<?php

namespace App\Repositories;

use App\Models\PaymentSuccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Str;
use App\Enums\TransactionHistoryCryptoUnit;
use App\Enums\TransactionHistoryMoneyUnit;
use App\Models\TransactionHistory;
use Prettus\Repository\Exceptions\RepositoryException;
use Illuminate\Support\Collection;
use App\Enums\WithdrawAsset;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentSuccessRepositoryEloquent extends BaseRepository implements PaymentSuccessRepository
{
    public function model(): string
    {
        return PaymentSuccess::class;
    }

    /**
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function totalTransactions($cond)
    {
        return $this->model->newQuery()
            ->select(
                DB::raw('count(*) as count'),
            )
            ->when(!empty($cond->payment_status), function ($query) use ($cond) {
                $query->where('payment_status', '=', $cond->payment_status);
            })
            ->when(!empty($cond->start_date), function ($query) use ($cond) {
                $query->where('created_at', '>=', $cond->start_date);
            })
            ->when(!empty($cond->end_date), function ($query) use ($cond) {
                $query->where('created_at', '<=', $cond->end_date);
            })
            ->when(!empty($cond->store_active_ids) && is_array($cond->store_active_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_active_ids);
            })
            ->when(!empty($cond->store_ids) && is_array($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_ids);
            })
            ->count();
    }

    public function totalCryptoReceive($cond): Collection
    {
        return $this->model->newQuery()
            ->select(
                'received_asset',
                DB::raw('SUM(received_amount) as total')
            )
            ->when(!empty($cond->start_date), function ($query) use ($cond) {
                $query->where('created_at', '>=', $cond->start_date);
            })
            ->when(!empty($cond->end_date), function ($query) use ($cond) {
                $query->where('created_at', '<=', $cond->end_date);
            })
            ->when(!empty($cond->store_active_ids) && is_array($cond->store_active_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_active_ids);
            })
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_ids);
            })
            ->groupBy('received_asset')
            ->pluck('total', 'received_asset');
    }

    public function totalReceiveSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time)
    {
        return $this->model->newQuery()
            ->where('merchant_store_id', $merchantStoreId)
            ->where('received_asset', $asset)
            ->when(!empty($time), function ($query) use ($time) {
                $query->where('created_at', '<=', $time);
            })
            ->groupBy('received_asset')
            ->sum('received_amount');
    }

    public function totalPaymentSuccessOfMerchantStoreByAsset($merchantStoreId, $asset, $time)
    {
        return $this->model->newQuery()
            ->where('merchant_store_id', $merchantStoreId)
            ->where('payment_asset', $asset)
            ->when(!empty($time), function ($query) use ($time) {
                $query->where("created_at", '<=', $time);
            })
            ->groupBy('payment_asset')
            ->sum('payment_amount');
    }

    public function totalBalanceOfMerchantStore($merchantStoreId, $type)
    {
        return $this->model->newQuery()
            ->where('merchant_store_id', $merchantStoreId)
            ->when(!empty($type) && ($type == 'payment_asset'), function ($query) {
                $query->select(
                    DB::raw('SUM(payment_amount) as total_amount'),
                    'payment_asset',
                )
                    ->where('payment_asset', WithdrawAsset::JPY->value)
                    ->groupBy('payment_asset');
            })
            ->when(!empty($type) && ($type == 'received_asset'), function ($query) {
                $query->select(
                    DB::raw('SUM(received_amount) as total_amount'),
                    'received_asset',
                )
                    ->groupBy('received_asset');
            })
            ->get();
    }

    public function paymentSuccessStatistic($cond): array|Collection
    {
        return $this->model->newQuery()
            ->when(!empty($cond->payment_asset), function ($query) use ($cond) {
                $query->where('payment_asset', '=', $cond->payment_asset);
            })
            ->when(!empty($cond->received_asset), function ($query) use ($cond) {
                $query->where('received_asset', '=', $cond->received_asset);
            })
            ->when(!empty($cond->start_date), function ($query) use ($cond) {
                $query->where('created_at', '>=', $cond->start_date);
            })
            ->when(!empty($cond->end_date), function ($query) use ($cond) {
                $query->where('created_at', '<=', $cond->end_date);
            })
            ->when(!empty($cond->store_active_ids) && is_array($cond->store_active_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_active_ids);
            })
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_ids);
            })
            ->when(!empty($cond->view_type), function ($query) use ($cond) {
                $query->select(
                    DB::raw('count(*) as count'),
                    DB::raw('SUM(payment_amount) as total_payment_amount'),
                    DB::raw('SUM(received_amount) as total_received_amount'),
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H") as date_time'),
                    'payment_asset',
                    'received_asset',
                );

                switch ($cond->view_type) {
                    case 'by_month':
                        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%m") as time_number'));
                        break;
                    case 'by_day':
                        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%d") as time_number'));
                        break;
                    case 'by_hour':
                        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%H") as time_number'));
                        break;
                    default:
                        $query->addSelect(DB::raw('DATE_FORMAT(created_at, "%Y") as time_number'));
                        break;
                }
            })
            ->when(!empty($cond->view_detail), function ($query) use ($cond) {
                // Used in popup detail dashboard
                $groupBy = $cond->group_by ?? 'payment_amount';
                $query->groupBy($groupBy);
            }, function ($query) {
            $query->groupBy('time_number'); // use for dashboard
        })->get();
    }

    public function getCountAmount($merchantId, $paymentAsset, $time)
    {
        return $this->model->newQuery()
            ->where("merchant_store_id", $merchantId)
            ->where("created_at", "<", $time)
            ->where("payment_asset", $paymentAsset)
            ->sum("payment_amount");
    }

    public function getQueryPaymentSuccessByType($request, $type): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->newQuery()
            ->when($type == "received", function ($q) {
                $q->select(
                    DB::raw('SUM(CASE WHEN payment_success.received_asset =  "' . TransactionHistoryCryptoUnit::USDT->value . '" THEN payment_success.received_amount ELSE 0 END) as ' . TransactionHistoryCryptoUnit::USDT->value),
                    DB::raw('SUM(CASE WHEN payment_success.received_asset =  "' . TransactionHistoryCryptoUnit::USDC->value . '" THEN payment_success.received_amount ELSE 0 END) as ' . TransactionHistoryCryptoUnit::USDC->value),
                    DB::raw('SUM(CASE WHEN payment_success.received_asset =  "' . TransactionHistoryCryptoUnit::DAI->value . '" THEN payment_success.received_amount ELSE 0 END) as ' . TransactionHistoryCryptoUnit::DAI->value),
                    DB::raw('SUM(CASE WHEN payment_success.received_asset =  "' . TransactionHistoryCryptoUnit::JPYC->value . '" THEN payment_success.received_amount ELSE 0 END) as ' . TransactionHistoryCryptoUnit::JPYC->value),
                    DB::raw('COUNT(payment_success.id) as count')
                );
            })
            ->when($type == "payment", function ($q) {
                $q->select(
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::USD->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::USD->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::JPY->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::JPY->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::EUR->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::EUR->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::AED->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::AED->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::SGD->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::SGD->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::HKD->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::HKD->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::CAD->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::CAD->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::IDR->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::IDR->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::PHP->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::PHP->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::INR->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::INR->value),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::KRW->value . '" THEN payment_success.payment_amount ELSE 0 END) as ' . TransactionHistoryMoneyUnit::KRW->value),
                );
            })
            ->when($type == "graph", function ($q) {
                if (app()->getLocale() === 'ja')
                    $formatDate = DB::raw('DATE_FORMAT(transaction_histories.transaction_date, "%m月%d日") as date');
                else
                    $formatDate = DB::raw('DATE_FORMAT(transaction_histories.transaction_date, "%m/%d") as date');

                $q->select(
                    $formatDate,
                    DB::raw('COUNT(payment_success.id) as count'),
                    DB::raw('SUM(CASE WHEN payment_success.payment_asset =  "' . TransactionHistoryMoneyUnit::JPY->value . '" THEN payment_success.payment_amount ELSE 0 END) as sum_payment_amount'),
                    DB::raw('SUM(CASE WHEN payment_success.received_asset = "' . TransactionHistoryCryptoUnit::USDT->value . '" THEN payment_success.received_amount ELSE 0 END) as sum_received_amount')
                );
            })
            ->when(isset($request->merchant_store_id), function ($q) use ($request) {
                $q->where('payment_success.merchant_store_id', $request->merchant_store_id);
            })
            ->when(isset($request->merchantStoresIds), function ($q) use ($request) {
                $q->whereIn('payment_success.merchant_store_id', $request->merchantStoresIds);
            })
            ->when(isset($request->trans_id), function ($q) use ($request) {
                $q->where('payment_success.transaction_history_id', 'like', '%' . $request->trans_id . '%');
            })
            // query by date request
            ->join('transaction_histories', 'payment_success.transaction_history_id', '=', 'transaction_histories.id')
            ->when(isset($request->startDateRequest) and isset($request->endDateRequest), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.transaction_date', [Carbon::parse($request->startDateRequest), Carbon::parse($request->endDateRequest)->addDay()]);
            })
            ->when(isset($request->startDateRequest) and !isset($request->endDateRequest), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.transaction_date', [Carbon::parse($request->startDateRequest), Carbon::parse($request->startDateRequest)->addDays(32)]);
            })
            ->when(!isset($request->startDateRequest) and isset($request->endDateRequest), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.transaction_date', [Carbon::parse($request->endDateRequest)->subDays(31), Carbon::parse($request->endDateRequest)->addDay()]);
            })
            ->when(!isset($request->startDateRequest) and !isset($request->endDateRequest), function ($q) use ($request) {
                $timeNow = Carbon::now();
                $startOfMonth = Carbon::now()->startOfMonth();
                $q->whereBetween('transaction_histories.transaction_date', [$startOfMonth, $timeNow]);
            })
            // query by date payment
            ->when(isset($request->startDatePayment) and isset($request->endDatePayment), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.payment_success_datetime', [Carbon::parse($request->startDatePayment), Carbon::parse($request->endDatePayment)->addDay()]);
            })
            ->when(isset($request->startDatePayment) and !isset($request->endDatePayment), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.payment_success_datetime', [Carbon::parse($request->startDatePayment), Carbon::parse($request->startDatePayment)->addDays(32)]);
            })
            ->when(!isset($request->startDatePayment) and isset($request->endDatePayment), function ($q) use ($request) {
                $q->whereBetween('transaction_histories.payment_success_datetime', [Carbon::parse($request->endDatePayment)->subDays(31), Carbon::parse($request->endDatePayment)->addDay()]);
            })

            ->when(isset($request->network), function ($q) use ($request) {
                $q->where('payment_success.network', $request->network);
            })
            ->when(isset($request->request_method), function ($q) use ($request) {
                $q->where('payment_success.request_method', $request->request_method);
            })
            // query by money unit and price
            ->when(!isset($request->unit), function ($q) use ($request) {
                $q->when(isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                    $q->whereBetween('payment_success.payment_amount', [$request->startAmount, $request->endAmount]);
                })
                    ->when(isset($request->startAmount) and !isset($request->endAmount), function ($q) use ($request) {
                        $maxAmountPayment = $this->model->max('payment_success.payment_amount');
                        $q->whereBetween('payment_success.payment_amount', [$request->startAmount, $maxAmountPayment]);
                    })
                    ->when(!isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $minAmountPayment = $this->model->min('payment_success.payment_amount');
                        $q->whereBetween('payment_success.payment_amount', [$minAmountPayment, $request->endAmount]);
                    });
            })

            ->when(isset($request->unit) and Str::contains($request->unit, 'p'), function ($q) use ($request) {
                $q->where('payment_success.payment_asset', Str::after($request->unit, 'p'))
                    ->when(isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $q->whereBetween('payment_success.payment_amount', [$request->startAmount, $request->endAmount]);
                    })
                    ->when(isset($request->startAmount) and !isset($request->endAmount), function ($q) use ($request) {
                        $maxAmount = $this->model->max('payment_success.payment_amount');
                        $q->whereBetween('payment_success.payment_amount', [$request->startAmount, $maxAmount]);
                    })
                    ->when(!isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $minAmount = $this->model->min('payment_success.payment_amount');
                        $q->whereBetween('payment_success.payment_amount', [$minAmount, $request->endAmount]);
                    });
            })
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('transaction_histories.payment_status', $request->status);
            })
            ->when(isset($request->hash), function ($q) use ($request) {
                $q->where('transaction_histories.hash', 'like', '%' . $request->hash . '%');
            })
            ->when($type == "graph", function ($q) {
                $q->groupBy('date');
            })
            ->orderBy('transaction_date', 'asc')
            ->get();
    }

    public function totalPaymentAmountForReport($merchant_store_id, $period_from, $period_to)
    {
        return $this->model->newQuery()
            ->select(
                'payment_success.payment_asset',
                DB::raw('SUM(payment_success.payment_amount) as total'),
                DB::raw('COUNT(payment_success.id) as count'),
            )
            ->where('payment_success.merchant_store_id', $merchant_store_id)
            ->join('transaction_histories', 'payment_success.transaction_history_id', '=', 'transaction_histories.id')
            ->whereBetween('transaction_histories.transaction_date', [$period_from, $period_to])
            ->groupBy('payment_success.payment_asset')
            ->get();
    }

    public function totalRecivedAmountForReport($merchant_store_id, $period_from, $period_to)
    {
        return $this->model->newQuery()
            ->select(
                'payment_success.received_asset',
                DB::raw('SUM(payment_success.received_amount) as total'),
                DB::raw('COUNT(payment_success.id) as count'),
            )
            ->where('payment_success.merchant_store_id', $merchant_store_id)
            ->join('transaction_histories', 'payment_success.transaction_history_id', '=', 'transaction_histories.id')
            ->whereBetween('transaction_histories.transaction_date', [$period_from, $period_to])
            ->groupBy('payment_success.received_asset')
            ->get();
    }

    public function totalPaymentAndRecivedAmount($merchant_store_id, $asset, $time1)
    {
        return $this->model->newQuery()
            ->select(
                DB::raw('SUM(payment_amount) as payment_total'),
                DB::raw('SUM(received_amount) as received_total'),
            )
            ->where('merchant_store_id', $merchant_store_id)
            ->where('received_asset', $asset)
            ->when(!empty($time1), function ($query) use ($time1) {
                $query->where('created_at', '>', $time1);
            })
            ->groupBy('received_asset')
            ->get();
    }
}