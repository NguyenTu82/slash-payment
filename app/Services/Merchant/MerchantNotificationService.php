<?php

namespace App\Services\Merchant;

use App\Models\MerchantStore;
use App\Models\MerchantNoti;
use App\Repositories\MerchantNotificationRepository;
use App\Repositories\MerchantStoreRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Enums\MerchantNotiStatus;
use Exception;

class MerchantNotificationService
{
    protected MerchantNotificationRepository $merchantNotificationRepository;
    protected MerchantStoreRepository $merchantStoreRepository;

    /**
     *  constructor
     *
     * @param MerchantNotificationRepository $merchantNotificationRepository
     * @param MerchantStoreRepository $merchantStoreRepository
     */
    public function __construct(
        MerchantNotificationRepository $merchantNotificationRepository,
        MerchantStoreRepository $merchantStoreRepository
    ){
        $this->merchantNotificationRepository = $merchantNotificationRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
    }

    /**
     * @return null|MerchantNoti
     */


    public function getNotiByMerchantId($query)
    {
        return $this->merchantNotificationRepository->getNotiByMerchantId($query);
    }

    public function getNotiDetail($id)
    {
        return $this->merchantNotificationRepository->getNotiDetail($id);
    }

    public function deleteNotiById($id)
    {
        return $this->merchantNotificationRepository->deleteNotiById($id);
    }

    public function updateNotiStatusWhenOpen($id)
    {
        try {
            $merchantNoti = $this->merchantNotificationRepository->update([ "status" => MerchantNotiStatus::ALREADY_READ->value],$id);
            DB::commit();
            return $merchantNoti;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
        }
    }
}
