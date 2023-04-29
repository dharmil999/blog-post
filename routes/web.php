<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

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

Route::get('/', function () {
    return redirect(route('admin.login.show'));
});


Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index')->name('admin.login.show')->middleware('guest');
    Route::post('login', 'login')->name('admin.login.login')->middleware('guest');
    Route::post('logout', 'logout')->name('admin.logout');

    Route::get('admin/register', 'registerview')->name('admin.register.show');
    Route::get('blogger/register', 'bloggerRegisterview')->name('blogger.register.show');
    Route::post('admin/register', 'registerPost')->name('admin.register.post');
    Route::post('blogger/register', 'bloggerRegisterPost')->name('blogger.register.post');



    Route::middleware(['auth','permission'])->group(function () {
        Route::prefix('admin')->group(function () {
            Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

            Route::name('admin.')->group(function () {
                Route::resource('users', UserController::class);
                Route::controller(UserController::class)->group(function () {
                    Route::post('getusers', 'postUsersList')->name('getusers');
                });
            });
        });
    });
});
