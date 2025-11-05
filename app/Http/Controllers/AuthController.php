<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            return redirect()->intended($this->getRedirectPath($user));
        }

        return back()->withErrors([
            'email' => 'Kredensial tidak valid.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }

    private function getRedirectPath($user)
    {
        switch ($user->role) {
            case 'administrator':
                return '/dashboard';
            case 'waiter':
                return '/pesanan';
            case 'kasir':
                return '/transaksi';
            case 'owner':
                return '/laporan';
            default:
                return '/dashboard';
        }
    }
}
