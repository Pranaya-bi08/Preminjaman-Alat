<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Tampilkan form login
    public function showLogin()
    {
        // Kalau sudah login, langsung arahkan ke dashboard sesuai role
        if (Auth::check()) {
            return $this->redirectByRole();
        }

        return view('login');
    }

    // Proses login (route: login.proses)
    public function actionLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required', 'string'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            LogAktivitas::create([
                'id_user' => $user->id,
                'nama' => $user->name,
                'role' => $user->role,
                'aktivitas' => 'Login ke sistem',
                'keterangan' => 'Login berhasil',
                'tanggal' => now(),
            ]);

            return $this->redirectByRole()->with('auth_success', 'Login berhasil.');
        }

        return back()
            ->withErrors(['email' => 'Email atau password salah.'])
            ->onlyInput('email');
    }

    // Logout (route: logout, method POST)
    public function actionLogout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            LogAktivitas::create([
                'id_user' => $user->id,
                'nama' => $user->name,
                'role' => $user->role,
                'aktivitas' => 'Logout dari sistem',
                'keterangan' => 'Logout berhasil',
                'tanggal' => now(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('auth_success', 'Logout berhasil.');
    }

    // Arahkan user ke dashboard sesuai role
    private function redirectByRole()
    {

     /** @var \App\Models\User $user*/

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isPetugas()) {
            return redirect()->route('petugas.dashboard');
        } elseif ($user->isPeminjam()) {
            return redirect()->route('peminjam.dashboard');
        }

        // Role tidak dikenali
        Auth::logout();

        return redirect()->route('login')
            ->withErrors(['email' => 'Role akun tidak valid.']);
    }
}
