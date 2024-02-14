<?php

namespace App\Repositories;

use App\Models\EpayReceiveNoti;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class EpayNotiRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayNotiRepositoryEloquent extends BaseRepository implements EpayNotiRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EpayReceiveNoti::class;
    }

    /**
     * @param $request
     * @return mixed
     */
    public function getListReceive($request)
    {   
        return $this->model->select(
            "epay_receive_notification.*",
            "merchant_stores.name",
            "merchant_stores.merchant_code",
            "epay_receive_notification_format.type"
        )
            ->join('merchant_stores', 'merchant_stores.id', 'epay_receive_notification.merchant_id')
            ->join('epay_receive_notification_format', 'epay_receive_notification_format.id', 'epay_receive_notification.format_type_id')
            ->when(isset($request->type_receive), function ($query) use ($request) {
                $query->where('epay_receive_notification_format.type', $request->type_receive);
            })
            ->when(isset($request->status_receive), function ($query) use ($request) {
                $query->where('epay_receive_notification.status', $request->status_receive);
            })
            ->when(isset($request->merchant_id), function ($query) use ($request) {
                $query->where('merchant_stores.merchant_code', (int)$request->merchant_id);
            })
            ->when(isset($request->merchant_name), function ($query) use ($request) {
                $query->where('merchant_stores.name', 'like', '%' . $request->merchant_name . '%');
            })
            ->when(isset($request->send_date_from), function ($query) use ($request) {
                $query->whereDate('send_date', '>=', $request->send_date_from);
            })
            ->when(isset($request->send_date_to), function ($query) use ($request) {
                $query->whereDate('send_date', '<=', $request->send_date_to);
            })
            ->orderBy('send_date', 'desc');
    }

    public function getReceivedNotiDetail($id)
    {
        return $this->model->select(
            "epay_receive_notification.*",
            "merchant_stores.name",
            "merchant_stores.merchant_code",
            "merchant_users.email",
            "epay_receive_notification_format.type"
        )
            ->join('merchant_stores', 'merchant_stores.id', 'epay_receive_notification.merchant_id')
            ->join('merchant_users', 'merchant_users.id', 'merchant_stores.merchant_user_owner_id')
            ->join('epay_receive_notification_format', 'epay_receive_notification_format.id', 'epay_receive_notification.format_type_id')
            ->where('epay_receive_notification.id', $id)
            ->first();
    }

    public function deleteReceivedNotiById($id)
    {
        return $this->model->findOrFail($id)->delete();
    }

}
