<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Validation\ValidationException;

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

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . Auth::guard('admin')->id(),
        ]);

        $admin = Auth::guard('admin')->user();

        $admin->name = $request->input('name');
        $admin->email = $request->input('email');

        $admin->save();

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);

            $admin = Auth::guard('admin')->user();

            if (!Hash::check($request->input('current_password'), $admin->password)) {
                return redirect()->route('admin.profile')->with('error', 'Incorrect current password');
            }

            $admin->update([
                'password' => Hash::make($request->input('new_password')),
            ]);

            return redirect()->route('admin.profile')->with('success', 'Password changed successfully');
        } catch (ValidationException $e) {
            return redirect()->route('admin.profile')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            return redirect()->route('admin.profile')->with('error', 'An error occurred while changing the password');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('login');
    }
}
