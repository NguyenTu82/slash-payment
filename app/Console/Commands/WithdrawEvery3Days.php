<?php

namespace App\Console\Commands;

use App\Services\WithdrawAutoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Enums\MerchantStorePaymentCycle;

class WithdrawEvery3Days extends Command
{
    protected $signature = "WithdrawEvery3Days";

    protected $description = "Withdraw every 3 Days";

    public function handle(): bool
    {
        $periodFrom = Carbon::now()->startOfDay()->subDays(3);
        $periodTo = Carbon::now()->endOfDay()->subDays(1);

        $withdrawAutoService = new WithdrawAutoService($periodFrom, $periodTo, MerchantStorePaymentCycle::THREE_DAYS_END->value);
        $withdrawAutoService->handle();

        return true;
    }
}
