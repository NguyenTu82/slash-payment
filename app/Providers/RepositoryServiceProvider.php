<?php

namespace App\Providers;

use App\Repositories\AdminRepository;
use App\Repositories\AdminRepositoryInterface;
use App\Repositories\AdminRoleRepository;
use App\Repositories\AdminRoleRepositoryInterface;
use App\Repositories\AdminTokenRepository;
use App\Repositories\AdminTokenRepositoryInterface;
use App\Repositories\AffiliateRepository;
use App\Repositories\AffiliateRepositoryEloquent;
use App\Repositories\BaseRepository;
use App\Repositories\EpayReportRepository;
use App\Repositories\EpayReportRepositoryEloquent;
use App\Repositories\EpayWithdrawRepository;
use App\Repositories\EpayWithdrawRepositoryEloquent;
use App\Repositories\ExampleRepository;
use App\Repositories\ExampleRepositoryEloquent;
use App\Repositories\MerchantGroupRepository;
use App\Repositories\MerchantGroupRepositoryEloquent;
use App\Repositories\MerchantNotificationRepository;
use App\Repositories\MerchantNotificationRepositoryEloquent;
use App\Repositories\MerchantStoreRepository;
use App\Repositories\MerchantStoreRepositoryEloquent;
use App\Repositories\MerchantTokenRepository;
use App\Repositories\MerchantTokenRepositoryEloquent;
use App\Repositories\MerchantUserRepository;
use App\Repositories\MerchantUserRepositoryEloquent;
use App\Repositories\PaymentSuccessRepository;
use App\Repositories\PaymentSuccessRepositoryEloquent;
use App\Repositories\RepositoryInterface;
use App\Repositories\MerchantRoleRepositoryEloquent;
use App\Repositories\MerchantRoleRepository;
use App\Repositories\WithdrawRepository;
use App\Repositories\WithdrawRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use App\Repositories\SettingRepositoryEloquent;
use App\Repositories\SettingRepository;
use App\Repositories\PostalRepositoryEloquent;
use App\Repositories\PostalRepository;
use App\Repositories\CashPaymentRepositoryEloquent;
use App\Repositories\CashPaymentRepository;
use App\Repositories\CryptoWithdrawAccountRepositoryEloquent;
use App\Repositories\CryptoWithdrawAccountRepository;
use App\Repositories\FiatWithdrawAccountRepositoryEloquent;
use App\Repositories\FiatWithdrawAccountRepository;
use App\Repositories\SlashApiRepositoryEloquent;
use App\Repositories\SlashApiRepository;
use App\Repositories\EpayNotiRepository;
use App\Repositories\EpayNotiRepositoryEloquent;
use App\Repositories\EpayNotiSendRepository;
use App\Repositories\EpayNotiFormatRepository;
use App\Repositories\EpayNotiSendRepositoryEloquent;
use App\Repositories\EpayNotiFormatRepositoryEloquent;
use App\Repositories\TransactionHistoryRepository;
use App\Repositories\TransactionHistoryRepositoryEloquent;
use App\Repositories\WithdrawLimitRepository;
use App\Repositories\WithdrawLimitRepositoryEloquent;
use App\Repositories\EpayReceiveNotiRepository;
use App\Repositories\EpayReceiveNotiRepositoryEloquent;
use App\Repositories\EpayReceiveNotiFormRepository;
use App\Repositories\EpayReceiveNotiFormRepositoryEloquent;
use App\Repositories\GroupMerchantRepository;
use App\Repositories\GroupMerchantRepositoryEloquent;
use App\Repositories\ExchangeRateRepository;
use App\Repositories\ExchangeRateRepositoryEloquent;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            RepositoryInterface::class,
            BaseRepository::class
        );
        $this->app->singleton(
            AdminRepositoryInterface::class,
            AdminRepository::class
        );
        $this->app->singleton(
            AdminRoleRepositoryInterface::class,
            AdminRoleRepository::class
        );
        $this->app->singleton(
            AdminTokenRepositoryInterface::class,
            AdminTokenRepository::class
        );

        $this->app->bind(ExampleRepository::class, ExampleRepositoryEloquent::class);
        $this->app->bind(PostalRepository::class, PostalRepositoryEloquent::class);
        $this->app->bind(MerchantUserRepository::class, MerchantUserRepositoryEloquent::class);
        $this->app->bind(MerchantTokenRepository::class, MerchantTokenRepositoryEloquent::class);
        $this->app->singleton(SettingRepository::class, SettingRepositoryEloquent::class);

        $this->app->bind(MerchantRoleRepository::class, MerchantRoleRepositoryEloquent::class);
        $this->app->bind(MerchantStoreRepository::class, MerchantStoreRepositoryEloquent::class);
        $this->app->bind(MerchantGroupRepository::class, MerchantGroupRepositoryEloquent::class);
        $this->app->bind(MerchantNotificationRepository::class, MerchantNotificationRepositoryEloquent::class);
        $this->app->bind(FiatWithdrawAccountRepository::class, FiatWithdrawAccountRepositoryEloquent::class);
        $this->app->bind(CryptoWithdrawAccountRepository::class, CryptoWithdrawAccountRepositoryEloquent::class);
        $this->app->bind(CashPaymentRepository::class, CashPaymentRepositoryEloquent::class);
        $this->app->bind(SlashApiRepository::class, SlashApiRepositoryEloquent::class);
        $this->app->bind(WithdrawRepository::class, WithdrawRepositoryEloquent::class);
        $this->app->bind(EpayNotiRepository::class, EpayNotiRepositoryEloquent::class);
        $this->app->bind(EpayNotiSendRepository::class, EpayNotiSendRepositoryEloquent::class);
        $this->app->bind(EpayNotiFormatRepository::class, EpayNotiFormatRepositoryEloquent::class);
        $this->app->bind(TransactionHistoryRepository::class, TransactionHistoryRepositoryEloquent::class);
        $this->app->bind(AffiliateRepository::class, AffiliateRepositoryEloquent::class);
        $this->app->bind(PaymentSuccessRepository::class, PaymentSuccessRepositoryEloquent::class);
        $this->app->bind(EpayWithdrawRepository::class, EpayWithdrawRepositoryEloquent::class);
        $this->app->bind(EpayReportRepository::class, EpayReportRepositoryEloquent::class);
        $this->app->bind(WithdrawLimitRepository::class, WithdrawLimitRepositoryEloquent::class);
        $this->app->bind(EpayReceiveNotiRepository::class, EpayReceiveNotiRepositoryEloquent::class);
        $this->app->bind(EpayReceiveNotiFormRepository::class, EpayReceiveNotiFormRepositoryEloquent::class);
        $this->app->bind(GroupMerchantRepository::class, GroupMerchantRepositoryEloquent::class);
        $this->app->bind(ExchangeRateRepository::class, ExchangeRateRepositoryEloquent::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
