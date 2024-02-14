<?php

namespace App\Services;

use App\Repositories\EpayUserRepositoryEloquent;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AccountService
{
    private EpayUserRepositoryEloquent $epayUserRepository;
    private AdminRepository $adminRepository;

    public function __construct(
        EpayUserRepositoryEloquent $epayUserRepository,
        AdminRepository $adminRepository
    ) {
        $this->epayUserRepository = $epayUserRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return mixed
     */
    public function accounts()
    {
        $data = $this->epayUserRepository->getListAccount()->paginate(config('const.LIMIT_PAGINATION'), ['*']);
        return ["data" => $data];
    }

    public function search($filter)
    {
        return $this->epayUserRepository->getSearchedAccount($filter);
    }
    public function getRoles()
    {
        return $this->adminRepository->getRoles();
    }

    public function changePassword($request)
    {
        $this->epayUserRepository->update(["password" => Hash::make($request->password)], $request->id);
        return response()->json([
            'status' => true,
            'message' => 'Password changed successfully'
        ]);
    }

    public function deleteAccount($request)
    {
        try {
            $this->epayUserRepository->delete($request->id);
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return $e->getMessage();
        }
    }

    public function updateProfile($data ,$id)
    {
        DB::beginTransaction();
        try {
            $this->epayUserRepository->update(
                $data,
                $id,
            );
            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "message" => $e->getMessage(),
            ];
        }
    }
}
