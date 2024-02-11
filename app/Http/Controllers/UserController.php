<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetUserPassword;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');
        $users = User::where('name', 'LIKE', "%$query%")
                    ->paginate(10);
                    
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

    public function loginPage()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('listing');
        }

        return view('frontend.auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $credentials['email'])->first();

        if($user->is_active === 0) {
            return redirect()->route('login')->with('error', 'Your Account is deactivated!');
        }
        else {
            if ($user && Auth::guard('user')->attempt(['email' => $user->email, 'password' => $credentials['password']])) {
                return redirect()->route('listing');
            }
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }
    
    public function showForgotPasswordForm()
    {
        return view('frontend.auth.forgot-password');
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'Email not found']);
        }

        $token = Str::uuid();

        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => $token]
        );

        Mail::to($user->email)->send(new ResetUserPassword($user, $token));

        return redirect()->back()->with('success', 'Password reset link sent to your email');
    }

    public function showResetPasswordForm($token)
    {
        return view('frontend.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|confirmed',
            ]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                throw ValidationException::withMessages(['email' => 'User not found']);
            }

            $passwordReset = PasswordReset::where('email', $request->email)
                ->where('token', $request->token)
                ->first();

            if (!$passwordReset) {
                throw ValidationException::withMessages(['token' => 'Invalid reset link']);
            }

            $user->update([
                'password' => bcrypt($request->password),
            ]);

            $passwordReset->delete();

            return redirect()->route('login')->with('success', 'Password updated successfully');
        } catch (ValidationException $e) {
            return redirect()->route('password.reset', ['token' => $request->token])->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('password.reset', ['token' => $request->token])->with('error', 'An error occurred while resetting the password');
        }
    }

    public function profile()
    {
        $user = Auth::guard('user')->user();
        return view('frontend.pages.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::guard('user')->id(),
            'phone_no' => 'required|string|unique:users'
        ]);

        $user = Auth::guard('user')->user();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone_no = $request->input('phone_no');

        $user->save();

        return redirect()->route('profile')->with('success', 'Profile updated successfully');
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate([
                'current_password' => 'required',
                'new_password' => 'required|confirmed',
            ]);

            $user = Auth::guard('user')->user();

            if (!Hash::check($request->input('current_password'), $user->password)) {
                return redirect()->route('profile')->with('error', 'Incorrect current password');
            }

            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);

            return redirect()->route('profile')->with('success', 'Password changed successfully');
        } catch (ValidationException $e) {
            return redirect()->route('profile')->with('error', 'Validation failed');
        } catch (\Exception $e) {
            return redirect()->route('profile')->with('error', 'An error occurred while changing the password');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->stateless()->user();

        $user = User::where('email', $googleUser->email)->first();

        if($user && $user->is_active === 0) {
            return redirect()->route('login')->with('error', 'Your Account is deactivated!');
        }
        else {
            if ($user && Auth::guard('user')->login($user)) {
                return redirect()->route('listing');
            }
        }

        return redirect()->route('login')->with('error', 'Invalid credentials');
    }

    public function logout()
    {
        Auth::guard('user')->logout();

        return redirect()->route('login');
    }
}
