<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validasi dengan unique check yang lebih ketat
            $request->validate([
                'name' => 'required|string|max:255',
                'nama' => 'required|string|max:255',
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],
                'password' => 'required|string|min:8|confirmed',
                'nip' => 'nullable|string|max:50',
                'pangkat' => 'nullable|string|max:100',
                'golongan' => 'nullable|string|max:50',
                'jabatan' => 'required|string|max:255',
            ]);

            // Cek duplikasi email secara eksplisit (untuk debugging Supabase)
            $existingUser = DB::table('users')->where('email', $request->email)->first();
            if ($existingUser) {
                return back()->withErrors([
                    'email' => 'Email sudah terdaftar. Silakan gunakan email lain atau login.',
                ])->withInput();
            }

            // Buat user baru
            $user = User::create([
                'name' => $request->name,
                'nama' => $request->nama,
                'email' => strtolower(trim($request->email)),
                'password' => Hash::make($request->password),
                'nip' => $request->nip,
                'pangkat' => $request->pangkat,
                'golongan' => $request->golongan,
                'jabatan' => $request->jabatan,
                'role' => 'pegawai',
            ]);

            Log::info('User registrasi berhasil: ' . $user->email);

            return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
        } catch (\Illuminate\Database\QueryException $e) {
            Log::error('Database error saat registrasi: ' . $e->getMessage());

            // Cek error code untuk unique violation
            if ($e->getCode() === '23505') { // PostgreSQL unique violation
                return back()->withErrors([
                    'email' => 'Email sudah terdaftar. Silakan gunakan email lain.',
                ])->withInput();
            }

            return back()->withErrors([
                'system' => 'Terjadi kesalahan database. Silakan coba lagi.',
            ])->withInput();
        } catch (\Exception $e) {
            Log::error('Error saat registrasi: ' . $e->getMessage());
            return back()->withErrors([
                'system' => 'Terjadi kesalahan. Silakan coba lagi.',
            ])->withInput();
        }
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

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
