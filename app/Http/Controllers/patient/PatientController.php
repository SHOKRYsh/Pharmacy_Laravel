<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Alarm;
use App\Models\PatientChronicDiseases;
use App\Models\Disease;
use App\Models\Donation;
use App\Models\Drug;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Pharmacy;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    //

    /**
     * Class constructor.
     */

    public function destroyAccount($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }

    public function getInformation($id)
    {
        $user = User::with("patient")->find($id);
        return response()->json(['message' => $user], 201);
    }
    public function information()
    {
        $user = Auth::user();
        $patient = $user->patient;
        return view("patient.information", ["user" => $user, "patient" => $patient]);
    }

    public function storeInformation($user_id, Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'profile_pic' => 'image',
            'address' => 'string',
            'longitude' => 'numeric',
            'latitude' => 'numeric',
        ]);

        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $userData = [];
        if (isset($validatedData['name'])) {
            $userData['name'] = $validatedData['name'];
        }
        if (isset($validatedData['phone'])) {
            $userData['phone'] = $validatedData['phone'];
        }
        $user->update($userData);

        $patientData = [];
        if (isset($validatedData['address'])) {
            $patientData['address'] = $validatedData['address'];
        }
        if (isset($validatedData['longitude'])) {
            $patientData['longitude'] = $validatedData['longitude'];
        }
        if (isset($validatedData['latitude'])) {
            $patientData['latitude'] = $validatedData['latitude'];
        }

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $patientData['image_url'] = $this->uploadImage($profile_pic, 'images/patients/profile_pic');
        }

        $user->patient()->updateOrCreate([], $patientData);

        return response()->json(['message' => "Data has been updated successfully"], 201);
    }

    private function uploadImage($image, $destination)
    {
        $photoName = $image->getClientOriginalName();
        $updatedPhotoName = time() . '_' . $photoName;
        $image->move($destination, $updatedPhotoName);

        return "$destination/$updatedPhotoName";
    }

    public function getAllDrugs()
    {
        $drugs = Drug::get();
        return response()->json(['message' => $drugs], 201);
    }


    public function showNearestPharmacies($id)
    {
        $patient = Patient::where('user_id', $id)->first();


        if (!$patient) {
            return response()->json(['message' => "The user id is wrong ,check it again"], 400);
        }

        $patientLongitude = $patient->longitude;
        $patientLatitude = $patient->latitude;

        $pharmacies = Pharmacy::select('pharmacist_id', 'pharmacy_name', 'longitude', 'latitude')->get();


        $nearestPharmacies = [];
        foreach ($pharmacies as $pharmacy) {
            $pharmacyLongitude = $pharmacy->longitude;
            $pharmacyLatitude = $pharmacy->latitude;

            $distance = $this->haversineDistance($patientLatitude, $patientLongitude, $pharmacyLatitude, $pharmacyLongitude);
            $name = User::where('id', $pharmacy->pharmacist_id)->first()->name;
            $nearestPharmacies[] = [
                'pharmacist' => $name,
                'name' => $pharmacy->pharmacy_name,
                'distance' => $distance,
            ];
        }

        usort($nearestPharmacies, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return response()->json(['message' => $nearestPharmacies], 201);
        // return view("patient.Pharmacies", ["nearestPharmacies" => $nearestPharmacies]);
    }

    public function showNearestPharmaciesWithDrug($id, $drug_id)
    {

        $patient = Patient::where('user_id', $id)->first();

        if (!$patient) {
            return response()->json(['message' => "The user id is wrong, check it again"], 400);
        }

        $patientLongitude = $patient->longitude;
        $patientLatitude = $patient->latitude;

        $pharmacies = Pharmacy::with('drugs')
            ->select('id', 'pharmacist_id', 'pharmacy_name', 'longitude', 'latitude')
            ->get();

        $nearestPharmacies = [];
        foreach ($pharmacies as $pharmacy) {
            $pharmacyLongitude = $pharmacy->longitude;
            $pharmacyLatitude = $pharmacy->latitude;

            $hasDrug = $pharmacy->drugs()->where('drugs.id', $drug_id)->exists();
            if ($hasDrug) {
                $distance = $this->haversineDistance($patientLatitude, $patientLongitude, $pharmacyLatitude, $pharmacyLongitude);
                $name = User::where('id', $pharmacy->pharmacist_id)->first()->name;
                $nearestPharmacies[] = [
                    'pharmacist' => $name,
                    'name' => $pharmacy->pharmacy_name,
                    'distance' => $distance,
                ];
            }
        }

        usort($nearestPharmacies, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return response()->json(['message' => $nearestPharmacies], 201);
    }




    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $deltaLat = deg2rad($lat2 - $lat1);
        $deltaLon = deg2rad($lon2 - $lon1);
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $distance = 6371 * $c; // Earth's radius in km

        return $distance;
    }

    public function donation()
    {
        // dd(Auth::user());
        return view("patient.donation");
    }
    public function storeDonation(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'drug_name' => 'required|string',
            'quantity' => 'required|numeric',
            'address' => 'required|string',
        ]);

        $patient = Patient::find($request->input()['patient_id']);
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong ,check it again"], 400);
        }
        // $patient_id = Patient::where("user_id", Auth::id())->first()->id;
        $donate = Donation::create([
            'patient_id' => $request->input()['patient_id'],
            'drug_name' => $request->input()['drug_name'],
            'quantity' => $request->input()['quantity'],
            'address' => $request->input()['address'],
        ]);

        return response()->json(['message' => "Donation is Confirmed successfully"], 201);
        // return redirect()->back()->with('status', 'Donation Confirmed successfully!');
    }
    public function getAllDonations($patient_id)
    {
        $patient = Patient::find($patient_id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $donations = $patient->donation;

        return response()->json(['message' => $donations], 201);
    }

    public function deleteDonation($patient_id, $donation_id)
    {
        $donation = Donation::where('patient_id', $patient_id)
            ->where('id', $donation_id)
            ->first();
        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        $donation->delete();

        return response()->json(['message' => 'Donation deleted successfully'], 201);
    }

    public function updateDonation(Request $request, $patient_id, $donation_id)
    {
        $validatedData = $request->validate([
            'drug_name' => 'string',
            'quantity' => 'numeric',
            'address' => 'string',
        ]);

        $donation = Donation::where('patient_id', $patient_id)
            ->where('id', $donation_id)
            ->first();

        if (!$donation) {
            return response()->json(['message' => 'Donation not found'], 404);
        }

        $donation->update($validatedData);

        return response()->json(['message' => 'Donation updated successfully'], 201);
    }

    public function alarm()
    {
        return view("patient.alarm");
    }
    public function storeAlarm(Request $request)
    {
        $request->validate([
            'patient_id' => 'required',
            'label' => 'required',
            'repeat' => 'required',
            'sound' => 'required',
            'time' => 'required',
        ]);

        $patient = Patient::find($request->input()['patient_id']);
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong ,check it again"], 400);
        }
        $alarm = Alarm::create([
            'patient_id' => $request->input()['patient_id'],
            'label' => $request->input()['label'],
            'repeat' => $request->input()['repeat'],
            'sound' => $request->input()['sound'],
            'time' => $request->input()['time'],
        ]);

        return response()->json(['message' => "Alarm is Confirmed successfully"], 201);
        // return redirect()->back()->with('status', 'Alarm is created successfully!');
    }
    public function getAllAlarms($patient_id)
    {
        $patient = Patient::find($patient_id);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $alarms = $patient->alarm;

        return response()->json(['message' => $alarms], 201);
    }
    public function deleteAlarm($patient_id, $alarm_id)
    {
        $alarm = Alarm::where('patient_id', $patient_id)
            ->where('id', $alarm_id)
            ->first();

        if (!$alarm) {
            return response()->json(['message' => 'Alarm not found'], 404);
        }

        $alarm->delete();
        return response()->json(['message' => 'Alarm deleted successfully'], 201);
    }
    public function updateAlarm(Request $request, $patient_id, $alarm_id)
    {
        $alarm = Alarm::where('patient_id', $patient_id)
            ->where('id', $alarm_id)
            ->first();

        if (!$alarm) {
            return response()->json(['message' => 'Alarm not found'], 404);
        }

        $validatedData = $request->validate([
            'label' => 'string',
            'repeat' => 'string',
            'sound' => 'string',
            'time' => 'string',
        ]);

        $alarm->update($validatedData);

        return response()->json(['message' => 'Alarm updated successfully'], 201);
    }

    public function getAllChroniDisease()
    {
        $diseases = Disease::get();
        // return view("message", $diseases);
        return response()->json(['message' => $diseases], 201);
    }

    public function disease()
    {
        $diseases = Disease::get();
        return view("patient.disease", ["diseases" => $diseases]);
    }
    public function storeDisease($patient_id, Request $request)
    {

        $patient = Patient::find($patient_id);
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong ,check it again"], 400);
        }

        $selectedDiseases = $request->input('chronic_diseases');
        // dd($selectedDiseases);
        foreach ($selectedDiseases as $diseaseId) {
            $checkExisting = PatientChronicDiseases::where('patient_id', $patient_id)
                ->where('disease_id', $diseaseId)
                ->exists();

            if (!$checkExisting) {
                PatientChronicDiseases::create([
                    'patient_id' => $patient_id,
                    'disease_id' => $diseaseId,
                ]);
            }
        }

        return response()->json(['message' => "Chronic diseases added successfully"], 201);
        // return redirect()->back()->with('status', 'Chronic diseases saved successfully!');
    }

    public function storePayment($patient_id, Request $request)
    {

        $patient = Patient::find($patient_id);
        $patinet_User_Id = $patient->user_id;
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong ,check it again"], 400);
        }

        $request->validate([
            'amount' => 'required',
        ]);

        $user = User::where("id", $patinet_User_Id)->first();
        // $user = Auth::user();
        $payment = Payment::create([
            'patient_id' => $patient_id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'amount' => $request->input()['amount'],
        ]);

        return response()->json(['message' => "The payment is stored successfully"], 201);
        // return redirect()->back()->with('status', 'Pauymet process is stored successfully!');
    }

    public function storeOrder(Request $request, $patient_id, $pharmacy_id)
    {
        $patient = Patient::find($patient_id);
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong, check it again"], 400);
        }

        $pharmacy = Pharmacy::find($pharmacy_id);
        if (!$pharmacy) {
            return response()->json(['message' => "The pharmacy isn't found, check it again"], 400);
        }

        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.drug_id' => 'required|exists:drugs,id',
            'items.*.quantity' => 'required|numeric|min:1',
        ]);

        $order = Order::create([
            'patient_id' => $patient_id,
            'pharmacy_id' => $pharmacy_id,
            'total_amount' => 0
        ]);

        $totalAmount = 0;

        foreach ($request->input('items') as $item) {
            $drug = Drug::find($item['drug_id']);
            if (!$drug) {
                return response()->json(['message' => "Drug with ID {$item['drug_id']} not found"], 404);
            }

            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'drug_id' => $item['drug_id'],
                'quantity' => $item['quantity'],
                'price' => $item['quantity'] * $drug->price,
            ]);

            $totalAmount += $orderItem->price;
        }

        $order->total_amount = $totalAmount;
        $order->save();

        return response()->json(['message' => 'Order is created successfully'], 201);
    }

    public function getAllOrders($patient_id)
    {
        $patient = Patient::find($patient_id);
        if (!$patient) {
            return response()->json(['message' => "The patient id is wrong, check it again"], 400);
        }

        $orders = Order::with('items')->where('patient_id', $patient_id)->get();

        return response()->json(['message' => $orders], 200);
    }
}
