<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $guardName = 'admin';
    protected $maxAttempts = 3;
    protected $decayMinutes = 2;

    public function showLogin()
    {
       return view('admin.login');
    }

        // выход
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }

        // логинимся
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            $this->sendLockoutResponse($request);
        }

        $credential = [
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ];


        if (Auth::guard($this->guardName)->attempt($credential)) {
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);
            return redirect()->route('admin.university');
        }else {
            $this->incrementLoginAttempts($request);
            return redirect()->back()->with('error', 'Неверные данные для входа!');
        }

    }
}
