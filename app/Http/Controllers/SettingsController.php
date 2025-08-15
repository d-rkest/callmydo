<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationCode;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('settings', compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $user->update(['password' => Hash::make($request->new_password)]);
        return back()->with('success', 'Password updated successfully.');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['email_verification_code' => 'required']);

        $user = Auth::user();
        // Assuming verification code is stored in session or a temporary table
        $storedCode = session('email_verification_code'); // Placeholder; implement storage logic
        if ($request->email_verification_code !== $storedCode) {
            return back()->withErrors(['email_verification_code' => 'Invalid verification code.']);
        }

        $user->update(['email_verified_at' => now()]);
        session()->forget('email_verification_code');
        return back()->with('success', 'Email verified successfully.');
    }

    public function resendVerification(Request $request)
    {
        $user = Auth::user();
        $code = Str::random(6); // Generate a 6-digit code
        session(['email_verification_code' => $code]);

        // Send email (implement Mail facade)
        Mail::to($user->email)->send(new EmailVerificationCode($code));
        return back()->with('success', 'Verification code has been resent.');
    }

    public function updatePhone(Request $request)
    {
        $request->validate(['phone' => 'required|regex:/^[+]?[0-9]{10,15}$/']);

        $user = Auth::user();
        $userDetail = $user->userDetail() ?? new UserDetail(['user_id' => $user->id]);
        $userDetail->phone = $request->phone;
        $userDetail->save();

        return back()->with('success', 'Phone number updated successfully.');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate(['confirm_delete' => 'required|in:DELETE']);

        $user = Auth::user();
        $user->userDetail()->delete();
        if ($user->role === 'doctor') {
            $user->doctorDetails()->delete();
        }
        $user->delete();

        Auth::logout();
        return redirect('/login')->with('success', 'Account deleted successfully.');
    }
}