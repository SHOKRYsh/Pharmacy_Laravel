<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\patient\PatientController;
use App\Http\Controllers\pharmacist\PharmacistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);
Route::post("/password/reset", [AuthController::class, "reset"]);

/*
***********************************************************************************************************
*******************************************PHARMACIST ROUTES **********************************************
***********************************************************************************************************
*/


Route::prefix('/home/pharmacist/dashboard')->group(function () {

    Route::delete("/destroyAccount/{id}", [PharmacistController::class, 'destroyAccount']);

    Route::get('/getInformation/{id}', [PharmacistController::class, 'getInformation']);

    Route::post('/storeInformation/{user_id}', [PharmacistController::class, 'storeInformation']);

    Route::post("/pharmacist/{pharmacist_id}/storePharmacy", [PharmacistController::class, 'storePharmacy']);
    Route::put("/updatePharmacy", [PharmacistController::class, 'updatePharmacy']);
    Route::delete("/removePharmacy", [PharmacistController::class, 'removePharmacy']);

    Route::post("/storeDrugs", [PharmacistController::class, 'storeDrugs']);

    Route::get("/showPharmacies/pharmacist/{pharmacist_id}", [PharmacistController::class, 'showPharmacies']);

    Route::get('/pharmacy/{pharmacyId}/drugs', [PharmacistController::class, 'showPharmacyDrugs']);
    Route::delete('/pharmacy/{pharmacyId}/drugs/{drugId}', [PharmacistController::class, 'destroyDrug']);

    Route::get('/getAllDrugs', [PharmacistController::class, 'getAllDrugs']);

    Route::get('/pharmacy/{pharmacy_id}/getClients', [PharmacistController::class, 'getClients']);
    Route::get('/pharmacy/{pharmacy_id}/get-inability-drugs', [PharmacistController::class, 'getInabilityDrugs']);
});


/*
***********************************************************************************************************
*******************************************PATIETN ROUTES **********************************************
***********************************************************************************************************
*/



Route::prefix('/home/patient/dashboard')->group(function () {

    Route::delete("/destroyAccount/{id}", [PatientController::class, 'destroyAccount']);

    Route::get('/getInformation/{id}', [PatientController::class, 'getInformation']);

    Route::post('/storeInformation/{user_id}', [PatientController::class, 'storeInformation']);

    Route::get('/getAllDrugs', [PatientController::class, 'getAllDrugs']);

    Route::get('/showNearestPharmacies/user/{id}', [PatientController::class, 'showNearestPharmacies']);

    Route::get('/showNearestPharmacies/user/{id}/drug/{drug_id}', [PatientController::class, 'showNearestPharmaciesWithDrug']);

    Route::post('/storeDonation', [PatientController::class, 'storeDonation']);
    Route::get('/getAllDonations/{patient_id}', [PatientController::class, 'getAllDonations']);
    Route::delete('/delete/{patient_id}/donations/{donation_id}', [PatientController::class, 'deleteDonation']);
    Route::put('/patients/{patient_id}/donations/{donation_id}', [PatientController::class, 'updateDonation']);

    Route::post('/storeAlarm', [PatientController::class, 'storeAlarm']);
    Route::get('/getAllAlarms/{patient_id}', [PatientController::class, 'getAllAlarms']);
    Route::delete('/delete/{patient_id}/alarms/{alarm_id}', [PatientController::class, 'deleteAlarm']);
    Route::put('/patients/{patient_id}/alarms/{alarm_id}', [PatientController::class, 'updateAlarm']);

    Route::get('/getAllChroniDisease', [PatientController::class, 'getAllChroniDisease']);
    Route::post('/storeDisease/{patient_id}', [PatientController::class, 'storeDisease']);

    Route::post('/storePayment/{patient_id}', [PatientController::class, 'storePayment']);

    Route::get('/{patient_id}/getAllOrders', [PatientController::class, 'getAllOrders']);
    Route::post('/storeOrder/patient/{patient_id}/pharmacy/{pharmacy_id}', [PatientController::class, 'storeOrder']);
    Route::put('patient/orders/{order_id}/finished', [PatientController::class, 'updateOrderStatus']);
    Route::delete('/delete/{patient_id}/order/{order_id}', [PatientController::class, 'deleteOrder']);

    Route::get('/{patient_id}/getAllCarts', [PatientController::class, 'getAllCarts']);
    Route::post('/storeCart/patient/{patient_id}/pharmacy/{pharmacy_id}', [PatientController::class, 'storeCart']);
    Route::delete('/delete/{patient_id}/cart/{cart_id}', [PatientController::class, 'deleteCart']);

    Route::post('/extract-medicine-name', [PatientController::class, 'extractMedicineName']);
});

////////////
Route::post("/sendMessage/sender/{sender_id}/reciever/{reciever_id}", [ChatController::class, 'sendMessage']);
Route::get("/getMessages/sender/{sender_id}/reciever/{reciever_id}", [ChatController::class, 'getmessages']);
///////////
Route::post('/{user_id}/add/comment', [CommentController::class, 'addComment'])->name('comments.add');
