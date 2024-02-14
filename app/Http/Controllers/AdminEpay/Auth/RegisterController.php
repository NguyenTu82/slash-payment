<?php

namespace App\Http\Controllers\AdminEpay\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;

class RegisterController extends Controller
{
    protected AdminService $adminService;

    public function __construct(
        AdminService $adminService
    ) {
        $this->adminService = $adminService;
    }

    public function registerIndex(Request $request)
    {
        return view('epay.auth.register.index');
    }

    public function registerProcess(Request $request)
    {
        try {
            $result = $this->adminService->registerAccount($request);
            if ($result) {
                return redirect()->route('admin_epay.auth.register.confirm.get');
            }

            return redirect()->back()->with('error', false)->withInput();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function registerConfirm(Request $request)
    {
        return view('epay.auth.register.register_confirm');
    }

    public function verifyRegisterAccount($id, $token)
    {
        try {
            // Process save data
            $response = $this->adminService->verifyRegisterAccount($id, $token);
            if ($response['status'] === true) {
                auth('merchant')->logout();

                return view(
                    'epay.auth.register.register_success',
                );
            }

            return redirect()->route('admin_epay.auth.login')->with('error', $response['messages']);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
