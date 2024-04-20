<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Alarm;
use App\Models\PatientChronicDiseases;
use App\Models\Disease;
use App\Models\Donation;
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

    public function information()
    {
        $user = Auth::user();
        $patient = $user->patient;
        return view("patient.information", ["user" => $user, "patient" => $patient]);
    }
    public function storeInformation(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'profile_pic' => 'image',
            'address' => 'string',
            'longitude' => 'string:',
            'latitude' => 'string',
        ]);

        $userId = auth()->user()->id;
        $criteria = ['user_id' => $userId];

        $user = User::find($userId);

        $user->update([
            'name' => $validatedData['name'],
            'phone' => $validatedData['phone'],
        ]);


        $profile_pic = $request->hasFile('profile_pic') ? $request->file('profile_pic') : null;


        $patientData = [
            'address' => $validatedData['address'],
            'longitude' => $validatedData['longitude'],
            'latitude' => $validatedData['latitude'],
        ];

        if ($profile_pic) {
            $patientData['image_url'] = $this->uploadImage($profile_pic, 'images/patients/profile_pic');
        }

        Patient::updateOrCreate($criteria, $patientData);

        return redirect()->route('home');
    }

    private function uploadImage($image, $destination)
    {
        $photoName = $image->getClientOriginalName();
        $updatedPhotoName = time() . '_' . $photoName;
        $image->move($destination, $updatedPhotoName);

        return "$destination/$updatedPhotoName";
    }


    public function disease()
    {
        $diseases = Disease::get();
        return view("patient.disease", ["diseases" => $diseases]);
    }
    public function storeDisease(Request $request)
    {
        $selectedDiseases = $request->input('chronic_diseases');
        $patient = auth()->user();
        foreach ($selectedDiseases as $diseaseId) {
            $checkExisting = PatientChronicDiseases::where('patient_id', $patient->id)
                ->where('disease_id', $diseaseId)
                ->exists();

            if (!$checkExisting) {
                PatientChronicDiseases::create([
                    'patient_id' => $patient->id,
                    'disease_id' => $diseaseId,
                ]);
            }
        }

        return redirect()->back()->with('status', 'Chronic diseases saved successfully!');
    }

    public function donation()
    {
        // dd(Auth::user());
        return view("patient.donation");
    }
    public function storeDonation(Request $request)
    {
        $request->validate([
            'drug_name' => 'required|string',
            'quantity' => 'required|numeric',
            'address' => 'required|string',
        ]);

        $donate = Donation::create([
            'patient_id' => Auth::id(),
            'drug_name' => $request->input()['drug_name'],
            'quantity' => $request->input()['quantity'],
            'address' => $request->input()['address'],
        ]);


        return redirect()->back()->with('status', 'Donation Confirmed successfully!');
    }

    public function alarm()
    {
        return view("patient.alarm");
    }
    public function storeAlarm(Request $request)
    {
        $request->validate([
            'label' => 'required',
            'repeat' => 'required',
            'sound' => 'required',
            'time' => 'required',
        ]);

        $alarm = Alarm::create([
            'patient_id' => Auth::id(),
            'label' => $request->input()['label'],
            'repeat' => $request->input()['repeat'],
            'sound' => $request->input()['sound'],
            'time' => $request->input()['time'],
        ]);


        return redirect()->back()->with('status', 'Alarm is created successfully!');
    }
    public function storePayment(Request $request)
    {
        $request->validate([
            'amount' => 'required',
        ]);

        $user = Auth::user();
        $payment = Payment::create([
            'patient_id' => Auth::id(),
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'amount' => $request->input()['amount'],
        ]);


        return redirect()->back()->with('status', 'Pauymet process is stored successfully!');
    }
    public function storeOrder(Request $request)
    {
        $validatedData = $request->validate([
            'total_amount' => 'required|numeric',
            'items.*.drug_id' => 'required|exists:drugs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $order = Order::create([
            'patient_id' => Auth::id(),
            'total_amount' => $request->input()['total_amount'],
        ]);
        foreach ($validatedData['items'] as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'drug_id' => $item['drug_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        return redirect()->back()->with('status', 'Order is created successfully!');
        // return response()->json(['order' => $order]);
    }

    public function showNearestPharmacies()
    {
        $patient = Patient::where('user_id', Auth::user()->id)->first();
        $patientLongitude = $patient->longitude;
        $patientLatitude = $patient->latitude;


        $pharmacies = Pharmacy::select('id', 'pharmacy_name', 'longitude', 'latitude')->get();


        $nearestPharmacies = [];
        foreach ($pharmacies as $pharmacy) {
            $pharmacyLongitude = $pharmacy->longitude;
            $pharmacyLatitude = $pharmacy->latitude;

            $distance = $this->haversineDistance($patientLatitude, $patientLongitude, $pharmacyLatitude, $pharmacyLongitude);

            $nearestPharmacies[] = [
                'id' => $pharmacy->id,
                'name' => $pharmacy->pharmacy_name,
                'distance' => $distance,
            ];
        }

        usort($nearestPharmacies, function ($a, $b) {
            return $a['distance'] <=> $b['distance'];
        });

        return response()->json($nearestPharmacies);
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
}
