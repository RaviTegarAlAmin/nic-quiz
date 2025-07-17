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
            'username' => 'required|string|min:8|max:18',
            'password' => 'required|string',
            'remember' => 'nullable|boolean'
        ]);

        $student = Student::where('nis', $credentials['username'])->first();
        $teacher = Teacher::where('nip', $credentials['username'])->first();

        if ($student && Hash::check($credentials['password'], $student->user->password)) {
            $user = $student->user()->first();
            Auth::login($user, $credentials['remember'] ?? false);

            $request->session()->regenerate();

            return redirect()->route('dashboard.student');

        } else if ($teacher && Hash::check($credentials['password'], $teacher->user->password)) {
            $user = $teacher->user()->first();
            Auth::login($user, $credentials['remember']??false);

            $request->session()->regenerate();

            return redirect()->route('dashboard.teacher');
        }



        return redirect()->back()
            ->with('error', 'username atau password anda salah');
    }

    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|string|min:8|max:18',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard.admin');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
