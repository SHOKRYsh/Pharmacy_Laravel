<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', 'in:pharmacist,patient'],
            'syndicate_id' => ['required_if:user_type,pharmacist', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'profile_pic' => ['max:2048'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'user_type' => $data['user_type'],
        ]);

        if ($data['user_type'] == 'pharmacist') {
            $syndicate_id = $data['syndicate_id'];
            $profile_pic = isset($data['profile_pic']) ? $data['profile_pic'] : null;

            $pharmacistData = [
                'user_id' => $user->id,
                'syndicate_id' => $syndicate_id ? $this->uploadImage($syndicate_id, 'images/pharmacists/syndicate_id') : null,
                'image_url' => $profile_pic ? $this->uploadImage($profile_pic, 'images/pharmacists/profile_pic') : null,
            ];

            $pharmacist = Pharmacist::create(array_filter($pharmacistData));
        } else if ($data['user_type'] == 'patient') {
            $profile_pic = isset($data['profile_pic']) ? $data['profile_pic'] : null;

            $patientData = [
                'user_id' => $user->id,
                'image_url' => $profile_pic ? $this->uploadImage($profile_pic, 'images/patients/profile_pic') : null,
            ];

            $patient = Patient::create(array_filter($patientData));
        }

        return $user;
    }


    private function uploadImage($image, $destination)
    {
        $photoName = $image->getClientOriginalName();
        $updatedPhotoName = time() . '_' . $photoName;
        $image->move($destination, $updatedPhotoName);

        return "$destination/$updatedPhotoName";
    }

    protected function registered(Request $request, $user)
    {
        if ($user->user_type == "pharmacist") {
            Auth()->logout();
            return redirect()->route("login");
        }
    }
}
