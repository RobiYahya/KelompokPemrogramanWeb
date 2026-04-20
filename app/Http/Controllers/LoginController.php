<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
=======
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }
<<<<<<< HEAD

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'id_pegawai' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['id_pegawai' => $credentials['id_pegawai'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'id_pegawai' => 'ID Pegawai atau password salah.',
        ])->withInput($request->only('id_pegawai'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
=======
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
}
