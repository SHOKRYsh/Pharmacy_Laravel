<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;
use App\Models\Patient;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'userLogin' => 'required',
            'password' => 'required',
            'user_type' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $credentials = [
            'email' => $request->input('userLogin'),
            'password' => $request->input('password'),
            'user_type' => $request->input('user_type')
        ];

        if (Auth::attempt($credentials)) {
            return response()->json(['message' => 'done'], 201);
        } else {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:13', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_type' => ['required', 'string', 'in:pharmacist,patient'],
            'syndicate_id' => ['required_if:user_type,pharmacist', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            'profile_pic' => ['max:2048'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input()['email'],
            'phone' => $request->input()['phone'],
            'password' => Hash::make($request->input()['password']),
            'user_type' => $request->input()['user_type'],
        ]);
        if ($request->input()['user_type'] == 'pharmacist') {
            $syndicate_id = $request->input()['syndicate_id'];
            $profile_pic = isset($request->input()['profile_pic']) ? $request->input()['profile_pic'] : null;

            $pharmacistData = [
                'user_id' => $user->id,
                'syndicate_id' => $syndicate_id ? $this->uploadImage($syndicate_id, 'images/pharmacists/syndicate_id') : null,
                'image_url' => $profile_pic ? $this->uploadImage($profile_pic, 'images/pharmacists/profile_pic') : null,
            ];

            $pharmacist = Pharmacist::create(array_filter($pharmacistData));
        } else if ($request->input()['user_type'] == 'patient') {
            $profile_pic = isset($request->input()['profile_pic']) ? $request->input()['profile_pic'] : null;

            $patientData = [
                'user_id' => $user->id,
                'image_url' => $profile_pic ? $this->uploadImage($profile_pic, 'images/patients/profile_pic') : null,
            ];

            $patient = Patient::create(array_filter($patientData));
        }

        $user->sendEmailVerificationNotification();
        return response()->json(['message' => 'done'], 201);
    }

    public function uploadImage($image, $destination)
    {
        $photoName = $image->getClientOriginalName();
        $updatedPhotoName = time() . '_' . $photoName;
        $image->move($destination, $updatedPhotoName);

        return "$destination/$updatedPhotoName";
    }

    public function reset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $token = Password::createToken($user);

        $user->sendPasswordResetNotification($token);

        return response()->json(['message' => 'Password reset email sent']);
    }

    public function update(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
            'token' => 'required|string',
        ]);

        $response = Password::reset($request->only('email', 'password', 'password_confirmation', 'token'), function ($user, $password) {
            $user->password = bcrypt($password);
            $user->save();
        });

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password updated successfully']);
        } else {
            return response()->json(['message' => trans($response)], 400);
        }
    }
}
