<?php

namespace App\Services\Merchant;

use App\Enums\MerchantStoreStatus;
use App\Mail\CreateMerchantMail;
use App\Jobs\SendEmailJob;
use App\Models\MerchantStore;
use App\Repositories\CryptoWithdrawAccountRepository;
use App\Repositories\FiatWithdrawAccountRepository;
use App\Repositories\CashPaymentRepository;
use App\Repositories\GroupMerchantRepository;
use App\Repositories\MerchantGroupRepository;
use App\Repositories\MerchantRoleRepository;
use App\Repositories\MerchantUserRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\PostalRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Enums\MerchantPaymentType;
use App\Repositories\SlashApiRepository;
use Exception;
use Illuminate\Support\Str;

class MerchantStoreService
{
    protected MerchantUserRepository $merchantUserRepository;
    protected MerchantStoreRepository $merchantStoreRepository;
    protected PostalRepository $postalRepository;
    protected MerchantRoleRepository $merchantRoleRepository;
    protected FiatWithdrawAccountRepository $fiatWithdrawAccountRepository;
    protected CryptoWithdrawAccountRepository $cryptoWithdrawAccountRepository;
    protected CashPaymentRepository $cashPaymentRepository;
    protected SlashApiRepository $slashApiRepository;
    protected GroupMerchantRepository $groupMerchantRepository;

    /**
     *  constructor
     *
     * @param MerchantUserRepository $merchantUserRepository
     * @param MerchantStoreRepository $merchantStoreRepository
     */
    public function __construct(
        MerchantUserRepository $merchantUserRepository,
        MerchantStoreRepository $merchantStoreRepository,
        PostalRepository $postalRepository,
        MerchantRoleRepository $merchantRoleRepository,
        FiatWithdrawAccountRepository $fiatWithdrawAccountRepository,
        CryptoWithdrawAccountRepository $cryptoWithdrawAccountRepository,
        CashPaymentRepository $cashPaymentRepository,
        SlashApiRepository $slashApiRepository,
        GroupMerchantRepository $groupMerchantRepository,
        MerchantGroupRepository $merchantGroupRepository
    ) {
        $this->merchantUserRepository = $merchantUserRepository;
        $this->merchantStoreRepository = $merchantStoreRepository;
        $this->postalRepository = $postalRepository;
        $this->merchantRoleRepository = $merchantRoleRepository;
        $this->fiatWithdrawAccountRepository = $fiatWithdrawAccountRepository;
        $this->cryptoWithdrawAccountRepository = $cryptoWithdrawAccountRepository;
        $this->cashPaymentRepository = $cashPaymentRepository;
        $this->slashApiRepository = $slashApiRepository;
        $this->groupMerchantRepository = $groupMerchantRepository;
        $this->merchantGroupRepository = $merchantGroupRepository;
    }

    public function getMerchantStores($request)
    {
        return $this->merchantStoreRepository->getMerchantStores($request);
    }

    public function getAllMerchantStores()
    {
        return $this->merchantStoreRepository->getAllMerchantStores();
    }

    public function merchantStoreActiveIds()
    {
        return $this->merchantStoreRepository->merchantStoreActiveIds();
    }

    public function totalMerchantStores($cond)
    {
        return $this->merchantStoreRepository->totalMerchantStores($cond);
    }

    public function getAllMerchantStoresNotParent()
    {
        return $this->merchantStoreRepository->getAllMerchantStoresNotParent();
    }

    public function getAllMerchantStoresNotParentWithoutId($id)
    {
        return $this->merchantStoreRepository->getAllMerchantStoresNotParentWithoutId($id);
    }

