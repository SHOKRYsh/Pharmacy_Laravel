<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacist;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        $value = request()->input("userLogin");
        if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
            request()->merge(['email' => $value]);
            return "email";
        } elseif (preg_match("//", $value)) {
            request()->merge(['phone' => $value]);
            return "phone";
        } else {
            request()->merge(['email' => $value]);
            return "email";
        }
    }

    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['user_type'] = $request->input('user_type');
        return $credentials;
    }
    protected function validateLogin(Request $request)
    {
        $request->validate(
            [
                'userLogin' => 'required|string',
                'password' => 'required|string',
                'user_type' => 'required',
            ],
            [
                "userLogin.required" => "Email or phone is required"
            ]
        );
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            'userLogin' => [trans('auth.failed')],
            'user_type' => [trans('auth.failed')],
        ]);
    }


    protected function authenticated(Request $request, $user)
    {
        //

        if ($user->user_type == 'pharmacist') {
            $pharmacist = Pharmacist::where('user_id', $user->id)->first();

            if ($pharmacist && $pharmacist->approved == 0) {
                auth()->logout();
                return redirect('/login')->with('error', 'Your account is not approved yet. Please wait for admin approval.');
            }
        }
        return redirect()->intended($this->redirectPath());
    }
}
