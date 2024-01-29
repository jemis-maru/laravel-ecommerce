<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::guard('admin')->check()) {
            return redirect()->route('admin.dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        $admin = Admin::where('email', $credentials['email'])->first();
    
        if ($admin && Auth::guard('admin')->attempt(['email' => $admin->email, 'password' => $credentials['password']])) {
            return redirect()->intended('/dashboard');
        }
    
        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function dashboard()
    {
        return view('dashboard');
    }
    
    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login');
    }
}
