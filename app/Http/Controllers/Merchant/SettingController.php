<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Services\Merchant\MerchantService;
use Illuminate\Http\Request;
use App\Form\Merchant\BaseValidatorCustom;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use App\Services\Merchant\MerchantStoreService;

class SettingController extends Controller
{
    private BaseValidatorCustom $form;

    private MerchantService $merchantService;

    protected MerchantStoreService $merchantStoreService;

    public function __construct(
        BaseValidatorCustom $form,
        MerchantService $merchantService,
        MerchantStoreService $merchantStoreService,
    )
    {
        $this->form = $form;
        $this->merchantService = $merchantService;
        $this->merchantStoreService = $merchantStoreService;
    }

    public function getProfile(Request $request): View
    {
        $roles = $this->merchantService->getAllRoles();
        $profileInfo = auth('merchant')->user();
        $allMerchantStores = $profileInfo->merchantStores;

        return view('merchant.setting.profile', compact(
            'roles',
            'allMerchantStores',
            'profileInfo'
        ));
    }

    public function changePass(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->form->validate($request, 'ChangPasswordForm');
        $data =  ['password' => Hash::make($request->password)];

        return $this->merchantService->changePassword($data);
    }

    public function updateProfile(Request $request): \Illuminate\Http\JsonResponse|array
    {
        $this->form->validate(
            $request,
            'UpdateProfileForm'
        );

        $data = $request->only('name', 'email', 'merchant_role_id', 'note', 'store_ids');

        return $this->merchantService->updateProfile($data);
    }

    public function getAccountInitSetting(Request $request)
    {
        $merchant_id = $request->id ?? auth('merchant')->user()->getMerchantStore()->first()->id;
        $storesAssigned = $this->merchantService->getStoresAssigned();
        $dataMerchant = $this->merchantStoreService->findDatamerchantByid($merchant_id);

        $merchantStores = count($dataMerchant->parent) > 0 ? [] : $this->merchantStoreService->getAllMerchantStoresNotParentWithoutId($merchant_id);
        $groups = count($dataMerchant->parent) > 0 ? [] : $dataMerchant->groups->pluck("id")->toArray();

        return view('merchant.setting.account_init_setting', [
            'activeMenu' => 'merchant',
            'dataMerchant' => $dataMerchant,
            'merchantStores' => $merchantStores,
            'groups' => $groups,
            'storesAssigned' => $storesAssigned,
        ]);
    }

    public function storeAccountInitSetting(Request $request)
    {
        try {
            // Process save data
            $id = $request->id ?? auth('merchant')->user()->getMerchantStore()->first()->id;
            $this->merchantStoreService->storeAccountInitSetting($request, $id);

            return redirect()->route('merchant.setting.account_init_setting.get', ['id' => $id])
                ->with('success', 'update_merchant_success');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }
}
