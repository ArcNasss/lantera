<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard();
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nomor_identitas' => 'required|integer',
            'password' => 'required|string',
        ]);

        $user = User::where('nomor_identitas', $request->nomor_identitas)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $request->filled('remember'));
            return $this->redirectToDashboard();
        }

        return back()->withErrors([
            'nomor_identitas' => 'Nomor Identitas atau password salah.',
        ])->withInput($request->only('nomor_identitas'));
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nomor_identitas' => 'required|string|unique:users,nomor_identitas',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'nomor_identitas' => $request->nomor_identitas,
            'password' => Hash::make($request->password),
            'role' => 'peminjam',
        ]);

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    private function redirectToDashboard()
    {
        $role = Auth::user()->role;
        switch ($role) {
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'petugas':
                return redirect()->route('petugas.dashboard');
            case 'peminjam':
                return redirect()->route('peminjam.list-buku');
            default:
                Auth::logout();
                return redirect()->route('login');
        }
    }

}
