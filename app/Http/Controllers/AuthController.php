<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function loginForm()
    {

        return view('auth.loginform');
    }

    public function adminLoginForm()
    {
        return view('auth.adminloginform');
    }


    public function login(Request $request)
    {

        $credentials = $request->validate([
            'username' => 'required|string|max:16',
            'password' => 'required|string|max:16',
            'remember' => 'nullable|boolean'
        ], [
            'username.required' => 'Masukkan Username',
            'username.max' => 'Username atau Password Salah',
            'password.required' => 'Masukkan Password',
            'password.max' => 'Username atau Password Salah'
        ]);


        $student = Student::where('nis', $credentials['username'])->first();
        $teacher = Teacher::where('nip', $credentials['username'])->first();

        if (!$student && !$teacher) {
            return back()->withErrors([
                'username' => 'Username atau password salah',
            ]);
        }

        if ($student && Hash::check($credentials['password'], $student->user->password)) {
            $user = $student->user()->first();


            Auth::login($user, $credentials['remember'] ?? false);

            $request->session()->regenerate();

            return redirect()->route('dashboard.student');

        } else if ($teacher && Hash::check($credentials['password'], $teacher->user->password)) {
            $user = $teacher->user()->first();
            Auth::login($user, $credentials['remember'] ?? false);

            $request->session()->regenerate();

            return redirect()->route('dashboard.teacher');
        }

        return back()->withErrors([
            'password' => 'Username atau password salah',
        ]);

    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:16',
            'password' => 'required|string|max:16',
            'remember' => 'nullable|boolean'
        ], [
            'username.required' => 'Masukkan Username',
            'username.max' => 'Username atau Password Salah',
            'password.required' => 'Masukkan Password',
            'password.max' => 'Username atau Password Salah'
        ]);

        $user = User::where('email', $credentials['username'])->first();


        if (!$user) {
            return back()->withErrors([
                'username' => 'Username atau password salah',
            ]);
        }

        if ($user->admin && Hash::check($credentials['password'], $user->password)) {

            Auth::login($user, $credentials['remember'] ?? false);

            request()->session()->regenerate();

            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'password' => 'Username atau password salah',
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
