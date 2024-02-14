<?php

namespace App\Http\Controllers\Merchant;

use App\Enums\MerchantRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Merchant\CreateMerchantUserRequest;
use App\Http\Requests\Merchant\UpdateMerchantUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Services\Merchant\AccountService;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Hash;
use App\Form\Merchant\BaseValidatorCustom;
use Exception;

class AccountController extends Controller
{
    private AccountService $accountService;
    private BaseValidatorCustom $form;

    public function __construct(
        AccountService $accountService,
        BaseValidatorCustom $form
    ) {
        $this->accountService = $accountService;
        $this->form = $form;
    }

    public function index(Request $request): View
    {
        $queryParams = (object) $request->query();
        $roles = $this->accountService->getRoles();
        $accounts = $this->accountService->accounts($queryParams)
            ->paginate($request->per_page ?? config('const.LIMIT_PAGINATION'));
        $accounts->appends($request->toArray());

        return view('merchant.account.index', compact('roles', 'accounts', 'request'));
    }

    public function create(Request $request): View| RedirectResponse
    {
        if(auth('merchant')->user()->role->name == \App\Enums\MerchantRole::USER->value) {
            return redirect()->back();
        }

        $roles = $this->accountService->getRoles();
        $merchantStores = auth('merchant')->user()->merchantStores;

        return view('merchant.account.create', compact('roles', 'merchantStores', 'request'));
    }

    public function store(CreateMerchantUserRequest $request): RedirectResponse
    {
        $merchantId = auth('merchant')->user()->id;
        $dataUser = $request->only(
            'name',
            'email',
            'merchant_role_id',
            'status',
            'note',
            'password',
            'password_confirm',
            'merchant_store_ids'
        );
        $dataUser['password'] = Hash::make($request->get('password'));
        $status = $this->accountService->createMerchantUser(array_merge($dataUser, [
            'parent_user_id' => $merchantId,
            'password_not_hash' => $request->password
        ]));
        if ($status)
            return redirect()->route('merchant.account.index.get')->with('success', 'create_merchant_user_success');
        return redirect()->back();
    }

    public function detail($id): View
    {
        $account = $this->accountService->findUserById($id);
        $roles = $this->accountService->getRoles();
        $myStores = $account->merchantStores;

        return view('merchant.account.detail', compact('account', 'roles', 'myStores'));
    }

    public function delete($id): RedirectResponse
    {
        $status = $this->accountService->deleteUserbyId($id);
        if ($status)
            return redirect()->route('merchant.account.index.get')->with('success', 'delete_merchant_user_success');

        return redirect()->back();
    }

    public function edit($id): View
    {
        $account = $this->accountService->findUserById($id);
        $roleNameOfThisAccount = $account->role()->first()->name;
        $roles = $this->accountService->getRoles();

        if ($roleNameOfThisAccount != MerchantRole::ADMINISTRATOR->value) {
            $roles = $roles->filter(function ($role) {
                return $role->name != MerchantRole::ADMINISTRATOR->value;
            });
        }

        $merchantStores = auth('merchant')->user()->merchantStores;
        $myStores = $account->merchantStores;

        return view('merchant.account.update', compact(
            'account', 'roles', 'merchantStores', 'myStores'
        ));
    }

    public function update($id, UpdateMerchantUserRequest $request): \Illuminate\Http\RedirectResponse
    {
        $request->merge(["id" => $id])->flash();
        $merchantId = auth('merchant')->user()->id;
        $dataUser = $request->only(
            'name',
            'email',
            'merchant_role_id',
            'status',
            'note',
            'merchant_store_ids'
        );
        $this->accountService->UpdateMerchantUser(array_merge($dataUser, [
            'parent_user_id' => $merchantId,
            'id' => $id
        ]));

        return redirect()->route('merchant.account.detail.get', ['id' => $id])->with('success', 'update_merchant_user_success');
    }

    public function changePassAccount($id, Request $request)
    {
        try {
            $this->form->validate(
                $request,
                'ChangPasswordForm'
            );
            $data = ["password" => Hash::make($request->password)];

            return $this->accountService->changePasswordAccount($id, $data);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
