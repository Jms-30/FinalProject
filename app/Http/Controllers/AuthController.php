<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:40',
            'email' => 'required|string|email|endsWith:@gmail.com|unique:users,email',
            'password' => 'required|string|min:6|max:12',
            'phone_number' => 'required|string|regex:/^08/',
        ], [
            'name.min' => 'Nama Lengkap minimal 3 huruf.',
            'name.max' => 'Nama Lengkap maksimal 40 huruf.',
            'email.endsWith' => 'Email harus menggunakan format @gmail.com.',
            'password.min' => 'Password minimal 6 huruf.',
            'password.max' => 'Password maksimal 12 huruf.',
            'phone_number.regex' => 'Nomor Handphone harus diawali dengan 08.',
        ]);
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'is_admin' => false,
        ]);
        return redirect()->route('login')->with('success', 'Registrasi sukses! Silakan login.');
    }

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

            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('user.items');
        }
        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
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