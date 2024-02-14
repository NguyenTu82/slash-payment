<?php

use App\Http\Controllers\AdminEpay\Admin\AdminController;
use App\Http\Controllers\AdminEpay\Auth\ForgotPasswordController;
use App\Http\Controllers\AdminEpay\Auth\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect()->route('admin_epay.auth.login');
});

Route::get('change-language/{language}', function($language){
    \Session::put('website_language', $language);
    return redirect()->back();
})->name('change_language');
