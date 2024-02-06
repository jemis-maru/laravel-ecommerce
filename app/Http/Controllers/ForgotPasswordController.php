<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    public function sendPasswordResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Admin::where('email', $request->email)->first();

        if (!$user) {
            throw ValidationException::withMessages(['email' => 'Email not found']);
        }

        $token = Str::uuid();

        PasswordReset::updateOrCreate(
            ['email' => $user->email],
            ['token' => $token]
        );

        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

        return redirect()->back()->with('success', 'Password reset link sent to your email');
    }

    public function showResetPasswordForm($token)
    {
        return view('admin.auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'token' => 'required',
                'password' => 'required|confirmed',
            ]);

            $user = Admin::where('email', $request->email)->first();

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

            return redirect()->route('admin.login')->with('success', 'Password updated successfully');
        } catch (ValidationException $e) {
            return redirect()->route('admin.password.reset', ['token' => $request->token])->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.password.reset', ['token' => $request->token])->with('error', 'An error occurred while resetting the password');
        }
    }
}
