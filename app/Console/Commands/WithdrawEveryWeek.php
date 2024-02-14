<?php

namespace App\Console\Commands;

use App\Services\WithdrawAutoService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Enums\MerchantStorePaymentCycle;

class WithdrawEveryWeek extends Command
{
    protected $signature = "WithdrawEveryWeek";

    protected $description = "Withdraw every week";

    public function handle(): bool
    {
        $periodFrom = Carbon::now()->startOfWeek()->subWeek(1);
        $periodTo = Carbon::now()->endOfWeek()->subWeek(1);

        $withdrawAutoService = new WithdrawAutoService($periodFrom, $periodTo, MerchantStorePaymentCycle::WEEKEND->value);
        $withdrawAutoService->handle();

        return true;
    }
}
