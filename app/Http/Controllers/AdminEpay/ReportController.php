<?php

namespace App\Http\Controllers\AdminEpay;

use App\Enums\WithdrawMethod;
use App\Exports\EpayMerchantReportExport;
use App\Http\Controllers\Controller;
use App\Services\Epay\ReportService;
use App\Services\Merchant\MerchantStoreService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Exception;

class ReportController extends Controller
{
    private ReportService $reportService;

    private MerchantStoreService $merchantStoreService;

    public function __construct(
        ReportService $reportService,
        MerchantStoreService $merchantStoreService,
    ) {
        $this->reportService = $reportService;
        $this->merchantStoreService = $merchantStoreService;
    }

    public function index(Request $request): Factory|View|Response|BinaryFileResponse|Application|RedirectResponse
    {
        $queryParams = (object) $request->query();
        $baseDataList = $this->reportService->getList($queryParams);
        $dataList = $baseDataList->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $dataList->appends($request->toArray());
        $merchantsList = $this->merchantStoreService->getAllMerchantStores();

        if ($request->merchant_store_id) {
            $this->reportService->createReport(
                $request->merchant_store_id,
                $request->create_issue_date_from,
                $request->create_issue_date_to
            );

            return redirect()->route('admin_epay.report.index.get')->with('success', 'create_report_success');
        }

        if ($request->export_csv) {
            $export = new EpayMerchantReportExport($baseDataList->get());

            return $export->download('report_' . date('YmdHis') . '.csv')
                ->deleteFileAfterSend(true);
        }

        return view('epay.report.index', compact('dataList', 'request', 'merchantsList'));
    }

    public function detail($id): View
    {
        $report = $this->reportService->getReportById($id);
        $crypto_asset = '';
        $merchant = $this->merchantStoreService->findDataMerchantById($report->merchantStore->id);
        if ($merchant->withdraw_method === WithdrawMethod::CRYPTO->value) {
            $crypto_asset = $merchant->slashApi->receive_crypto_type;
        }
        $attachFilePath = Storage::disk('s3')->get($report->pdf_link);
        $base64Content = base64_encode($attachFilePath);
        return view('epay.report.detail', compact('report', 'base64Content', 'crypto_asset'));
    }

    public function edit($id): View
    {
        $report = $this->reportService->getReportById($id);
        $attachFilePath = Storage::disk('s3')->get($report->pdf_link);
        $base64Content = base64_encode($attachFilePath);

        return view('epay.report.edit', compact('report', 'base64Content'));
    }

    public function editReport(Request $request, $id): RedirectResponse
    {
        try {
            // Process save data
            $this->reportService->updateReport($request, $id);

            return redirect()->route('admin_epay.report.detail.get', $id)->with('success', 'update_report_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function deleteReport($id): RedirectResponse
    {
        try {
            // Process save data
            $this->reportService->deleteReport($id);

            return redirect()->route('admin_epay.report.index.get')->with('success', 'delete_report_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function sendMail(Request $request): RedirectResponse
    {
        try {
            // Process send email
            $this->reportService->sendEmail($request->report_id);

            if ($request->type == 'detail') {
                return redirect()->route('admin_epay.report.detail.get', $request->report_id)
                    ->with('success', 'send_report_success');
            }

            return redirect()->route('admin_epay.report.index.get')->with('success', 'send_report_success');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}