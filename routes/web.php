<?php

use App\Http\Controllers\patient\PatientController;
use App\Http\Controllers\pharmacist\PharmacistController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
    return view("auth.login");
});


Auth::routes(["verify" => true]);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(["auth", "verified"]);



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


    /*
    ***********************************************************************************************************
    *******************************************PHARMACIST ROUTES **********************************************
    ***********************************************************************************************************
    */

    Route::prefix('/home/pharmacist/dashboard')->name('pharmacist.dashboard.')->middleware("auth")->group(function () {

        Route::get("/createPharmacy", [PharmacistController::class, 'createPharmacy'])->name("createPharmacy");
        Route::post("/storePharmacy", [PharmacistController::class, 'storePharmacy'])->name("storePharmacy");

        Route::get("/chooseDrugs", [PharmacistController::class, 'chooseDrugs'])->name("chooseDrugs");
        Route::post("/storeDrugs", [PharmacistController::class, 'storeDrugs'])->name("storeDrugs");

        Route::get("/showPharmacies", [PharmacistController::class, 'showPharmacies'])->name("showPharmacies");
        Route::get('/pharmacy/{pharmacyId}/drugs', [PharmacistController::class, 'showPharmacyDrugs'])->name('pharmacy.drugs');
        Route::delete('/pharmacy/{pharmacyId}/drugs/{drugId}', [PharmacistController::class, 'destroyDrug'])->name('delete.drug');

        // Route::get("ret", [PharmacistController::class, 'returnPharmacist'])->name("returnPharmacist");
    });




    /*
    ***********************************************************************************************************
    *******************************************PATIENT ROUTES **********************************************
    ***********************************************************************************************************
    */




    Route::prefix('/home/patient/dashboard')->name('patient.dashboard.')->middleware('auth')->group(function () {
        Route::get('/donation', [PatientController::class, 'donation']);
        Route::post('/storeDonation', [PatientController::class, 'storeDonation'])->name('storeDonation');

        Route::get('/alarm', [PatientController::class, 'alarm'])->name('alarm');
        Route::post('/storeAlarm', [PatientController::class, 'storeAlarm'])->name('storeAlarm');

        Route::get('/information', [PatientController::class, 'information']);
        Route::post('/storeInformation', [PatientController::class, 'storeInformation'])->name('storeInformation');

        Route::get('/disease', [PatientController::class, 'disease']);
        Route::post('/storeDisease', [PatientController::class, 'storeDisease'])->name('storeDisease');

        Route::post('/storePayment', [PatientController::class, 'storePayment'])->name('storePayment');

        Route::post('/storeOrder', [PatientController::class, 'storeOrder'])->name('storeOrder');

        Route::get('/showNearestPharmacies', [PatientController::class, 'showNearestPharmacies']);
    });
});
