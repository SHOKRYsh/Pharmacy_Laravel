<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientController extends Controller
{
    //

    /**
     * Class constructor.
     */

    public function donation()
    {
        dd(Auth::user());
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

        $alarm = Donation::create([
            'patient_id' => Auth::id(),
            'label' => $request->input()['label'],
            'repeat' => $request->input()['repeat'],
            'sound' => $request->input()['sound'],
            'time' => $request->input()['time'],
        ]);


        return redirect()->back()->with('status', 'Alarm is created successfully!');
    }
}
