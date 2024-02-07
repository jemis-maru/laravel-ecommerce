<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function toggleUser(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User ' . ($user->is_active ? 'activated' : 'deactivated') . ' successfully');
    }
    
    public function showSignupForm()
    {
        return view('frontend.auth.signup');
    }
    
    public function signup(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'phone_no' => 'required|string|unique:users',
                'password' => 'required|string|confirmed',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone_no,
                'password' => Hash::make($request->password),
                'is_active' => 1
            ]);

            return redirect()->route('login')->with('success', 'Account created successfully! You can now login.');
        } catch (ValidationException $e) {
            return redirect()->route('signup')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            return redirect()->route('signup')->with('error', 'An error occurred while registration');
        }
    }
}
