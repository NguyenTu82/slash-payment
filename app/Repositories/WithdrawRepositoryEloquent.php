<?php

namespace App\Repositories;

use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Enums\WithdrawStatus;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WithdrawRepositoryEloquent extends BaseRepository implements WithdrawRepository
{
    public function model(): string
    {
        return Withdraw::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getBalanceIsUsedByAsset($merchantStoreId, $asset)
    {
        return $this->model->newQuery()
            ->where('merchant_store_id', $merchantStoreId)
            ->where('asset', $asset)
            ->whereIn('withdraw_status', [
                WithdrawStatus::WAITING_APPROVE->value,
                WithdrawStatus::SUCCEEDED->value,
            ])
            ->sum('amount');
    }

    public function getHistories($filter): mixed
    {
        return $this->model->newQuery()
            ->join('merchant_stores', 'withdraws.merchant_store_id', '=', 'merchant_stores.id')
            ->select(
                'withdraws.*',
                'merchant_stores.name as merchant_store_name',
                'merchant_stores.merchant_code as merchant_code'
            )
            ->when(!empty($filter->merchant_user_id), function ($query) use ($filter) {
                $query->whereHas('merchantStore.merchantUsers', function ($q) use ($filter) {
                    $q->where('merchant_user_id', '=', $filter->merchant_user_id);
                });
            })
            ->when(!empty($filter->transaction_id), function ($query) use ($filter) {
                $query->where('withdraws.id', '=', $filter->transaction_id);
            })
            ->when(!empty($filter->transaction_id), function ($query) use ($filter) {
                $query->where('withdraws.id', '=', $filter->transaction_id);
            })
            ->when(!empty($filter->order_id), function ($query) use ($filter) {
                $query->where('withdraws.order_id', '=', $filter->order_id);
            })
            ->when(!empty($filter->merchant_store_id), function ($query) use ($filter) {
                $query->where('merchant_code', (int) $filter->merchant_store_id);
            })
            ->when(!empty($filter->merchant_store_name), function ($query) use ($filter) {
                $query->whereHas('merchantStore', function ($q) use ($filter) {
                    $q->where('merchant_stores.name', 'like', "%$filter->merchant_store_name%");
                });
            })
            // search date request
            ->when(!empty($filter->request_date_from), function ($query) use ($filter) {
                $query->whereDate('withdraws.created_at', '>=', $filter->request_date_from);
            })
            ->when(!empty($filter->request_date_to), function ($query) use ($filter) {
                $query->whereDate('withdraws.created_at', '<=', $filter->request_date_to);
            })
            // search date approve
            ->when(!empty($filter->approve_time_from), function ($query) use ($filter) {
                $query->whereDate('withdraws.approve_datetime', '>=', $filter->approve_time_from)
                    ->where('withdraws.withdraw_status', '=', WithdrawStatus::SUCCEEDED);
            })
            ->when(!empty($filter->approve_time_to), function ($query) use ($filter) {
                $query->whereDate('withdraws.approve_datetime', '<=', $filter->approve_time_to)
                    ->where('withdraws.withdraw_status', '=', WithdrawStatus::SUCCEEDED);
            })
            // search amount
            ->when(isset($filter->amount_from), function ($query) use ($filter) {
                $query->where('withdraws.amount', '>=', $filter->amount_from);
            })
            ->when(isset($filter->amount_to), function ($query) use ($filter) {
                $query->where('withdraws.amount', '<=', $filter->amount_to);
            })
            // other cond
            ->when(!empty($filter->withdraw_request_method), function ($query) use ($filter) {
                $query->where('withdraws.withdraw_request_method', '=', $filter->withdraw_request_method);
            })
            ->when(!empty($filter->withdraw_method), function ($query) use ($filter) {
                $query->where('withdraws.withdraw_method', '=', $filter->withdraw_method);
            })
            ->when(!empty($filter->withdraw_status), function ($query) use ($filter) {
                if ($filter->withdraw_status == WithdrawStatus::WAITING_APPROVE->value)
                    return $query->whereIn('withdraws.withdraw_status', [
                        WithdrawStatus::WAITING_APPROVE->value,
                    ]);

                return $query->where('withdraws.withdraw_status', $filter->withdraw_status);
            })
            ->when(!empty($filter->asset), function ($query) use ($filter) {
                $query->where('withdraws.asset', '=', $filter->asset);
            })
            ->when(!empty($filter->withdraw_name), function ($query) use ($filter) {
                $query->where('withdraws.withdraw_name', 'like', "%$filter->withdraw_name%");
            })
            ->when(!empty($filter->filter_sort_by) && !empty($filter->filter_sort_direction), function ($query) use ($filter) {
                $query->orderBy($filter->filter_sort_by, $filter->filter_sort_direction);
            }, function ($query) {
                $query->orderBy('created_at', 'desc');
            });
    }

    public function totalMoneyWithdraw($cond): \Illuminate\Support\Collection
    {
        return $this->model->newQuery()
            ->select(
                'withdraw_method',
                DB::raw('SUM(amount) as total')
            )
            ->when(!empty($cond->withdraw_status), function ($query) use ($cond) {
                $query->where('withdraws.withdraw_status', '=', $cond->withdraw_status);
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
            ->groupBy('withdraw_method')
            ->pluck('total', 'withdraw_method');
    }

    /**
     * get totalWithdraw
     *
     * @param $merchantStoreId
     * @return mixed
     */
    public function totalWithdraw($merchantStoreId): mixed
    {
        return $this->model->newQuery()
            ->select(
                'withdraw_method',
                'asset',
                DB::raw('SUM(amount) as total')
            )
            ->where('withdraws.merchant_store_id', '=', $merchantStoreId)
            ->whereIn('withdraws.withdraw_status', [
                WithdrawStatus::WAITING_APPROVE->value,
                WithdrawStatus::SUCCEEDED->value
            ])
            ->groupBy('asset')
            ->get();
    }

    /**
     * get withdrawStatistic
     *
     * @param $filter
     * @return mixed
     */
    public function withdrawStatistic($cond): mixed
    {
        $data = $this->model->newQuery()
            ->when(!empty($cond->withdraw_request_method), function ($query) use ($cond) {
                $query->where('withdraws.withdraw_request_method', '=', $cond->withdraw_request_method);
            })
            ->when(!empty($cond->withdraw_method), function ($query) use ($cond) {
                $query->where('withdraws.withdraw_method', '=', $cond->withdraw_method);
            })
            ->when(!empty($cond->withdraw_status), function ($query) use ($cond) {
                $query->where('withdraws.withdraw_status', '=', $cond->withdraw_status);
            })
            ->when(!empty($cond->asset), function ($query) use ($cond) {
                $query->where('withdraws.asset', '=', $cond->asset);
            })
            ->when(!empty($cond->fee_asset), function ($query) use ($cond) {
                $query->where('withdraws.fee_asset', '=', $cond->fee_asset);
            })
            ->when(!empty($cond->start_date), function ($query) use ($cond) {
                $query->where('withdraws.created_at', '>=', $cond->start_date);
            })
            ->when(!empty($cond->end_date), function ($query) use ($cond) {
                $query->where('withdraws.created_at', '<=', $cond->end_date);
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
                    DB::raw('SUM(amount) as total_withdraw'),
                    DB::raw('SUM(fee) as total_fee'),
                    'asset',
                    'withdraw_method',
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time')
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
                $groupBy = $cond->group_by ?? 'amount';
                $query->groupBy($groupBy);
            }, function ($query) {
                $query->groupBy('time_number'); // use for dashboard
            })
            ->get();

        return $data;
    }

    public function getWithdrawHistory($id)
    {
        return $this->model->select(
            "withdraws.*",
        )
        ->with('merchantStore:id,name')
        ->findOrFail($id);
    }

    public function getCountAmount($merchantId, $paymentAsset)
    {
        return $this->model
            ->where("merchant_store_id",$merchantId)
            ->where("asset",$paymentAsset)
            ->whereIn("withdraw_status",[WithdrawStatus::WAITING_APPROVE->value, WithdrawStatus::SUCCEEDED->value])
            ->sum("amount");
    }

    public function updateStatusWithdraw($status, $Id, $transaction)
    {
        return self::where('id', $Id)
        ->update([
            'tgw_log' => json_encode($transaction),
            'withdraw_status' => $status,
            'approve_datetime' => $transaction['date_completed'],
        ]);
    }

    public function totalAmountForReport($merchant_store_id, $period_from, $period_to)
    {
        return $this->model
            ->select(
                'asset',
                DB::raw('SUM(CASE WHEN withdraw_status =  "' . WithdrawStatus::SUCCEEDED->value . '" THEN amount ELSE 0 END) as amount'),
                DB::raw('SUM(CASE WHEN withdraw_status =  "' . WithdrawStatus::SUCCEEDED->value . '" THEN fee ELSE 0 END) as fee'),
            )
            ->where('merchant_store_id',$merchant_store_id)
            ->whereBetween('created_at', [$period_from, $period_to])
            ->groupBy('asset')
            ->get();
    }
}
