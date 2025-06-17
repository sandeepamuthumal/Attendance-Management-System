<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function loginProcess(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                if (Auth::user()->status == 0) {
                    return back()->with('error', 'Your account is inactive.');
                }
                $request->session()->regenerate();

                //set sessions
                $user_type = DB::table('user_types')->where('id', Auth::user()->user_types_id)->first();
                session()->put('tickets_director_user_type', $user_type->user_type);

                // Retrieve the intended URL or default to dashboard
                if (Auth::user()->user_types_id == 1) {
                    $intendedUrl = Session::pull('intended_url', '/admin-dashboard');
                } else if (Auth::user()->user_types_id == 2) {
                    $intendedUrl = Session::pull('intended_url', '/manager-dashboard');
                } else {
                    return back()->with('error', 'You cannot access this page!');
                }

                return redirect()->intended($intendedUrl);
            } else {
                return back()->with('error', 'Email or Password not matches.');
            }
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }

    public function redirectToDashboard()
    {
        if (Auth::user()->user_types_id == 1) {
            $intendedUrl = Session::pull('intended_url', '/admin-dashboard');
        } else if (Auth::user()->user_types_id == 2) {
            $intendedUrl = Session::pull('intended_url', '/manager-dashboard');
        } else {
            return back()->with('error', 'You cannot access this page!');
        }

        return redirect()->intended($intendedUrl);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        session()->flush(); //clear all session data

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
