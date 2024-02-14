<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminEpay\AdminController;
use App\Http\Controllers\AdminEpay\AccountController;
use App\Http\Controllers\AdminEpay\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminEpay\Auth\RegisterController;
use App\Http\Controllers\AdminEpay\Auth\LoginController;
use App\Http\Controllers\AdminEpay\MerchantController;
use App\Http\Controllers\AdminEpay\DashboardController;
use App\Http\Controllers\AdminEpay\NotiController;
use App\Http\Controllers\AdminEpay\EpayWithdrawController;
use App\Http\Controllers\AdminEpay\BankController;
use App\Http\Controllers\AdminEpay\ReportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Define the "ADMIN E-PAY" routes for the application.
|
*/
Route::get('/', function () {
    return redirect('/admin-epay/login');
});

/**
 * Authentication
 */
Route::group(['prefix' => '/', 'as' => 'admin_epay.'], function () {
    // update code HA, add prefix, alias
    Route::group(['prefix' => '/auth', 'as' => 'auth.'], function () {
        Route::match(['get', 'post'], '/login', [LoginController::class, 'login'])->name('login');
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
        Route::match(["get", "post"], "/verify", [
            AdminController::class,
            "verify",
        ])->name("verify");

        Route::match(["get", "post"], "/forgot_password", [
            ForgotPasswordController::class,
            "forgotPassword",
        ])->name("forgot_password");

        Route::match(["get"], "/forgot_password_confirm", [
            ForgotPasswordController::class,
            "forgotPasswordConfirm",
        ])->name("forgot_password_confirm");

        Route::match(["get", "post"], "/change_password", [
            ForgotPasswordController::class,
            "change_password",
        ])->name("change_password");
        Route::get('verify-register/{id?}/{token?}', [RegisterController::class, 'verifyRegisterAccount'])->name('verify-register');
    });

    Route::group(['prefix' => '/bank', 'as' => 'bank.'], function () {
        Route::post('/check-bank', [BankController::class, 'checkBankCode'])->name('check_bank_code');
        Route::post('/check-branch-bank', [BankController::class, 'checkBranchBankCode'])->name('check_branch_bank');
    });

    Route::middleware('auth')->group(static function (): void {
        Route::group([
            'prefix' => 'dashboard',
            'as' => 'dashboard.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::get('', [DashboardController::class, 'index'])->name('index.get');
            Route::get('/detail', [DashboardController::class, 'detail'])->name('detail.get');
        });

        // Setting management
        Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
            Route::group([
                'prefix' => 'profile',
                'as' => 'profile.',
                'middleware' => ['can:epay_all_role']
            ], function () {
                Route::get('', [AdminController::class, 'getProfile'])->name('index');
                Route::post('change-pass', [AdminController::class, 'changePass'])->name('change_password');
                Route::post('update-profile', [AdminController::class, 'updateProfile'])->name('update_profile');
            });
        });

        // Account management
        Route::group([
            'prefix' => 'account',
            'as' => 'account.',
            'middleware' => ['can:epay_admin']
        ], function () {
            Route::get('', [AdminController::class, 'index'])->name('index.get');
            Route::get('create', [AdminController::class, 'create'])->name('create.get');
            Route::post('create', [AdminController::class, 'store'])->name('store.post');

            Route::get('detail/{id?}', [AccountController::class, 'detail'])->name('detail.get');
            Route::post('removeAccount', [AccountController::class, 'removeAccount'])->name('remove_account.post');
            Route::post('change-password', [AccountController::class, 'changePassword'])->name('change_password.post');
            Route::post('update-profile/{id?}', [AccountController::class, 'updateProfile'])->name('update_profile.post');
        });

        Route::group([
            'prefix' => 'merchant-store',
            'as' => 'merchantStore.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::get('', [MerchantController::class, 'index'])->name('index.get');
            Route::get('detail/{id?}', [MerchantController::class, 'detailMerchantStore'])->name('detail');
            Route::get('create', [MerchantController::class, 'viewCreateMerchantStore'])->name('view_create');
            Route::post('create', [MerchantController::class, 'createMerchantStore'])->name('create');
            Route::get('edit/{id?}', [MerchantController::class, 'viewEditMerchantStore'])->name('view_edit');
            Route::get('delete/{id?}', [MerchantController::class, 'deleteMerchantStore'])->name('delete');
            Route::post('edit/{id}', [MerchantController::class, 'updateMerchantStore'])->name('update');
            Route::post('check-post-code', [MerchantController::class, 'checkPostalCode'])->name('check_post_code');
            Route::post('check-group', [MerchantController::class, 'checkGroup'])->name('check_group');
            Route::post('change-pass', [MerchantController::class, 'changePass'])->name('change_password');
        });

        Route::group([
            'prefix' => 'notification',
            'as' => 'notification.',
            'middleware' => ['can:epay_admin']
        ], function () {
            Route::get('', [NotiController::class, 'index'])->name('index.get');
            Route::get('create', [NotiController::class, 'createNotification'])->name('createNotification.get');
            Route::post('store', [NotiController::class, 'storeSendNotification'])->name('storeSendNotification.post');
            Route::get('detail/{id?}', [NotiController::class, 'receiveDetail'])->name('detail.get');
            Route::get('update-template', [NotiController::class, 'viewTemplate'])->name('view_template.get');
            Route::post('update-template/{id?}', [NotiController::class, 'updateTemplate'])->name('update_template.post');
            Route::get('delete/{id?}', [NotiController::class, 'receiveDelete'])->name('receive_delete.get');
            Route::get('send-detail/{id?}', [NotiController::class, 'sendDetail'])->name('send_detail.get');
            Route::get('send-delete/{id?}', [NotiController::class, 'sendDelete'])->name('send_delete.get');
            Route::get('send-edit/{id?}', [NotiController::class, 'editNotification'])->name('send_edit.get');
            Route::post('send-edit/{id?}', [NotiController::class, 'editSendNotification'])->name('send_edit.post');
        });

        // Withdraw management
        Route::group([
            'prefix' => 'withdraw',
            'as' => 'withdraw.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::group(['prefix' => 'history', 'as' => 'history.'], function () {
                Route::get('', [EpayWithdrawController::class, 'getHistories'])->name('index.get');
                Route::get('detail/{id?}', [EpayWithdrawController::class, 'detail'])->name('detail.get');
                Route::get('edit/{id?}', [EpayWithdrawController::class, 'edit'])->name('edit.get');
                Route::post('update-withdraw/{id?}', [EpayWithdrawController::class, 'editWithdraw'])->name('edit.post');
                Route::get('delete-withdraw/{id?}', [EpayWithdrawController::class, 'deleteWithdraw'])->name('delete');
                Route::post('approve/{id?}', [EpayWithdrawController::class, 'approve'])->name('approve');
                Route::post('decline/{id?}', [EpayWithdrawController::class, 'decline'])->name('decline');
            });
            Route::group(['prefix' => 'request', 'as' => 'request.'], function () {
                Route::get('/create', [EpayWithdrawController::class, 'create'])->name('create.get');
                Route::post('/store', [EpayWithdrawController::class, 'store'])->name('store.post');
            });

            Route::get('/fiat-account-default/{id}', [EpayWithdrawController::class, 'getFiatAccountDefault'])->name('fiat-account-default.get');
            Route::get('/crypto-account-default/{id}', [EpayWithdrawController::class, 'getCryptoAccountDefault'])->name('crypto-account-default.get');
        });

        //Usage situation management
        Route::group([
            'prefix' => 'usage-situation/{id?}',
            'as' => 'usageSituation.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::get('', [MerchantController::class, 'usageSituationIndex'])->name('index.get');
            Route::get('/detail/{trans_id?}', [MerchantController::class, 'usageSituationDetail'])->name('detail.get');
            Route::delete('/delete/{trans_id?}', [MerchantController::class, 'usageSituationDelete'])->name('delete.delete');
            Route::post('/update/{trans_id?}', [MerchantController::class, 'usageSituationUpdate'])->name('update.post');
        });

        //Report
        Route::group([
            'prefix' => 'report',
            'as' => 'report.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::get('', [ReportController::class, 'index'])->name('index.get');
            Route::get('detail/{id?}', [ReportController::class, 'detail'])->name('detail.get');
            Route::get('edit/{id?}', [ReportController::class, 'edit'])->name('edit.get');
            Route::post('update-report/{id?}', [ReportController::class, 'editReport'])->name('edit.post');
            Route::get('delete-report/{id?}', [ReportController::class, 'deleteReport'])->name('delete');
            Route::post('send-report', [ReportController::class, 'sendMail'])->name('send');

        });

        //Balance management
        Route::group(['prefix' => 'balance',
            'as' => 'balance.',
            'middleware' => ['can:epay_all_role']
        ], function () {
            Route::get('summary/{merchant_store_id}', [MerchantController::class, 'getBalanceSummary'])->name('summary.get');
        });
    });
});
