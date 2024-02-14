<?php

namespace App\Repositories;

use App\Models\Withdraw;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MerchantStoreRepository;
use App\Models\MerchantStore;
use App\Enums\WithdrawStatus;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayWithdrawRepositoryEloquent extends BaseRepository implements EpayWithdrawRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
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

    public function getHistories($filter): Builder|null
    {
        return $this->model->newQuery()
            ->join('merchant_stores', 'withdraws.merchant_store_id', '=', 'merchant_stores.id')
            ->select(
                'withdraws.*',
                'merchant_stores.name as merchant_store_name',
                'merchant_stores.merchant_code'
            )
            // 取引ID
            ->when(!empty($filter->transaction_id), function ($query) use ($filter) {
                $query->where('withdraws.id', 'like', "%$filter->transaction_id%");
            })
            // 申請ID
            ->when(!empty($filter->order_id), function ($query) use ($filter) {
                $query->where('withdraws.order_id', 'like', "%$filter->order_id%");
            })
            // 加盟店ID
            ->when(!empty($filter->merchant_store_id), function ($query) use ($filter) {
                $query->where('merchant_code', (int) $filter->merchant_store_id);
            })
            // 加盟店名
            ->when(!empty($filter->merchant_store_name), function ($query) use ($filter) {
                $query->where('merchant_stores.name', 'like', "%$filter->merchant_store_name%");
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
            // search withdraw amount
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
                $query->where('withdraws.withdraw_status', '=', $filter->withdraw_status);
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

    /**
     * get totalMoneyWithdraw
     *
     * @param $filter
     * @return mixed
     */
    public function totalMoneyWithdraw($cond): mixed
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
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_ids);
            })
            ->groupBy('withdraw_method')
            ->pluck('total', 'withdraw_method');
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
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('merchant_store_id', $cond->store_ids);
            })
            ->when(!empty($cond->view_type), function ($query) use ($cond) {
                switch ($cond->view_type) {
                    case 'by_month':
                        $query->select(
                            DB::raw('count(*) as count'),
                            DB::raw('SUM(amount) as total_withdraw'),
                            DB::raw('SUM(fee) as total_fee'),
                            DB::raw('DATE_FORMAT(created_at, "%m") as time_number'),
                            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            'asset',
                            'withdraw_method',
                        );
                        break;
                    case 'by_day':
                        $query->select(
                            DB::raw('count(*) as count'),
                            DB::raw('SUM(amount) as total_withdraw'),
                            DB::raw('SUM(fee) as total_fee'),
                            DB::raw('DATE_FORMAT(created_at, "%d") as time_number'),
                            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            'asset',
                            'withdraw_method',
                        );
                        break;
                    case 'by_hour':
                        $query->select(
                            DB::raw('count(*) as count'),
                            DB::raw('SUM(amount) as total_withdraw'),
                            DB::raw('SUM(fee) as total_fee'),
                            DB::raw('DATE_FORMAT(created_at, "%H") as time_number'),
                            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            'asset',
                            'withdraw_method',
                        );
                        break;
                    default:
                        $query->select(
                            DB::raw('count(*) as count'),
                            DB::raw('SUM(amount) as total_withdraw'),
                            DB::raw('SUM(fee) as total_fee'),
                            DB::raw('DATE_FORMAT(created_at, "%Y") as time_number'),
                            DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            'asset',
                            'withdraw_method',
                        );
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
        // dd($data->toArray());
    }

    public function getWithdrawHistory($id)
    {
        return $this->model->select(
            "merchant_stores.name as merchant_store_name",
            "merchant_stores.merchant_code as merchant_code",
            "withdraws.id as withdraws_id",
            "withdraws.*",
        )
            ->join('merchant_stores', 'withdraws.merchant_store_id', '=', 'merchant_stores.id')
            ->leftJoin('fiat_withdraw_accounts', 'merchant_stores.id', '=', 'fiat_withdraw_accounts.merchant_store_id')
            ->leftJoin('crypto_withdraw_accounts', 'merchant_stores.id', '=', 'crypto_withdraw_accounts.merchant_store_id')
            ->leftJoin('slash_apis', 'merchant_stores.id', '=', 'slash_apis.merchant_store_id')
            ->where('withdraws.id', $id)
            ->first();

    }

}
