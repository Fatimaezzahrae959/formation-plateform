<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // محاولة تسجيل الدخول
        if (Auth::attempt($credentials)) {

            // حماية session
            $request->session()->regenerate();

            // نجيبو user دابا (دابا راه logged in)
            $user = Auth::user();

            // redirection حسب role
            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role == 'formateur') {
                return redirect()->route('formateur.dashboard');
            } else {
                return redirect()->route('participant.dashboard');
            }
        }

        // إلا فشل login
        return back()->withErrors([
            'email' => 'Email ou mot de passe incorrect'
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}