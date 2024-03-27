<?php

namespace App\Http\Controllers\pharmacist;

use App\Http\Controllers\Controller;
use App\Models\Drug;
use App\Models\Pharmacist;
use App\Models\Pharmacy;
use App\Models\PharmacyDrug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacistController extends Controller
{
    //
    public function createPharmacy()
    {
        return view('pharmacist.create_pharmacy');
    }

    public function storePharmacy(Request $request)
    {
        $request->validate([
            'pharmacy_name' => 'required|string',
            'longitude' => 'required|numeric',
            'latitude' => 'required|numeric',
        ]);

        $pharmacy = Pharmacy::create([
            'pharmacist_id' => Auth::id(),
            'pharmacy_name' => $request->input()['pharmacy_name'],
            'longitude' => $request->input()['longitude'],
            'latitude' => $request->input()['latitude'],
        ]);


        return redirect()->back()->with('status', 'Pharmacy created successfully!');
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
        $selectedDrugs = json_decode($request->input('selected_drugs'), true);

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

        return redirect()->back()->with('success', 'Drugs added successfully!');
    }

    public function showPharmacies()
    {
        $pharmacistId = Auth::id();
        $pharmacies = Pharmacy::where('pharmacist_id', $pharmacistId)->get();

        return view('pharmacist.show_pharmacies', ["pharmacies" => $pharmacies]);
    }

    public function showPharmacyDrugs($pharmacyId)
    {
        $pharmacy = Pharmacy::findOrFail($pharmacyId);
        $drugs = $pharmacy->drugs()->get();
        return view('pharmacist.show_drugs', ["pharmacy" => $pharmacy, "drugs" => $drugs]);
    }

    public function destroyDrug($pharmacyId, $drugId)
    {
        // dd($drugId);
        PharmacyDrug::where(['pharmacy_id' => $pharmacyId, 'drug_id' => $drugId])->delete();
        return redirect()->back();
    }


    public function returnPharmacist(Request $request)
    {
        // $pharmacyId=$request->id;
        return $pharmacist = Pharmacist::with("pharmacies")->find(Auth::id());
    }
}
