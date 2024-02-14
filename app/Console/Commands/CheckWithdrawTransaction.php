<?php

namespace App\Console\Commands;

use App\Enums\WithdrawStatus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use App\Services\TigerGateway\TigerGatewayService;
use App\Repositories\WithdrawRepository;
use App\Models\Withdraw;
use Exception;
use Illuminate\Support\Carbon;
class CheckWithdrawTransaction extends Command
{
    protected $signature = 'CheckWithdrawTransaction';

    protected $description = 'Check successful withdraw transaction per 1 hour';

    public function __construct()
    {
        parent::__construct();
    }
    
    public function handle()
    {
        try{
            $withdrawRepository = app()->make(WithdrawRepository::class);
            $tigerGatewayService = app()->make(TigerGatewayService::class);
            
            //Update succeeded status
            $succeeddStatus = Withdraw::where('withdraw_status', WithdrawStatus::TGW_WAITING_APPROVE->value)
                ->pluck('id')
                ->toArray();
            foreach($succeeddStatus as $Id){
                $listWithdrawal = $tigerGatewayService->getListWithdrawal([
                    'filter[search]' => $Id
                ]);
                $responseJson = json_decode($listWithdrawal->getResponseData(), true);
                if($responseJson['success'] && isset($responseJson['data']['data'][0])){
                    $transaction = $responseJson['data']['data']['0'];
                    if ($transaction['date_completed'] == null ) {
                        $transaction['date_completed'] = Carbon::now();
                    };

                    if($transaction['status'] === 'approved'){
                        $withdrawRepository->updateStatusWithdraw(WithdrawStatus::SUCCEEDED->value, $Id, $transaction);
                    }
                    if($transaction['status'] === 'declined'){
                        $withdrawRepository->updateStatusWithdraw(WithdrawStatus::DENIED->value, $Id, $transaction);
                    }
                    if($transaction['status'] === 'cancelled'){
                        $withdrawRepository->updateStatusWithdraw(WithdrawStatus::CANCELLED->value, $Id, $transaction);
                    }
                }
            }
        }
        catch(Exception $e){
            Log::error("JOB-ERROR: ".$e->getMessage());
        }
    }
}