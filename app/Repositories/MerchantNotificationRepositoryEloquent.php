<?php

namespace App\Repositories;

use App\Enums\MerchantStoreStatus;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MerchantNotificationRepository;
use App\Models\MerchantNoti;
use App\Models\MerchantGroup;
use App\Validators\MerchantNotificationValidator;

/**
 * Class MerchantNotificationRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MerchantNotificationRepositoryEloquent extends BaseRepository implements MerchantNotificationRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MerchantNoti::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getNotiByMerchantId($query)
    {
        $merchant = auth('merchant')->user();
        $merchantStoreIds = MerchantGroup::query()
            ->join('merchant_stores', 'merchant_groups.merchant_store_id', '=', 'merchant_stores.id')
            ->where('merchant_stores.status', MerchantStoreStatus::IN_USE->value)
            ->where('merchant_user_id', $merchant->id)
            ->pluck('merchant_store_id')->all();
        return $this->model->newQuery()
            ->whereIn('merchant_id', $merchantStoreIds)
            ->with('merchantStore')
            ->when(isset($query->merchant_store_id), function ($q) use ($query) {
                $q->where('merchant_id', $query->merchant_store_id);
            })
            ->when(isset($query->status), function ($q) use ($query) {
                $q->where('status', (int) $query->status);
            })
            ->when(isset($query->type), function ($q) use ($query) {
                $q->where('type', (int) $query->type);
            })
            ->when(isset($query->title), function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query->title . '%');
            })
            ->when(isset($query->content), function ($q) use ($query) {
                $q->where('content', 'like', '%' . $query->content . '%');
            })
            ->when(isset($query->send_date_from), function ($q) use ($query) {
                $q->whereDate('send_date', '>=', $query->send_date_from);
            })
            ->when(isset($query->send_date_to), function ($q) use ($query) {
                $q->whereDate('send_date', '<=', $query->send_date_to);
            })
            ->orderByDesc('send_date');
    }

    public function getNotiDetail($id)
    {
        return $this->model->findOrFail($id);
    }

    public function deleteNotiById($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

    public function insert($notifications): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery()->create($notifications);
    }
}
