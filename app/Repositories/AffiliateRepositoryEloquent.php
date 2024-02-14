<?php

namespace App\Repositories;

use App\Models\Affiliate;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class MerchantStoreRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class AffiliateRepositoryEloquent extends BaseRepository implements AffiliateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Affiliate::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function totalAffiliates($cond)
    {
        return $this->model->newQuery()
            ->select(
                DB::raw('count(*) as count'),
            )
            ->when(!empty($cond->start_date), function ($query) use ($cond) {
                $query->where('created_at', '>=', $cond->start_date);
            })
            ->when(!empty($cond->end_date), function ($query) use ($cond) {
                $query->where('created_at', '<=', $cond->end_date);
            })
            ->when(!empty($cond->store_ids), function ($query) use ($cond) {
                $query->whereIn('id', function ($query) use ($cond) {
                    $query->select('affiliate_id')
                        ->from('merchant_stores')
                        ->whereIn('id', $cond->store_ids);
                });
            })
            ->count();
    }
}
