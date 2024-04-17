<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Admin;
use App\Models\Pharmacist;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Imports\DrugsImport;
use App\Models\Donation;
use App\Models\Drug;
use Maatwebsite\Excel\Facades\Excel;


class AdminController extends Controller
{
    use AuthenticatesUsers;

    //
    // app/Http/Controllers/AdminController.php


    protected $redirectTo = RouteServiceProvider::AdminHOME;
    public function __construct()
    {
        // $this->middleware('guest:admin')->except("logout");
        $this->middleware('web');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
    public function login()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route("admin.dashboard");
        } else {
            return view('admin.auth.login');
        }
    }
    public function check(Request $request)
    {
        $request->validate([
            "email" => "required|string",
            "password" => "required|string",

        ]);

        if (Auth::guard('admin')->attempt(["email" => $request->email, "password" => $request->password])) {
            return redirect()->route("admin.dashboard");
        } else {
            return redirect()->back()->withInput(["email" => $request->email])->with("errorResponse", "These credentials don't match our records");
        }
    }
    public function register()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route("admin.dashboard");
        } else {
            return view('admin.auth.register');
        }
    }
    public function store(Request $request)
    {
        $admin_key = "adminKey1";

        if ($request->admin_key == $admin_key) {
            $request->validate([
                "name" => "required|string",
                "email" => "required|string",
                "phone" => "required|string",
                "admin_key" => "required|string",
                "password" => "required|string|confirmed",

            ]);

            $user = User::create([
                "name" => $request->name,
                "email" => $request->email,
                "phone" => $request->phone,
                "password" => Hash::make($request->password),
                "user_type" => "admin",
            ]);
            Admin::create([
                "user_id" => $user->id,
                "name" => $request->name,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);

            return redirect()->route("admin.dashboard");
        } else {
            return redirect()->back()->with("errorResponse", "something went wrong");
        }
    }

    public function logout()
    {
        Auth::guard("admin")->logout();
        return redirect()->route("admin.login");
    }

    public function approval()
    {
        $unapprovedPharmacists = Pharmacist::with('user')->where('approved', false)->get();

        return view('admin.functions.approval', ["pharmacists" => $unapprovedPharmacists]);
    }

    public function approvalupdate(string $id)
    {
        $pharmacist = Pharmacist::find($id);

        if ($pharmacist) {
            $pharmacist->approved = 1;
            $pharmacist->save();
            return redirect()->back()->with('success', 'Pharmacist approved successfully.');
        }

        return redirect()->back()->with('error', 'Pharmacist not found.');
    }
    public function approvalDestroy(string $id)
    {
        $pharmacist = Pharmacist::find($id);

        if ($pharmacist) {
            $user = User::find($pharmacist->user_id);

            if ($user) {
                $user->delete();
            }
            $pharmacist->delete();
            return redirect()->back()->with('success', 'Pharmacist and associated user deleted successfully.');
        }

        return redirect()->back()->with('error', 'Pharmacist not found.');
    }
    public function addDrugs(Request $request)
    {
        $drugs = Drug::paginate(15);
        return view('admin.functions.add_drugs', ["drugs" => $drugs]);
    }
    public function upload(Request $request)
    {
        request()->validate([
            'drugs' => 'required'
        ]);
        $file = $request->file('drugs');

        Excel::import(new DrugsImport, $file);


        return redirect()->back()->with('status', 'Imported Successfully');
    }

    public function donation()
    {
        $name = Auth::user()->name;
        $donations = Donation::get();
        return view('admin.functions.donation', ["donations" => $donations, "name" => $name]);
    }
}
