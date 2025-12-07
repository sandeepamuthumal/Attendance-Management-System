<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->intended(
                $this->authService->getDashboardRedirectUrl()
            );
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
            $response = $this->authService->attemptLogin($credentials);

            if (isset($response['error'])) {
                return back()->with('error', $response['error']);
            }

            $url = $this->authService->getDashboardRedirectUrl();

            if (!$url) {
                return back()->with('error', 'You cannot access this page!');
            }

            return redirect()->intended($url);
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong');
        }
    }


    public function logout(Request $request)
    {
        $this->authService->logout($request);

        return redirect('/login');
    }
}
