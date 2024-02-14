<?php

namespace App\Repositories;

use App\Enums\MerchantStoreStatus;
use App\Models\MerchantGroup;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\EpayReportRepository;
use App\Models\EpayReport;
use App\Validators\EpayReportValidator;
use Carbon\Carbon;

/**
 * Class EpayReportRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class EpayReportRepositoryEloquent extends BaseRepository implements EpayReportRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return EpayReport::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function getList($request): \Illuminate\Database\Eloquent\Builder
    {
        return $this->model->newQuery()
            ->select(
                'epay_reports.*',
                'merchant_stores.name as merchant_store_name',
                'merchant_stores.merchant_code as merchant_code',
            )
            ->join('merchant_stores','merchant_stores.id','=','epay_reports.merchant_store_id')
            ->whereIn('merchant_stores.status', [
                MerchantStoreStatus::IN_USE->value,
                MerchantStoreStatus::TEMPORARILY_REGISTERED->value,
                MerchantStoreStatus::UNDER_REVIEW->value
            ])
            ->when(!empty($request->report_code), function ($query) use ($request) {
                $query->where('epay_reports.report_code', 'like', "%$request->report_code%");
            })
            ->when(!empty($request->merchant_code), function ($query) use ($request) {
                $query->where('merchant_code', (int)$request->merchant_code);
            })
            ->when(!empty($request->merchant_name), function ($query) use ($request) {
                $query->where('merchant_stores.name', 'like', "%$request->merchant_name%");
            })
            ->when(!empty($request->email), function ($query) use ($request) {
                $query->where('epay_reports.send_email', 'like', "%$request->email%");
            })
            ->when(!empty($request->issue_date_from), function ($query) use ($request) {
                $query->whereDate('epay_reports.issue_date', '>=', $request->issue_date_from);
            })
            ->when(!empty($request->issue_date_to), function ($query) use ($request) {
                $query->whereDate('epay_reports.issue_date', '<=', $request->issue_date_to);
            })
            ->when(isset($request->status), function ($query) use ($request) {
                $query->where('epay_reports.status', $request->status);
            })

            ->orderByDesc('issue_date');
    }

    public function getReportById($id){
        return $this->model->select(
            "epay_reports.*",
        )
            ->with('merchantStore')
            ->where('id', $id)
            ->findOrFail($id);
    }
}
