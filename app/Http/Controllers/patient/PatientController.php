<?php

namespace App\Http\Controllers\patient;

use App\Http\Controllers\Controller;
use App\Models\Alarm;
use App\Models\Donation;
use App\Models\Patient;
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
}
