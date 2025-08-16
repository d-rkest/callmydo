<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Mail;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required', // Explicitly validate the confirmation field
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('status', 'Password updated successfully!');
    }

    public function verifyEmail(Request $request)
    {
        $request->validate(['email_verification_code' => 'required|numeric|digits:6']);

        $user = Auth::user();
        $storedCode = session('verification_code'); // Example: Assume code is stored in session after sending

        if (!$storedCode || $request->email_verification_code != $storedCode) {
            return back()->withErrors(['email_verification_code' => 'Invalid verification code.']);
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return back()->with('status', 'Email verified successfully!');
    }

    public function resendVerification(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = Auth::user();
        if ($user->hasVerifiedEmail()) {
            return back()->with('status', 'Email already verified.');
        }

        $verificationCode = rand(100000, 999999);
        session(['verification_code' => $verificationCode]);

        // Replace with actual Mail facade usage
        // Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return back()->with('status', 'verification-link-sent');
    }

    public function updatePhone(Request $request)
    {
        $request->validate(['phone' => 'required|regex:/^[\+]?[0-9]{10,14}$/']);

        $user = Auth::user();

        if ($user->role === 'doctor') {
            $detail = $user->doctorDetail ?: new DoctorDetail(['user_id' => $user->id]);
            $detail->phone = $request->phone;
            $detail->save();
        } else {
            $detail = $user->userDetail ?: new UserDetail(['user_id' => $user->id]);
            $detail->phone = $request->phone;
            $detail->save();
        }

        return back()->with('status', 'Phone number updated successfully!');
    }

    public function deleteAccount(Request $request)
    {
        $request->validate(['confirm_delete' => 'required|in:DELETE']);

        $user = Auth::user();
        $user->delete();

        Auth::logout();
        return redirect('/')->with('status', 'Account deleted successfully.');
    }
}