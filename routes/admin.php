<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\AdminFunctionsController;
use Illuminate\Support\Facades\Route;


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



Route::prefix("admin/")->name("admin.")->group(function () {

    Route::middleware("auth:admin")->group(function () {

        Route::get('dashboard', [AdminController::class, "dashboard"])->name('dashboard');
        Route::get('dashboard/approval', [AdminController::class, "approval"])->name('approval');
        Route::post('dashboard/approval/{id}', [AdminController::class, "approvalUpdate"])->name('approval.update');
        Route::post('dashboard/approval/delete/{id}', [AdminController::class, "approvalDestroy"])->name('approval.destroy');

        Route::get('dashboard/addDrugs', [AdminController::class, "addDrugs"])->name('add.drugs');
        Route::post('dashboard/upload', [AdminController::class, "upload"])->name('upload.drugs');
    });

    Route::controller(AdminController::class)->group(function () {

        Route::get('login', "login")->name('login')->middleware("guest:admin");

        Route::post('login', "check")->name('login.check');

        Route::get('register', "register")->name('register')->middleware("guest:admin");

        Route::post('register', "store")->name('register.store');

        Route::post('logout', "logout")->name('logout');
    });
});
