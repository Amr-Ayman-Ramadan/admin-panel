<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;
use App\Exports\UsersExport;
use Maatwebsite\Excel\Facades\Excel;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/",[AdminController::class,'index'])->name('dashboard')->middleware('auth');


Route::group(['prefix'=>'auth','as'=>'auth.'], function () {
   Route::controller(AuthController::class)->group(function () {
       Route::get('/login', 'loginPage')->name('loginPage')->middleware('guest');
       Route::post('/login', 'login')->name('login');
       Route::get('/forget-password', 'forgetPasswordPage')->name('forgetPasswordPage')->middleware('guest');
       Route::post('/forget-password', 'forgetPassword')->name('forgetPassword');
       Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('reset-password-form');
       Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
       Route::get("logout", "logout")->name('logout')->middleware('auth');
   }) ;
});

Route::group(['prefix'=>'users','as'=>'users.','middleware'=>'auth'], function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{user}/edit', 'edit')->name('edit');
        Route::put('/{user}/update', 'update')->name('update');
        Route::delete('/{user}', 'destroy')->name('destroy');
        Route::get('/{user}/change-status','changeStatus')->name('changeStatus');

        Route::get('/export', function () {
            return Excel::download(new UsersExport, 'users.xlsx');
        })->name('export');
    });
});


