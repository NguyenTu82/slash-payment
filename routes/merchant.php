<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Merchant\AuthController;
use App\Http\Controllers\Merchant\DashboardController;
use App\Http\Controllers\Merchant\SettingController;
use App\Http\Controllers\Merchant\AccountController;
use App\Http\Controllers\Merchant\NotificationController;
use App\Http\Controllers\Merchant\WithdrawController;
use App\Http\Controllers\Merchant\UsageSituationController;
use App\Http\Controllers\AdminEpay\MerchantController;
use App\Http\Controllers\AdminEpay\BankController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Define the "merchant" routes for the application.
|
*/

Route::get('/home', function() {
    return 'admin merchant home';
});

Route::group(['prefix' => '/', 'as' => 'merchant.'], function () {
    Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/login', [AuthController::class, 'loginProcess'])->name('login_process');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot_password');
        Route::post('/forgot-pw-sendmail', [AuthController::class, 'forgotPwSendMail'])->name('forgot_pw_sendmail');
        Route::get('/forgot-pw-confirm', [AuthController::class, 'forgotPwConfirm'])->name('forgot_pw_confirm');
        Route::get('/forgot-pw-change', [AuthController::class, 'forgotPwChange'])->name('forgot_pw_change');
        Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset_password');
        Route::get('verify-register/{id?}/{token?}', [MerchantController::class, 'verifyRegisterMerchant'])->name('verify-register');
        Route::group(['prefix' => 'register', 'as' => 'register.'], function () {
            Route::get('', [AuthController::class, 'registerIndex'])->name('index.get');
            Route::post('store', [AuthController::class, 'registerProcess'])->name('store.post');
            Route::get('/confirm', [AuthController::class, 'registerConfirm'])->name('confirm.get');
        });
    });
    Route::post('callback', [UsageSituationController::class, 'callbackPayment'])->name('store.post');

    Route::group(['prefix' => 'bank', 'as' => 'bank.'], function () {
        Route::post('check-bank-code', [BankController::class, 'checkBankCode'])->name('check_bank_code');
        Route::post('check-branch-code', [BankController::class, 'checkBranchBankCode'])->name('check_branch_code');
    });

    Route::middleware('auth')->group(static function (): void {
        Route::group(['prefix' => '/dashboard',
            'as' => 'dashboard.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('', [DashboardController::class, 'index'])->name('index.get');
            Route::get('/detail', [DashboardController::class, 'detail'])->name('detail.get');
        });

        // Account management
        Route::group(['prefix' => 'account',
            'as' => 'account.',
            'middleware' => ['can:merchant_admin_operator']
        ], function () {
            Route::get('', [AccountController::class, 'index'])->name('index.get');
            Route::get('create', [AccountController::class, 'create'])->name('create.get');
            Route::post('store', [AccountController::class, 'store'])->name('store.post');
            Route::get('/detail/{id?}', [AccountController::class, 'detail'])->name('detail.get');
            Route::get('/delete/{id?}', [AccountController::class, 'delete'])->name('delete.get');
            Route::get('/edit/{id?}', [AccountController::class, 'edit'])->name('edit.get');
            Route::post('/update/{id?}', [AccountController::class, 'update'])->name('update.post');
            Route::post('/change-pass/{id?}', [AccountController::class, 'changePassAccount'])->name('change_password.post');
        });

        // Withdraw management
        Route::group(['prefix' => 'withdraw',
            'as' => 'withdraw.',
            'middleware' => ['can:merchant_admin_operator']
        ], function () {
            Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
                Route::get('', [WithdrawController::class, 'getHistories'])->name('index.get');
                Route::get('detail/{id}', [WithdrawController::class, 'getWithdrawHistory'])->name('detail.get');
                Route::post('update/{id}', [WithdrawController::class, 'updateWithdrawHistory'])->name('update.post');
                Route::get('delete/{id}', [WithdrawController::class, 'deleteWithdrawHistory'])->name('delete.get');
            });
            Route::group(['prefix' => 'request', 'as' => 'request.'], function () {
                Route::get('/create', [WithdrawController::class, 'createRequestWithdraw'])->name('create.get');
                Route::post('/store', [WithdrawController::class, 'storeRequestWithdraw'])->name('store.post');
            });

            Route::get('/fiat-account-default/{id}', [WithdrawController::class, 'getFiatAccountDefault'])->name('fiat-account-default.get');
            Route::get('/crypto-account-default/{id}', [WithdrawController::class, 'getCryptoAccountDefault'])->name('crypto-account-default.get');
        });

        // Setting management
        Route::group(['prefix' => 'setting',
            'as' => 'setting.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::group(['prefix' => '/profile', 'as' => 'profile.'], function () {
                Route::get('', [SettingController::class, 'getProfile'])->name('index');
                Route::post('/change-pass', [SettingController::class, 'changePass'])->name('change_password');
                Route::post('/update-profile', [SettingController::class, 'updateProfile'])->name('update_profile');
            });
            Route::get('/account-init-setting', [SettingController::class, 'getAccountInitSetting'])->name('account_init_setting.get')->middleware('can:merchant_admin');
            Route::post('/store-account-init-setting', [SettingController::class, 'storeAccountInitSetting'])->name('account_init_setting.post')->middleware('can:merchant_admin');
        });

        //Notification management
        Route::group(['prefix' => 'notification',
            'as' => 'notification.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('', [NotificationController::class, 'index'])->name('index.get');
            Route::get('detail/{id?}', [NotificationController::class, 'detail'])->name('detail.get');
            Route::get('/delete/{id?}', [NotificationController::class, 'delete'])->name('delete.get');
        });

        //Status
        Route::group(['prefix' => 'usage-situation',
            'as' => 'usageSituation.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('', [UsageSituationController::class, 'index'])->name('index.get');
            Route::get('/detail/{trans_id?}', [UsageSituationController::class, 'detail'])->name('detail.get');
            Route::delete('/delete/{trans_id?}', [UsageSituationController::class, 'delete'])->name('delete.delete');
        });

        //MerchantStore management
        Route::group(['prefix' => 'merchant-store',
            'as' => 'merchant-store.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('detail/{id}', [MerchantController::class, 'detailMerchantStore'])->name('detail.get');
        });

        //Balance management
        Route::group(['prefix' => 'balance',
            'as' => 'balance.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('summary/{merchant_store_id}', [MerchantController::class, 'getBalanceSummary'])->name('summary.get');
        });

        //Payment screen
        Route::group(['prefix' => 'payment',
            'as' => 'payment.',
            'middleware' => ['can:merchant_all_role']
        ], function () {
            Route::get('', [MerchantController::class, 'getPaymentIndex'])->name('index.get');
            Route::post('createQR', [MerchantController::class, 'createQRForPayment'])->name('create.post');
        });
    });

});
