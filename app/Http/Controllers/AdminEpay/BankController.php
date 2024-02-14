<?php

namespace App\Http\Controllers\AdminEpay;

use App\Http\Controllers\Controller;
use App\Services\Bank\BankService;
use Illuminate\Http\Request;

class BankController extends Controller
{
    private BankService $bankService;

    public function __construct(
        BankService $bankService
    )
    {
        $this->bankService = $bankService;
    }

    public function checkBankCode(Request $request)
    {
        $status = $this->bankService->getBank($request->bank_code);
        if ($status->hasError()){
            return response()->json(["status" => false]);
        }
        return response()->json([
            "status" => true,
            "data" => $status->getResult()
        ]);
    }

    public function checkBranchBankCode(Request $request)
    {
        $status = $this->bankService->getBranchBank($request->bank_code,$request->branch_code);
        if ($status->hasError()){
            return response()->json(["status" => false]);
        }
        return response()->json([
            "status" => true,
            "data" => $status->getResult()
        ]);
    }

}
