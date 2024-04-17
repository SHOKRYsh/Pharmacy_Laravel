<?php

use App\Http\Controllers\pharmacist\PharmacistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| pharmacist Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::prefix('/home/pharmacist/dashboard')->name('pharmacist.dashboard.')->middleware("auth")->group(function () {

//     Route::get("/createPharmacy", [PharmacistController::class, 'createPharmacy'])->name("createPharmacy");
//     Route::post("/storePharmacy", [PharmacistController::class, 'storePharmacy'])->name("storePharmacy");

//     Route::get("/chooseDrugs", [PharmacistController::class, 'chooseDrugs'])->name("chooseDrugs");
//     Route::post("/storeDrugs", [PharmacistController::class, 'storeDrugs'])->name("storeDrugs");

//     Route::get("/showPharmacies", [PharmacistController::class, 'showPharmacies'])->name("showPharmacies");
//     Route::get('/pharmacy/{pharmacyId}/drugs', [PharmacistController::class, 'showPharmacyDrugs'])->name('pharmacy.drugs');
//     Route::delete('/pharmacy/{pharmacyId}/drugs/{drugId}', [PharmacistController::class, 'destroyDrug'])->name('delete.drug');

//     // Route::get("ret", [PharmacistController::class, 'returnPharmacist'])->name("returnPharmacist");
// });
