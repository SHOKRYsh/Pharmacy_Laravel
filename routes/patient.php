<?php

use App\Http\Controllers\patient\PatientController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Patinet Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('/home/patient/dashboard/')->name('patient.dashboard.')->group(function () {

    Route::get("donation", [PatientController::class, "donation"]);
    Route::post("storeDonation", [PatientController::class, 'storeDonation'])->name("storeDonation");

    Route::get("alarm", [PatientController::class, "alarm"]);
    Route::post("storeAlarm", [PatientController::class, 'storeAlarm'])->name("storeAlarm");
});
