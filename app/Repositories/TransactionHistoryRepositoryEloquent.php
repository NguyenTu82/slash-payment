<?php

namespace App\Repositories;

use App\Enums\WithdrawAsset;
use App\Enums\TransactionHistoryPaymentStatus;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\TransactionHistoryRepository;
use App\Models\TransactionHistory;
use App\Models\PaymentSuccess;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

/**
 * Class TransactionHistoryRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class TransactionHistoryRepositoryEloquent extends BaseRepository implements TransactionHistoryRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TransactionHistory::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function findTransactionHistories($request)
    {
        return $this->model
            ->with("paymentSuccess")
            ->when(isset($request->merchant_store_id), function ($q) use ($request) {
                $q->where('merchant_store_id', $request->merchant_store_id);
            })
            ->when(isset($request->merchantStoresIds), function ($q) use ($request) {
                $q->whereIn('merchant_store_id', $request->merchantStoresIds);
            })
            ->when(isset($request->trans_id), function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->trans_id . '%');
            })
            // query by date request
            ->when(isset($request->startDateRequest) and isset($request->endDateRequest), function ($q) use ($request) {
                $q->whereBetween('transaction_date', [Carbon::parse($request->startDateRequest), Carbon::parse($request->endDateRequest)->addDay()]);
            })
            ->when(isset($request->startDateRequest) and !isset($request->endDateRequest), function ($q) use ($request) {
                $maxDay = $this->model->max('transaction_date');
                $formatDay = Carbon::parse($maxDay);
                $q->whereBetween('transaction_date', [Carbon::parse($request->startDateRequest), $formatDay->addDay()]);
            })
            ->when(!isset($request->startDateRequest) and isset($request->endDateRequest), function ($q) use ($request) {
                $minDay = $this->model->min('transaction_date');
                $formatDay = Carbon::parse($minDay);
                $q->whereBetween('transaction_date', [$formatDay, Carbon::parse($request->endDateRequest)->addDay()]);
            })
            ->when(!isset($request->startDateRequest) and !isset($request->endDateRequest), function ($q) use ($request) {
                $timeNow = Carbon::now();
                $startOfMonth = Carbon::now()->startOfMonth();
                $q->whereBetween('transaction_histories.transaction_date', [$startOfMonth, $timeNow]);
            })

            // query by date payment
            ->when(isset($request->startDatePayment) and isset($request->endDatePayment), function ($q) use ($request) {
                $q->whereBetween('payment_success_datetime', [Carbon::parse($request->startDatePayment), Carbon::parse($request->endDatePayment)->addDay()]);
            })
            ->when(isset($request->startDatePayment) and !isset($request->endDatePayment), function ($q) use ($request) {
                $maxDay = $this->model->max('payment_success_datetime');
                $formatDay = Carbon::parse($maxDay);
                $q->whereBetween('payment_success_datetime', [Carbon::parse($request->startDatePayment), $formatDay->addDay()]);
            })
            ->when(!isset($request->startDatePayment) and isset($request->endDatePayment), function ($q) use ($request) {
                $minDay = $this->model->min('payment_success_datetime');
                $formatDay = Carbon::parse($minDay);
                $q->whereBetween('payment_success_datetime', [$minDay, Carbon::parse($request->endDatePayment)->addDay()]);
            })

            ->when(isset($request->network), function ($q) use ($request) {
                $q->where('network', $request->network);
            })
            ->when(isset($request->request_method), function ($q) use ($request) {
                $q->where('request_method', $request->request_method);
            })

            // query by money unit and price
            ->when(!isset($request->unit), function ($q) use ($request) {
                $q->when(isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                    $q->whereBetween('payment_amount', [$request->startAmount, $request->endAmount]);
                })
                    ->when(isset($request->startAmount) and !isset($request->endAmount), function ($q) use ($request) {
                        $maxAmountPayment = $this->model->max('payment_amount');
                        $q->whereBetween('payment_amount', [$request->startAmount, $maxAmountPayment]);
                    })
                    ->when(!isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $minAmountPayment = $this->model->min('payment_amount');
                        $q->whereBetween('payment_amount', [$minAmountPayment, $request->endAmount]);
                    });
            })

            ->when(isset($request->unit) and Str::contains($request->unit, 'p'), function ($q) use ($request) {
                $q->where('payment_asset', Str::after($request->unit, 'p'))
                    ->when(isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $q->whereBetween('payment_amount', [$request->startAmount, $request->endAmount]);
                    })
                    ->when(isset($request->startAmount) and !isset($request->endAmount), function ($q) use ($request) {
                        $maxAmount = $this->model->max('payment_amount');
                        $q->whereBetween('payment_amount', [$request->startAmount, $maxAmount]);
                    })
                    ->when(!isset($request->startAmount) and isset($request->endAmount), function ($q) use ($request) {
                        $minAmount = $this->model->min('payment_amount');
                        $q->whereBetween('payment_amount', [$minAmount, $request->endAmount]);
                    });
            })
            ->when(isset($request->status), function ($q) use ($request) {
                $q->where('payment_status', $request->status);
            })
            ->when(isset($request->hash), function ($q) use ($request) {
                $q->where('hash', 'like', '%' . $request->hash . '%');
            })
            ->when(isset($request->sort_name) and isset($request->sort_type), function ($q) use ($request) {
                if (strpos($request->sort_name, "-")) {
                    $value_search = explode('-', $request->sort_name);
                    $q->when($request->sort_type == "desc", function ($q) use ($value_search) {
                        $q->orderByDesc($value_search[0]);
                        $q->orderByDesc($value_search[1]);
                    })
                        ->when($request->sort_type == "asc", function ($q) use ($value_search) {
                            $q->orderBy($value_search[0]);
                            $q->orderBy($value_search[1]);
                        });
                } elseif ($request->sort_name == 'merchant_code' or $request->sort_name == 'name') {
                    $q->join('merchant_stores', 'merchant_stores.id', '=', 'transaction_histories.merchant_store_id')
                        ->select('merchant_stores.name', 'merchant_stores.merchant_code', 'transaction_histories.*')
                        ->when($request->sort_type == "desc", function ($q) use ($request) {
                            $q->orderByDesc('merchant_stores.'.$request->sort_name);
                        })
                            ->when($request->sort_type == "asc", function ($q) use ($request) {
                                $q->orderBy('merchant_stores.'.$request->sort_name);
                            });
                } else
                    $q->when($request->sort_type == "desc", function ($q) use ($request) {
                        $q->orderByDesc($request->sort_name);
                    })
                        ->when($request->sort_type == "asc", function ($q) use ($request) {
                            $q->orderBy($request->sort_name);
                        });
            }, function ($q) {
            $q->orderBy('transaction_date', 'desc');
        });
    }

    /**
     * get transStatistic
     *
     * @param $cond
     * @return array|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function transStatistic($cond)
    {
        $data = $this->model->newQuery()
            ->when(!empty($cond->payment_status), function ($query) use ($cond) {
                $query->where('payment_status', '=', $cond->payment_status);
            })
            ->when(!empty($cond->payment_asset), function ($query) use ($cond) {
                $query->where('payment_asset', '=', $cond->payment_asset);
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
                    DB::raw('SUM(payment_amount) as total_amount'),
                    DB::raw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i:%s") as date_time'),
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
            ->groupBy('time_number')
            ->get();

        return $data;
        // dd($data->toArray());
    }
}