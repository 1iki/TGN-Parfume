<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $loginInput = $request->input('username') ?? $request->input('email');
        $passwordInput = $request->input('pass') ?? $request->input('password');

        if (empty($loginInput) || empty($passwordInput)) {
            return back()->withErrors(['email' => 'Username/email dan password harus diisi!'])->withInput();
        }

        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Username/email atau password salah!'])->withInput();
        }

        if ($user->status === 'Disabled') {
            return back()->withErrors(['email' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'])->withInput();
        }

        // Dual-Hash Migration Check: SHA-1 legacy passwords vs Bcrypt
        $isBcrypt = str_starts_with($user->password ?? '', '$2y$') || str_starts_with($user->password ?? '', '$2a$') || str_starts_with($user->password ?? '', '$2b$');

        if (!$isBcrypt || ($user->password_algorithm ?? '') === 'sha1') {
            if (sha1($passwordInput) === $user->password) {
                $user->password = Hash::make($passwordInput);
                $user->password_algorithm = 'bcrypt';
                $user->save();

                Auth::login($user);
                $request->session()->regenerate();

                if (in_array(Auth::user()->level, ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive', '1'])) {
                    return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Panel Admin TGN Parfume!');
                }

                return redirect()->intended(route('home'))->with('success', 'Berhasil login!');
            }
            return back()->withErrors(['email' => 'Username/email atau password salah!'])->withInput();
        }

        // Standard Laravel Bcrypt Auth check
        if (Hash::check($passwordInput, $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            if (in_array(Auth::user()->level, ['Super Admin', 'Admin', 'Customer Service', 'Marketing', 'Executive', '1'])) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang di Panel Admin TGN Parfume!');
            }

            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali!');
        }

        return back()->withErrors(['email' => 'Username/email atau password salah!'])->withInput();
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'required|email|max:100|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'fullname' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'status' => 'Active',
            'password' => Hash::make($validated['password']),
            'password_algorithm' => 'bcrypt',
            'level' => 'consument',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Pendaftaran berhasil! Selamat berbelanja di TGN Parfume.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Anda telah keluar dari akun.');
    }

    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    public function handleForgotPassword(Request $request)
    {
        $validated = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $user = User::where('fullname', $validated['fullname'])
            ->where('email', $validated['email'])
            ->where('phone', $validated['phone'])
            ->first();

        if ($user) {
            session(['reset_user_id' => (string)$user->_id]);
            return redirect()->route('password.reset');
        }

        return back()->withErrors(['email' => 'Data tidak cocok dengan pendaftaran!'])->withInput();
    }

    public function showResetPassword()
    {
        return view('auth.reset-password');
    }

    public function handleResetPassword(Request $request)
    {
        $validated = $request->validate([
            'new_pass' => 'required|string|min:6',
            'cpass' => 'required|string|min:6|same:new_pass',
        ]);

        $userId = session('reset_user_id') ?? Auth::id();

        if (!$userId) {
            return redirect()->route('login')->withErrors(['email' => 'Sesi reset password kadaluarsa. Silakan ulang dari Lupa Password.']);
        }

        $user = User::find($userId);
        if ($user) {
            $user->password = Hash::make($validated['new_pass']);
            $user->password_algorithm = 'bcrypt';
            $user->save();

            session()->forget('reset_user_id');

            return redirect()->route('login')->with('success', 'Password berhasil diperbarui! Silakan login dengan password baru.');
        }

        return back()->withErrors(['email' => 'Pengguna tidak ditemukan!']);
    }
}
