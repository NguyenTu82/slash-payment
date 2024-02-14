<?php

namespace App\Http\Controllers\AdminEpay;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SettingService;
use App\Services\AdminService;
use App\Form\AdminCustomValidator;

use Exception;

/**
 * Class SettingController.
 *
 * @package namespace App\Http\Controllers\AdminEpay;
 */
class SettingController extends Controller
{
    protected SettingService $settingService;
    protected AdminService $adminService;

    private AdminCustomValidator $form;

    public function __construct(
        SettingService $settingService,
        AdminService $adminService,
        AdminCustomValidator $form
    ) {
        $this->settingService = $settingService;
        $this->adminService = $adminService;
        $this->form = $form;
    }

    public function createAccount(Request $request)
    {
        $roles = $this->adminService->getRoles();

        if ($request->isMethod('post')) {
            try {
                // Validate inputs
                $this->form->validate(
                    $request,
                    'AdminAddForm'
                );
                // Process save data
                $response = $this->adminService->saveDataAdmin($request);
                if ($response === true) {
                    return redirect()->back()->withInput()->with('success', 'Create success fully');
                }
                return redirect()->back()->withInput()->with('error', $response);
            } catch (Exception $e) {
                return redirect()->back()->withInput()->with('error', $e->getMessage());
            }
        }

        return view('epay.admin.create', compact('roles'));
    }

    public function detail($id)
    {
        $admin = $this->adminService->getAdminById($id);
        $roles = $this->adminService->getRoles();
        // dd($roles);
        return view("epay.setting.detail", [
            "adminUser" => $admin,
            "dataRoles" => $roles,

        ]);
    }

    public function removeAccount(Request $request)
    {
        if (!($request->ids ?? '')) {
            return redirect()->back();
        }
        try {
            // Remove ID Admin
            $response = $this->adminService->delete($request);
            if ($response === true) {
                return redirect()->route('admin_epay.admin.index')->with('success', 'Delete success fully');
            }
            return redirect()->back()->with('error', $response);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
