<?php

namespace App\Services;

use App\Repositories\SettingRepositoryEloquent;
use App\Repositories\AdminRepository;
use Illuminate\Support\Facades\DB;

class SettingService
{
    private SettingRepositoryEloquent $settingRepository;
    private AdminRepository $adminRepository; 
    
    public function __construct(
        SettingRepositoryEloquent $settingRepository,
        AdminRepository $adminRepository
    ) {
        $this->settingRepository = $settingRepository;
        $this->adminRepository = $adminRepository;
    }

    /**
     * @return mixed
     */
    public function search($filter)
    {
        return $this->settingRepository->getSearchedAccount($filter);
    }
    public function getRoles()
    {
        return $this->adminRepository->getRoles();
    }
}
