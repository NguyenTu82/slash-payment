<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| Define the "affiliate" routes for the application.
|
*/

Route::get('/home', function() {
    return 'admin affiliate home';
});
