<?php

namespace App\Repositories;

use App\Models\MerchantStore;
use App\Enums\MerchantStoreStatus;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MerchantStoreRepositoryEloquent extends BaseRepository implements MerchantStoreRepository
{
    public function model(): string
    {
        return MerchantStore::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getMerchantStores($request)
    {
        return $this->model->newQuery()
            ->with(["affiliate", "parent", "slashApi", "merchantOwner", "groups", "paymentSuccesses", "exchangeRate"])
            ->withSum('paymentSuccesses', 'payment_amount')
            ->when(isset($request->id), function ($q) use ($request) {
                $q->where('merchant_code', 'like', '%' . $request->id . '%');
            })
            ->when(isset($request->name), function ($q) use ($request) {
                $q->where('merchant_stores.name', 'like', '%' . $request->name . '%');
            })
            ->when(isset($request->email), function ($q) use ($request) {
                $q->join('merchant_users', 'merchant_users.id', '=', 'merchant_user_owner_id')
                    ->where('merchant_users.email', 'like', '%' . $request->email . '%')
                    ->select('merchant_users.email', 'merchant_stores.*');
            })
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('merchant_stores.status', $request->status);
            })
            ->when(isset($request->payment_cycle), function ($q) use ($request) {
                $q->where('payment_cycle', $request->payment_cycle);
            })
            ->when(isset($request->withdraw_method), function ($q) use ($request) {
                $q->where('withdraw_method', $request->withdraw_method);
            })
            ->when(isset($request->af_id), function ($q) use ($request) {
                $q->where('affiliate_id', 'like', '%' . $request->af_id . '%');
            })
            ->when(isset($request->group), function ($q) use ($request) {
                $list_child_id = DB::table('merchant_stores')->where('merchant_stores.name', 'like', '%' . $request->group . '%')->pluck('id');
                $list_parent_id = DB::table('group_merchants')->whereIn('group_merchants.merchant_children_store_id', $list_child_id)->pluck('group_merchants.merchant_parent_store_id');
                $q->whereIn('merchant_stores.id', $list_parent_id)->select('merchant_stores.*');
            })
            ->when(isset($request->sort_name) and isset($request->sort_type), function ($q) use ($request) {
                if ($request->sort_name == 'groups') {
                    $value_search = 'merchant_stores.name';
                } elseif ($request->sort_name == 'account_balance') {
                    $value_search = 'cash_payments.account_balance';
                } elseif ($request->sort_name == 'paid_balance') {
                    $value_search = 'cash_payments.paid_balance';
                } elseif ($request->sort_name == 'email') {
                    $value_search = 'merchant_users.email';
                } else
                    $value_search = $request->sort_name;

                $q->when($request->sort_name == 'account_balance', function ($q){
                        $q->join('cash_payments', 'cash_payments.merchant_store_id', '=', 'merchant_stores.id')
                        ->select('cash_payments.account_balance', 'merchant_stores.*');
                    })
                    ->when($request->sort_name == 'paid_balance', function ($q){
                        $q->join('cash_payments', 'cash_payments.merchant_store_id', '=', 'merchant_stores.id')
                        ->select('cash_payments.paid_balance', 'merchant_stores.*');
                    })
                    ->when(!isset($request->email) and $request->sort_name == 'email', function ($q){
                        $q->join('merchant_users', 'merchant_users.id', '=', 'merchant_user_owner_id')
                        ->select('merchant_users.email', 'merchant_stores.*');
                    })
                    ->when($value_search and $request->sort_type == "desc", function ($q) use ($value_search) {
                        $q->orderByDesc($value_search);
                    })
                    ->when($value_search and $request->sort_type == "asc", function ($q) use ($value_search) {
                        $q->orderBy($value_search);
                    });
            }, function ($q) {
            $q->orderByDesc('merchant_code');
        });
    }

    public function getAllMerchantStores(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->newQuery()->whereNotNull('merchant_user_owner_id')
            ->with('merchantOwner')
            ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value)
            ->get();
    }

    public function merchantStoreActiveIds(): array
    {
        return $this->model->newQuery()
            ->whereIn('status', [
                MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                MerchantStoreStatus::UNDER_REVIEW->value,
                MerchantStoreStatus::IN_USE->value,
            ])
            ->pluck('id')
            ->toArray();
    }

    public function getMerchantStoresByIds($merchantStoreIds): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->newQuery()->whereNotNull('merchant_user_owner_id')
            ->whereIn('id', $merchantStoreIds)
            ->with('merchantOwner')
            ->get();
    }

    public function totalMerchantStores($cond): int
    {
        return $this->model->newQuery()
            ->select(
                DB::raw('count(*) as count'),
            )
            ->when(!empty($cond->status) && is_array($cond->status), function ($query) use ($cond) {
                $query->whereIn('status', $cond->status);
            })

            ->when(isset($cond->cancleMechantFlag), function ($q) use ($cond) {
                $q->when(!empty($cond->start_date), function ($query) use ($cond) {
                    $query->where('updated_at', '>=', $cond->start_date);
                })
                ->when(!empty($cond->end_date), function ($query) use ($cond) {
                    $query->where('updated_at', '<=', $cond->end_date);
                });
            })
            ->when(!isset($cond->cancleMechantFlag), function ($q) use ($cond) {
                $q->when(!empty($cond->start_date), function ($query) use ($cond) {
                    $query->where('created_at', '>=', $cond->start_date);
                })
                ->when(!empty($cond->end_date), function ($query) use ($cond) {
                    $query->where('created_at', '<=', $cond->end_date);
                });
            })
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('id', $cond->store_ids);
            })
            ->count();
    }

    public function createMerchantStore($data)
    {
        return true;
    }

    public function getAllMerchantStoresNotParentWithoutId($id): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->newQuery()
            ->whereRaw('id not in (select merchant_parent_store_id from group_merchants where deleted_at is null)')
            ->whereRaw("id not in (select merchant_children_store_id from group_merchants where deleted_at is null and merchant_parent_store_id != '" . $id . "')")
            ->where('id', '!=', $id)
            ->get();
    }

    public function getMerchantStoreById($id): mixed
    {
        return $this->model->newQuery()->findOrFail($id);
    }

    public function updateWhenDeleteGroup($id): void
    {
        $this->model->newQuery()
            ->where("merchant_parent_store_id", $id)
            ->update(["merchant_parent_store_id" => null]);
    }

    public function merchantStoreStatistic($cond): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->newQuery()
            ->when(!empty($cond->status), function ($query) use ($cond) {
                $query->whereIn('status', $cond->status);
            })

            ->when(isset($cond->cancleMechantFlag), function ($q) use ($cond) {
                $q->when(!empty($cond->start_date), function ($query) use ($cond) {
                    $query->where('updated_at', '>=', $cond->start_date);
                })
                ->when(!empty($cond->end_date), function ($query) use ($cond) {
                    $query->where('updated_at', '<=', $cond->end_date);
                })
                ->when(!empty($cond->view_type), function ($query) use ($cond) {
                    switch ($cond->view_type) {
                        case 'by_month':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(updated_at, "%m") as time_number'),
                                DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d %H:%i:%s") as date_time')
                            );
                            break;
                        case 'by_day':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(updated_at, "%d") as time_number'),
                                DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                        case 'by_hour':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(updated_at, "%H") as time_number'),
                                DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                        default:
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(updated_at, "%Y") as time_number'),
                                DB::raw('DATE_FORMAT(updated_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                    }
                });
            })
            ->when(!isset($cond->cancleMechantFlag), function ($q) use ($cond) {
                $q->when(!empty($cond->start_date), function ($query) use ($cond) {
                    $query->where('created_at', '>=', $cond->start_date);
                })
                ->when(!empty($cond->end_date), function ($query) use ($cond) {
                    $query->where('created_at', '<=', $cond->end_date);
                })
                ->when(!empty($cond->view_type), function ($query) use ($cond) {
                    switch ($cond->view_type) {
                        case 'by_month':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(created_at, "%m") as time_number'),
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time')
                            );
                            break;
                        case 'by_day':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(created_at, "%d") as time_number'),
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                        case 'by_hour':
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(created_at, "%H") as time_number'),
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                        default:
                            $query->select(
                                DB::raw('count(*) as count'),
                                DB::raw('DATE_FORMAT(created_at, "%Y") as time_number'),
                                DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
                            );
                            break;
                    }
                });
            })
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('id', $cond->store_ids);
            })
            ->groupBy('time_number')
            ->get();
    }

    public function getAllMerchantStoresNotParent()
    {
        return $this->model
            ->whereRaw('id not in (select merchant_parent_store_id from group_merchants where deleted_at is null)')
            ->whereRaw('id not in (select merchant_children_store_id from group_merchants where deleted_at is null)')
            ->get();
    }
}