<?php

namespace App\Repositories;

use App\Enums\NotiStatusSend;
use App\Models\EpaySendNoti;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Collection;
use Carbon\Carbon;

/**
 * Class EpayNotiSendRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayNotiSendRepositoryEloquent extends BaseRepository implements EpayNotiSendRepository
{
    public function model(): string
    {
        return EpaySendNoti::class;
    }

    public function getListSend($request)
    {
        return $this->model->newQuery()->select('epay_send_notification.*',)
            ->when(isset($request->type_send), function ($query) use ($request) {
                $query->where('epay_send_notification.type', $request->type_send);
            })
            ->when(isset($request->status_send), function ($query) use ($request) {
                $query->where('epay_send_notification.status', $request->status_send);
            })
            ->when(isset($request->title), function ($query) use ($request) {
                $query->where('epay_send_notification.title', $request->title);
            })
            ->when(isset($request->send_date_from), function ($query) use ($request) {
                $query->whereDate('actual_send_date', '>=', $request->send_date_from);
            })
            ->when(isset($request->send_date_to), function ($query) use ($request) {
                $query->whereDate('actual_send_date', '<=', $request->send_date_to);
            })
            ->orderBy('created_at', 'desc');
    }

    public function getScheduleSend(): Collection|array
    {
        return $this->model->newQuery()
            ->where('status', NotiStatusSend::UNSEND->value)
            ->where('schedule_send_date', Carbon::now()->startOfMinute())
            ->get();
    }
}
