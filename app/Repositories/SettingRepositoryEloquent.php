<?php

namespace App\Repositories;
use App\Models\Admins;
use App\Models\AdminRole;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Enums\AdminAccountStatus;
/**
 * Class SettingRepositoryEloquent.
 *
 * @package 
 * 
 */

class SettingRepositoryEloquent extends BaseRepository implements SettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admins::class;
    }

    

    /**
     * @return mixed
     */
    public function getListAccount()
    { 
        return $this->model->
        select(
            "admins.*",
            "admin_roles.name_jp",
        )
        ->join('admin_roles','admin_roles.id','admins.role_id')
        ->orderBy('email_verified_at', 'desc');
    }


    public function getSearchedAccount($filter){
        return $this->model->
        select(
            "admins.*",
            "admin_roles.name_jp",
        )
        ->join('admin_roles','admin_roles.id','admins.role_id')
        
        ->when(!empty($filter->name), function ($query) use ($filter) {
            $query->where('admins.name', 'like', "%$filter->name%")
            ->orWhere('admins.email', 'like', "%$filter->name%")
            ->orWhere('admins.id', 'like', "%$filter->name%");
        })
        ->when(($filter->status) != '', function ($query) use ($filter) {
            $query->where('admins.status', '=', $filter->status);
        })
        
        ->when(($filter->role) != '', function ($query) use ($filter) {
            $query->where('admin_roles.id', '=', $filter->role);
        })
        ->orderBy('email_verified_at', 'desc');
    }
}
