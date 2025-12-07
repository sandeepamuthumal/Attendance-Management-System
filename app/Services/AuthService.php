<?php

namespace App\Services;

use App\Models\Teacher;
use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\TeacherRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthService
{
    public function attemptLogin(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return ['error' => 'Email or Password not matches.'];
        }

        if (Auth::user()->status == 0) {
            Auth::logout();
            return ['error' => 'Your account is inactive.'];
        }

        session()->regenerate();

        session()->put('brightedu_user_type', Auth::user()->userType->user_type);

        return ['success' => true];
    }

    public function getDashboardRedirectUrl()
    {
        $type = Auth::user()->user_types_id;

        if ($type == 1) {
            return Session::pull('intended_url', '/admin-dashboard');
        }

        if ($type == 2) {
            return Session::pull('intended_url', '/teacher-dashboard');
        }

        return null;
    }

    public function logout($request)
    {
        Auth::logout();
        session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return true;
    }
}
