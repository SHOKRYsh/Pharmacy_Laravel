<?php

namespace App\Http\Controllers\pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Order;
use App\Models\Pharmacist;
use App\Models\Pharmacy;
use App\Models\PharmacyDrug;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PharmacistController extends Controller
{
    //

    public function destroyAccount($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'pharmacist not found'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'pharmacist deleted successfully'], 200);
    }

    public function getInformation($id)
    {
        $user = User::with("pharmacist")->find($id);
        return response()->json(['message' => $user], 201);
    }

    public function information()
    {
        $user = Auth::user();
        $pharmacist = $user->pharmacist;
        return view("pharmacist.information", ["user" => $user, "pharmacist" => $pharmacist]);
    }
    public function storeInformation($user_id, Request $request)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $validatedData = $request->validate([
            'name' => 'string',
            'phone' => 'string',
            'profile_pic' => 'image',
        ]);

        $user->update($validatedData);

        if ($request->hasFile('profile_pic')) {
            $profile_pic = $request->file('profile_pic');
            $image_url = $this->uploadImage($profile_pic, 'images/pharmacists/profile_pic');
            $pharmacistData = ['image_url' => $image_url];
            $user->pharmacist()->updateOrCreate([], $pharmacistData);
        }

        return response()->json(['message' => "Data has been updated successfully"], 200);
    }

    private function uploadImage($image, $destination)
    {
        $photoName = $image->getClientOriginalName();
        $updatedPhotoName = time() . '_' . $photoName;
        $image->move($destination, $updatedPhotoName);

        return "$destination/$updatedPhotoName";
    }
    public function createPharmacy()
    {
        return view('pharmacist.create_pharmacy');
    }

    public function storePharmacy($pharmacist_id, Request $request)
    {

        $pharmacist = Pharmacist::find($pharmacist_id);
        if (!$pharmacist) {
            return response()->json(['message' => 'pharmacist not found'], 404);
        }

        $request->validate([
            'pharmacy_name' => 'required|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
            'delivery' => 'boolean'
        ]);

        $pharmacy_name = $request->input('pharmacy_name');
        $longitude = $request->input('longitude');
        $latitude = $request->input('latitude');
        $delivery = $request->input('delivery');


        $existingPharmacy = Pharmacy::where('pharmacist_id', $pharmacist_id)
            ->where('pharmacy_name', $pharmacy_name)
            ->where('longitude', $longitude)
            ->where('latitude', $latitude)
            ->where('delivery', $delivery)
            ->first();

        if ($existingPharmacy) {
            return response()->json(['message' => 'This pharmacy already exists for this pharmacist'], 400);
        }


        $pharmacy = Pharmacy::create([
            'pharmacist_id' => $pharmacist_id,
            'pharmacy_name' => $pharmacy_name,
            'longitude' => $longitude,
            'latitude' => $latitude,
            'delivery' => $delivery,
        ]);


        if ($pharmacy) {
            return response()->json(['message' => 'Pharmacy created successfully!'], 201);
        } else {
            return response()->json(['message' => "Sorry , we can't create the Pharmacy"], 400);
        }

        // return redirect()->back()->with('status', 'Pharmacy created successfully!');
    }


    public function updatePharmacy(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
            'pharmacy_name' => 'string',
            'longitude' => 'numeric',
            'latitude' => 'numeric',
            'delivery' => 'boolean',
        ]);

        $id = $request->input("pharmacy_id");
        $pharmacy = Pharmacy::find($id);

        if (!$pharmacy) {
            return response()->json(['message' => 'Pharmacy not found'], 404);
        }

        if ($request->has('pharmacy_name')) {
            $pharmacy->pharmacy_name = $request->input('pharmacy_name');
        }

        if ($request->has('longitude')) {
            $pharmacy->longitude = $request->input('longitude');
        }

        if ($request->has('latitude')) {
            $pharmacy->latitude = $request->input('latitude');
        }
        if ($request->has('delivery')) {
            $pharmacy->delivery = $request->input('delivery');
        }

        $pharmacy->save();

        return response()->json(['message' => 'Pharmacy updated successfully'], 200);
    }

    public function removePharmacy(Request $request)
    {
        $request->validate([
            'pharmacy_id' => 'required|exists:pharmacies,id',
        ]);

        $id = $request->input("pharmacy_id");
        $pharmacy = Pharmacy::find($id);

        if (!$pharmacy) {
            return response()->json(['message' => 'Pharmacy not found'], 404);
        }

        $pharmacy->delete();

        return response()->json(['message' => 'Pharmacy removed successfully'], 200);
    }

    public function chooseDrugs()
    {
        $drugs = Drug::paginate(15);

        $pharmacistId = Auth::id();
        $pharmacies = Pharmacy::where('pharmacist_id', $pharmacistId)->get();

        return view('pharmacist.choose_drugs', ["drugs" => $drugs, "pharmacies" => $pharmacies]);
    }

    public function storeDrugs(Request $request)
    {
        $jsonData = $request->getContent();
        $selectedDrugs = json_decode($jsonData, true);

        if ($selectedDrugs === null) {
            return response()->json(['message' => 'Invalid JSON format'], 400);
        }

        $validator = Validator::make(['selected_drugs' => $selectedDrugs], [
            'selected_drugs' => 'required|array',
            'selected_drugs.*.pharmacyId' => 'required|exists:pharmacies,id',
            'selected_drugs.*.drugId' => 'required|exists:drugs,id',
            'selected_drugs.*.quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation error', 'errors' => $validator->errors()], 400);
        }

        foreach ($selectedDrugs as $drug) {
            $pharmacyDrug = PharmacyDrug::where('pharmacy_id', $drug['pharmacyId'])
                ->where('drug_id', $drug['drugId'])
                ->first();

            if ($pharmacyDrug) {
                $pharmacyDrug->quantity += $drug['quantity'];
                $pharmacyDrug->save();
            } else {
                PharmacyDrug::create([
                    'pharmacy_id' => $drug['pharmacyId'],
                    'drug_id' => $drug['drugId'],
                    'quantity' => $drug['quantity'],
                ]);
            }
        }

        return response()->json(['message' => 'Drugs added/updated to pharmacy successfully!'], 201);
    }

    public function showPharmacies($pharmacist_id)
    {
        $pharmacies = Pharmacy::where('pharmacist_id', $pharmacist_id)->get();

        return response()->json(['message' => $pharmacies], 201);
        // return view('pharmacist.show_pharmacies', ["pharmacies" => $pharmacies]);
    }

    public function showPharmacyDrugs($pharmacyId)
    {
        $drugsWithQuantities = PharmacyDrug::where('pharmacy_id', $pharmacyId)
            ->join('drugs', 'pharmacy_drug.drug_id', '=', 'drugs.id')
            ->select('drugs.*', 'pharmacy_drug.quantity')
            ->get();
        return response()->json(['message' => $drugsWithQuantities], 201);

        // return view('pharmacist.show_drugs', ["pharmacy" => $pharmacy, "drugs" => $drugs]);
    }
    public function destroyDrug($pharmacyId, $drugId)
    {
        // dd($drugId);
        $pharmacy_drug = PharmacyDrug::where(['pharmacy_id' => $pharmacyId, 'drug_id' => $drugId]);
        if ($pharmacy_drug) {
            $pharmacy_drug->delete();
            return response()->json(['message' => "The Drug deleted successfully"], 201);
        } else {
            return response()->json(['message' => "The Drug not found for this pharmacy"], 400);
        }

        // return redirect()->back();
    }

    public function getAllDrugs()
    {
        $drugs = Drug::get();
        return response()->json(['message' => $drugs], 201);
    }

    public function getClients($pharmacy_id)
    {
        $orders = Order::where('pharmacy_id', $pharmacy_id)
            ->with(['patient.user', 'items.drug'])
            ->get();

        $patients = [];
        foreach ($orders as $order) {
            $patient = $order->patient;
            $user = $patient->user;
            $patientId = $patient->id;

            if (!isset($patients[$patientId])) {
                $patients[$patientId] = [
                    'patient' => [
                        'id' => $patient->id,
                        'user_id' => $patient->user_id,
                        'image_url' => $patient->image_url,
                        'address' => $patient->address,
                        'longitude' => $patient->longitude,
                        'latitude' => $patient->latitude,
                        'created_at' => $patient->created_at,
                        'updated_at' => $patient->updated_at,
                        'name' => $user->name,
                        'email' => $user->email,
                        'phone' => $user->phone,
                    ],
                    'orders' => [],
                ];
            }

            $orderItems = [];
            foreach ($order->items as $item) {
                $orderItems[] = [
                    'id' => $item->id,
                    'order_id' => $item->order_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'drug' => $item->drug,
                ];
            }

            $patients[$patientId]['orders'][] = [
                'id' => $order->id,
                'pharmacy_id' => $order->pharmacy_id,
                'total_amount' => $order->total_amount,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
                'finished' => $order->finished,
                'items' => $orderItems,
            ];
        }

        return response()->json(['message' => array_values($patients)], 201);
    }





    public function returnPharmacist(Request $request)
    {
        // $pharmacyId=$request->id;
        return $pharmacist = Pharmacist::with("pharmacies")->find(Auth::id());
    }


    public function getInabilityDrugs($pharmacy_id)
    {
        $drugs = PharmacyDrug::where('pharmacy_id', $pharmacy_id)
            ->where('quantity', '<=', 3)
            ->with('pharmacy', 'drug')
            ->get();

        $transformedDrugs = $drugs->map(function ($item) {
            return [
                'pharmacy_drug_id' => $item->id,
                'pharmacy' => $item->pharmacy,
                'drug' => $item->drug,
                'quantity' => $item->quantity,
            ];
        });

        return response()->json(['message' => $transformedDrugs], 200);
    }
}