    public function createMerchantStore($request): array
    {
        DB::beginTransaction();
        try {
            $token = hash_hmac("sha256", Str::random(40), config("app.key"));
            $dataMerchantStore = [
                "name" => $request->name,
                "service_name" => $request->service_name,
                "industry" => $request->industry,
                "representative_name" => $request->representative_name,
                "post_code_id" => $request->post_code_id_value,
                "address" => $request->address,
                "phone" => $request->phone,
                "ship_date" => $request->ship_date,
                "sending_detail" => $request->sending_detail == "on" ? 1 : 0,
                "ship_address" => $request->ship_address,
                "delivery_email_address1" => $request->delivery_email_address,
                "delivery_email_address2" => $request->delivery_email_address2,
                "delivery_email_address3" => $request->delivery_email_address3,
                "guidance_email" => $request->guidance_email == "on" ? 1 : 0,
                "delivery_report" => $request->delivery_report_status ? $request->delivery_report :  null,
                "contract_date" => $request->contract_date ? str_replace(['年', '月', '日'], ['/', '/', ''], $request->contract_date) : null,
                "termination_date" => $request->termination_date ? str_replace(['年', '月', '日'], ['/', '/', ''], $request->termination_date) : null,
                "status" => MerchantStoreStatus::IN_USE->value,
                "contract_interest_rate" => $request->contract_interest_rate,
                "payment_cycle" => $request->payment_cycle,
                "withdraw_method" => $request->withdraw_method,
                "ship_post_code_id" => $request->ship_post_code_id_value,
                "expires_at" => Carbon::now()->addHours(
                    config("const.EMAIL_VALID_DT")
                ),
                "token" => $token,
                "af_switch" => $request->afSwitch == "on" ? 1 : 0,
                "af_name" => $request->af_name,
                "af_fee" => $request->af_rate,
                "affiliate_id" => $request->af_id,
                "auth_token" => $request->auth_token,
                "hash_token" => $request->hash_token,
                "payment_url" => $request->payment_url,
            ];

            $merchantRole = $this->merchantRoleRepository->findByField('name', 'administrator');
            $merchantNumberByName = count($this->merchantStoreRepository->findByField('name', $request->name));

            if ($merchantNumberByName > 0) {
                throw new Exception(__("admin_epay.merchant.common.merchant_name_exist"));
            }

            $merchantNumberByEmail = count($this->merchantUserRepository->findByField('email', $request->email));

            if ($merchantNumberByEmail > 0) {
                throw new Exception(__("admin_epay.merchant.common.email_exist"));
            }

            $checkUniqueAuthToken = $this->merchantStoreRepository->where('auth_token', $request->auth_token);
            $checkUniqueHashToken = $this->merchantStoreRepository->where('hash_token', $request->hash_token);

            if ($checkUniqueAuthToken->count() > 0 || $checkUniqueHashToken->count() > 0) {
                throw new Exception(__("admin_epay.merchant.common.auth_or_hash_exist"));
            }

            $dataMerchantUser = [
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
                "merchant_role_id" => count($merchantRole) > 0 ? $merchantRole[0]->id : ""
            ];

            if ($request->afSwitch == "on") {
                $dataAf = [
                    "af_id" => $request->af_id,
                    "af_name" => $request->af_name,
                    "af_rate" => $request->af_rate
                ];
            }
            $merchantStore = $this->merchantStoreRepository->create($dataMerchantStore);
            $merchantUser = $this->merchantUserRepository->create($dataMerchantUser);
            $this->merchantStoreRepository->update(['merchant_user_owner_id' => $merchantUser->id], $merchantStore->id);

            if (
                $request->withdraw_method == MerchantPaymentType::FIAT->value ||
                (!empty($request->financial_institution_name) && !empty($request->bank_code) &&
                    !empty($request->branch_name) && !empty($request->branch_code) && !empty($request->bank_account_type) &&
                    !empty($request->bank_account_number) && !empty($request->bank_account_holder))
            ) {
                $dataFiat = [
                    "merchant_store_id" => $merchantStore->id,
                    "financial_institution_name" => $request->financial_institution_name,
                    "bank_code" => $request->bank_code,
                    "branch_name" => $request->branch_name,
                    "branch_code" => $request->branch_code,
                    "bank_account_type" => $request->bank_account_type,
                    "bank_account_number" => $request->bank_account_number,
                    "bank_account_holder" => $request->bank_account_holder,
                ];
                $this->fiatWithdrawAccountRepository->create($dataFiat);
            }

            if (
                $request->withdraw_method == MerchantPaymentType::CRYPTO->value ||
                (!empty($request->wallet_address) && !empty($request->crypto_network))
            ) {
                $dataCrypto = [
                    "merchant_store_id" => $merchantStore->id,
                    "wallet_address" => $request->wallet_address,
                    "network" => $request->crypto_network,
                    "note" => $request->note,
                    "asset" => $request->received_virtua_type,
                ];
                $this->cryptoWithdrawAccountRepository->create($dataCrypto);
            }

            $dataSlashApi = [
                "contract_wallet" => $request->contract_wallet,
                "receive_wallet_address" => $request->receiving_walletaddress,
                "receive_crypto_type" => $request->received_virtua_type,
                "merchant_store_id" => $merchantStore->id,
                "slash_auth_token" => $request->auth_token,
                "slash_hash_token" => $request->hash_token,
            ];
            $this->slashApiRepository->create($dataSlashApi);
            $dataGroup = $request->group_id ? json_decode($request->group_id) : [];
            $merchantUser->merchantStores()->sync(array_merge($dataGroup, [$merchantStore->id]));
            foreach ($dataGroup as $value) {
                $this->groupMerchantRepository->create([
                    'merchant_parent_store_id' => $merchantStore->id,
                    'merchant_children_store_id' => $value
                ]);
            }
            // $dataCash = [
            //     "merchant_store_id" => $merchantStore->id,
            //     "total_transaction_amount" => $request->total_transaction_amount,
            //     "account_balance" => $request->account_balance,
            //     "paid_balance" => $request->paid_balance
            // ];
            // $this->cashPaymentRepository->updateOrCreate(["merchant_store_id" => $merchantStore->id], $dataCash);
            DB::commit();
            // try {
            //     SendEmailJob::dispatch(new CreateMerchantMail([
            //         "name" => $request->name,
            //         "email" => $request->email,
            //         "password" => $request->password,
            //         "url" => route("merchant.auth.verify-register", ["id" => $merchantStore->id, "token" => $token])
            //     ]), $request->email)->onQueue('emails');
            // } catch (Exception $e) {
            //     Log::error($e->getMessage());
            //     throw new Exception($e->getMessage());
            // }

            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "messages" => $e->getMessage(),
            ];
        }
    }

    public function updateMerchantStore($request, $id)
    {
        DB::beginTransaction();
        try {
            $dataMerchantStore = [
                "name" => $request->name,
                "service_name" => $request->service_name,
                "industry" => $request->industry,
                "representative_name" => $request->representative_name,
                "post_code_id" => $request->post_code_id_value,
                "address" => $request->address,
                "phone" => $request->phone,
                "ship_date" => $request->ship_date,
                "sending_detail" => $request->sending_detail == "on" ? 1 : 0,
                "ship_address" => $request->ship_address,
                "delivery_email_address1" => $request->delivery_email_address,
                "delivery_email_address2" => $request->delivery_email_address2,
                "delivery_email_address3" => $request->delivery_email_address3,
                "guidance_email" => $request->guidance_email == "on" ? 1 : 0,
                "delivery_report" => $request->delivery_report_status ? $request->delivery_report :  null,
                "contract_date" => $request->contract_date ? str_replace(['年', '月', '日'], ['/', '/', ''], $request->contract_date) : null,
                "termination_date" => $request->termination_date ? str_replace(['年', '月', '日'], ['/', '/', ''], $request->termination_date) : null,
                "status" => $request->status,
                "contract_interest_rate" => $request->contract_interest_rate,
                "payment_cycle" => $request->payment_cycle,
                "withdraw_method" => $request->withdraw_method,
                "ship_post_code_id" => $request->ship_post_code_id_value,
                "af_switch" => $request->afSwitch == "on" ? 1 : 0,
                "af_name" => $request->afSwitch == "on" ? $request->af_name : '',
                "af_fee" => $request->afSwitch == "on" ? $request->af_rate : 0,
                "affiliate_id" => $request->afSwitch == "on" ? $request->af_id : '',
                "auth_token" => $request->auth_token,
                "hash_token" => $request->hash_token,
                "payment_url" => $request->payment_url,
            ];

            if ($request->afSwitch == "on") {
                $dataAf = [
                    "af_id" => $request->af_id,
                    "af_name" => $request->af_name,
                    "af_rate" => $request->af_rate
                ];
            }

            $checkUniqueAuthToken = $this->merchantStoreRepository->where('id', '<>', $id)
            ->where('auth_token', $request->auth_token);
            $checkUniqueHashToken = $this->merchantStoreRepository->where('id', '<>', $id)
            ->where('hash_token', $request->hash_token);

            if ($checkUniqueAuthToken->count() > 0 || $checkUniqueHashToken->count() > 0) {
                throw new Exception(__("admin_epay.merchant.common.auth_or_hash_exist"));
            }

            $merchantStore = $this->merchantStoreRepository->update($dataMerchantStore, $id);
            //            if (count($this->merchantUserRepository->findWhere([
//                    ["email", "=",$request->email],
//                    ["id","!=", $merchantStore->merchant_user_owner_id]])) > 0
//            ) {
//                return [
//                    "status" => false,
//                    "messages" => __("admin_epay.merchant.common.email_exist"),
//                ];
//            }
//
//            $this->merchantUserRepository->update(["email" => $request->email], $merchantStore->merchant_user_owner_id);
            if (
                $request->withdraw_method == MerchantPaymentType::FIAT->value ||
                (!empty($request->financial_institution_name) && !empty($request->bank_code) &&
                    !empty($request->branch_name) && !empty($request->branch_code) && !empty($request->bank_account_type) &&
                    !empty($request->bank_account_number) && !empty($request->bank_account_holder))
            ) {
                $dataFiat = [
                    "merchant_store_id" => $merchantStore->id,
                    "financial_institution_name" => $request->financial_institution_name,
                    "bank_code" => $request->bank_code,
                    "branch_name" => $request->branch_name,
                    "branch_code" => $request->branch_code,
                    "bank_account_type" => $request->bank_account_type,
                    "bank_account_number" => $request->bank_account_number,
                    "bank_account_holder" => $request->bank_account_holder,
                ];
                $this->fiatWithdrawAccountRepository->updateOrCreate(["id" => $request->fiat_withdrawn_account_id], $dataFiat);
            }

            if (
                $request->withdraw_method == MerchantPaymentType::CRYPTO->value ||
                (!empty($request->wallet_address) && !empty($request->crypto_network))
            ) {
                $dataCrypto = [
                    "merchant_store_id" => $merchantStore->id,
                    "wallet_address" => $request->wallet_address,
                    "network" => $request->crypto_network,
                    "note" => $request->note,
                    "asset" => $request->received_virtua_type,
                ];
                $this->cryptoWithdrawAccountRepository->updateOrCreate(["id" => $request->crypto_withdrawn_account_id], $dataCrypto);
            }

            $dataSlashApi = [
                "contract_wallet" => $request->contract_wallet,
                "receive_wallet_address" => $request->receiving_walletaddress,
                "receive_crypto_type" => $request->received_virtua_type,
                "merchant_store_id" => $merchantStore->id,
                "slash_auth_token" => $request->auth_token,
                "slash_hash_token" => $request->hash_token,
            ];
            $this->slashApiRepository->updateOrCreate(["id" => $request->slash_api_id], $dataSlashApi);
            $dataGroup = $request->group_id ? json_decode($request->group_id) : [];
            $dataGroupOld = $request->group_old ? json_decode($request->group_old) : [];
            foreach ($dataGroupOld as $value) {
                if (!in_array($value, $dataGroup)) {
                    $this->merchantGroupRepository->deleteByStoreIdAndUserId($value, $merchantStore->merchant_user_owner_id);
                    $this->groupMerchantRepository->deleteByParentIdAndChildrenId($merchantStore->id, $value);
                }
            }
            foreach ($dataGroup as $value) {
                if (!in_array($value, $dataGroupOld)) {
                    $this->merchantGroupRepository->create([
                        'merchant_store_id' => $value,
                        'merchant_user_id' => $merchantStore->merchant_user_owner_id
                    ]);
                    $this->groupMerchantRepository->create([
                        'merchant_parent_store_id' => $merchantStore->id,
                        'merchant_children_store_id' => $value
                    ]);
                }
            }
            // $dataCash = [
            //     "merchant_store_id" => $merchantStore->id,
            //     "total_transaction_amount" => $request->total_transaction_amount,
            //     "account_balance" => $request->account_balance,
            //     "paid_balance" => $request->paid_balance
            // ];
            // $this->cashPaymentRepository->updateOrCreate(["merchant_store_id" => $merchantStore->id], $dataCash);
            DB::commit();
            return [
                "status" => true,
            ];
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return [
                "status" => false,
                "messages" => $e->getMessage(),
            ];
        }
    }
    public function findDataMerchantById($id)
    {
        $dataMerchant = $this->merchantStoreRepository->with(['groups', 'slashApi', 'fiatWithdrawAccount', 'cryptoWithdrawAccount', 'postCodeId', 'shipPostCodeId', 'cashPayment', 'merchantOwner'])->find($id);
        return $dataMerchant;
    }

    public function checkPostalCode($data)
    {
        $dataPostal = $this->postalRepository->findByField("code", $data);
        if (count($dataPostal) > 0) {
            return [
                "status" => true,
                "dataPostal" => $dataPostal[0]
            ];
        }
        return [
            "status" => false,
            "dataPostal" => null
        ];
    }

    public function getMerchantStoreById($id)
    {
        return $this->merchantStoreRepository->getMerchantStoreById($id);
    }

    public function deleteMerchantStore($id)
    {
        DB::beginTransaction();
        try {
            $this->merchantStoreRepository->delete($id);
            $this->cashPaymentRepository->deleteWhere(["merchant_store_id" => $id]);
            $this->slashApiRepository->deleteWhere(["merchant_store_id" => $id]);
            $this->cryptoWithdrawAccountRepository->deleteWhere(["merchant_store_id" => $id]);
            $this->fiatWithdrawAccountRepository->deleteWhere(["merchant_store_id" => $id]);
            $this->merchantStoreRepository->updateWhenDeleteGroup($id);
            DB::commit();
            return true;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();
            return false;
        }
    }

    public function checkGroup($id)
    {
        $dataPostal = $this->merchantStoreRepository->findByField("merchant_parent_store_id", $id);
        if (count($dataPostal) > 0) {
            return [
                "status" => true,
            ];
        }
        return [
            "status" => false,
        ];
    }

    public function merchantStoreStatistic($cond)
    {
        return $this->merchantStoreRepository->merchantStoreStatistic($cond);
    }

    public function verifyRegisterMerchant($id, $token): array
    {
        $dataMerchant = $this->merchantStoreRepository->findWhere([
            ["id", "=", $id],
            ["token", "=", $token]
        ])->first();
        if (!$dataMerchant) {
            return [
                "status" => false,
                "messages" => __("admin_epay.merchant.common.verify_url_error"),
            ];
        }
        $date1 = Carbon::createFromFormat(
            "Y-m-d H:i:s",
            $dataMerchant["expires_at"]
        );
        $date2 = Carbon::now();
        $result = $date1->gt($date2);
        if (!$result) {
            return [
                "status" => false,
                "messages" => __("admin_epay.merchant.common.verify_url_expires"),
            ];
        }
        $this->merchantStoreRepository->update([
            "status" => MerchantStoreStatus::IN_USE
        ], $id);
        return [
            "status" => true,
        ];
    }

    public function changePass($request)
    {
        $this->merchantUserRepository->update(["password" => Hash::make($request->password)], $request->id);
        return [
            'status' => true,
            'message' => 'Password changed successfully'
        ];
    }

    public function getRole($request)
    {
        return $this->merchantRoleRepository->find($request);
    }

    /**
     * @throws Exception
     */
    public function storeAccountInitSetting($request, $id)
    {
        DB::beginTransaction();
        try {
            $dataMerchantStore = [
                "name" => $request->name,
                "service_name" => $request->service_name,
                "industry" => $request->industry,
                "representative_name" => $request->representative_name,
                "post_code_id" => $request->post_code_id_value,
                "address" => $request->address,
                "phone" => $request->phone,
                "ship_date" => str_replace(['年', '月', '日'], ['/', '/', ''], $request->ship_date),
                "sending_detail" => $request->sending_detail == "on" ? 1 : 0,
                "ship_address" => $request->ship_address,
                "delivery_email_address1" => $request->delivery_email_address,
                "delivery_email_address2" => $request->delivery_email_address2,
                "delivery_email_address3" => $request->delivery_email_address3,
                "guidance_email" => $request->guidance_email == "on" ? 1 : 0,
                "delivery_report" => $request->delivery_report_status ? $request->delivery_report :  null,
                "contract_date" => str_replace(['年', '月', '日'], ['/', '/', ''], $request->contract_date),
                "termination_date" => str_replace(['年', '月', '日'], ['/', '/', ''], $request->termination_date),
                "status" => $request->status,
                "contract_interest_rate" => $request->contract_interest_rate,
                "payment_cycle" => $request->payment_cycle,
                "withdraw_method" => $request->withdraw_method,
                "ship_post_code_id" => $request->ship_post_code_id_value,
                "af_switch" => $request->afSwitch == "on" ? 1 : 0,
                "af_name" => $request->afSwitch == "on" ? $request->af_name : '',
                "af_fee" => $request->afSwitch == "on" ? $request->af_rate : 0,
                "affiliate_id" => $request->afSwitch == "on" ? $request->af_id : '',
                "auth_token" => $request->auth_token,
                "hash_token" => $request->hash_token,
            ];

            $merchantStore = $this->merchantStoreRepository->update($dataMerchantStore, $id);

            if (
                $request->withdraw_method == MerchantPaymentType::FIAT->value ||
                (
                    !empty($request->financial_institution_name) &&
                    !empty($request->bank_code) &&
                    !empty($request->branch_name) &&
                    !empty($request->branch_code) &&
                    !empty($request->bank_account_type) &&
                    !empty($request->bank_account_number) &&
                    !empty($request->bank_account_holder)
                )
            ) {
                $dataFiat = [
                    "merchant_store_id" => $merchantStore->id,
                    "financial_institution_name" => $request->financial_institution_name,
                    "bank_code" => $request->bank_code,
                    "branch_name" => $request->branch_name,
                    "branch_code" => $request->branch_code,
                    "bank_account_type" => $request->bank_account_type,
                    "bank_account_number" => $request->bank_account_number,
                    "bank_account_holder" => $request->bank_account_holder,
                ];
                $this->fiatWithdrawAccountRepository->updateOrCreate(["id" => $request->fiat_withdrawn_account_id], $dataFiat);
            }

            if (
                $request->withdraw_method == MerchantPaymentType::CRYPTO->value ||
                (!empty($request->wallet_address) && !empty($request->crypto_network))
            ) {
                $dataCrypto = [
                    "merchant_store_id" => $merchantStore->id,
                    "wallet_address" => $request->wallet_address,
                    "network" => $request->crypto_network,
                    "note" => $request->note,
                ];
                $this->cryptoWithdrawAccountRepository->updateOrCreate(["id" => $request->crypto_withdrawn_account_id], $dataCrypto);
            }

            $dataCash = [
                "merchant_store_id" => $merchantStore->id,
                "total_transaction_amount" => $request->total_transaction_amount,
                "account_balance" => $request->account_balance,
                "paid_balance" => $request->paid_balance
            ];

            $this->cashPaymentRepository->updateOrCreate(["merchant_store_id" => $merchantStore->id], $dataCash);
            DB::commit();
        } catch (Exception $e) {
            Log::error($e->getMessage());
            DB::rollback();

            throw new Exception($e->getMessage());
        }
    }
}
