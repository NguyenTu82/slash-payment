<?php

namespace App\Console\Commands;

use App\Enums\MerchantStorePaymentCycle;
use App\Enums\MerchantStoreStatus;
use App\Enums\WithdrawAsset;
use App\Enums\TransactionHistoryMoneyUnit;
use App\Enums\WithdrawMethod;
use App\Enums\WithdrawRequestMethod;
use App\Enums\WithdrawStatus;
use App\Repositories\FiatWithdrawAccountRepository;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\WithdrawRepository;
use App\Services\BalanceService;
use App\Services\WithdrawAutoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Str;

class WithdrawEveryMonth extends Command
{
    protected $signature = "WithdrawEveryMonth";

    protected $description = "Withdraw every month";

    public function handle(): bool
    {
        $periodFrom = Carbon::now()->startOfMonth()->subMonth(1);
        $periodTo = Carbon::now()->endOfMonth()->subMonth(1);

        $withdrawAutoService = new WithdrawAutoService($periodFrom, $periodTo, MerchantStorePaymentCycle::MONTH_END->value);
        $withdrawAutoService->handle();

        return true;
    }
}
