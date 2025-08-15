<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\MedicalInformation;
use App\Models\DoctorAvailability;
use App\Models\DoctorDetail; // Assuming this model exists
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? UserDetail::make();
        $medicalInfo = $user->medicalInformation ?? MedicalInformation::make();

        return view('profile.show', compact('user', 'userDetail', 'medicalInfo'));
    }

    public function showDoctor()
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? UserDetail::make();
        $doctorDetail = $user->doctorDetail ?? null;
        $availability = DoctorAvailability::where('user_id', $user->id)->get()->keyBy('day');

        return view('doctor.profile.show', compact('user', 'userDetail', 'doctorDetail', 'availability'));
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|max:2048', // Max 2MB
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::disk('public')->delete($user->profile_photo_path);
            }
            $user->profile_photo_path = $request->file('profile_photo')->store('users/photos', 'public');
            $user->save();
        }

        if ($user->role === 'doctor') {
            return redirect()->route('doctor.profile')->with('success', 'Profile photo updated successfully.');
        }
        return redirect()->route('profile')->with('success', 'Profile photo updated successfully.');
    }

    public function editPersonal()
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? UserDetail::make();
        return view('profile.edit-personal', compact('user', 'userDetail'));
    }

    public function updatePersonal(Request $request)
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? new UserDetail(['user_id' => $user->id]);

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'next_of_kin_name' => 'nullable|string|max:255',
            'next_of_kin_email' => 'nullable|email|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'next_of_kin_relationship' => 'nullable|string|max:255',
        ]);

        $userDetail->fill($request->all());
        $userDetail->save();

        if ($user->role === 'doctor') {
            return redirect()->route('doctor.profile')->with('success', 'Personal details updated successfully.');
        }
        return redirect()->route('profile')->with('success', 'Personal details updated successfully.');
    }

    public function editKin()
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? UserDetail::make();
        return view('profile.edit-kin', compact('user', 'userDetail'));
    }

    public function updateKin(Request $request)
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? new UserDetail(['user_id' => $user->id]);

        $request->validate([
            'next_of_kin_name' => 'nullable|string|max:255',
            'next_of_kin_email' => 'nullable|email|max:255',
            'next_of_kin_phone' => 'nullable|string|max:20',
            'next_of_kin_relationship' => 'nullable|string|max:255',
        ]);

        $userDetail->fill($request->all());
        $userDetail->save();

        if ($user->role === 'doctor') {
            return redirect()->route('doctor.profile')->with('success', 'Next of kin details updated successfully.');
        }
        return redirect()->route('profile')->with('success', 'Next of kin details updated successfully.');
    }

    public function editMedical()
    {
        $user = Auth::user();
        $medicalInfo = $user->medicalInformation ?? MedicalInformation::make();
        return view('profile.edit-medical', compact('user', 'medicalInfo'));
    }

    public function updateMedical(Request $request)
    {
        $user = Auth::user();
        $medicalInfo = $user->medicalInformation ?? new MedicalInformation(['user_id' => $user->id]);

        $request->validate([
            'height' => 'nullable|string|max:10',
            'blood_group' => 'nullable|string|max:5',
            'genotype' => 'nullable|string|max:5',
            'known_allergies' => 'nullable|string|max:255',
            'health_issues' => 'nullable|string|max:255',
        ]);

        $medicalInfo->fill($request->all());
        $medicalInfo->save();

        if ($user->role === 'doctor') {
            return redirect()->route('doctor.profile')->with('success', 'Medical information updated successfully.');
        }
        return redirect()->route('profile')->with('success', 'Medical information updated successfully.');
    }

    public function editDoctorPersonal()
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? UserDetail::make();
        $doctorDetail = $user->doctorDetail ?? DoctorDetail::make(); // Initialize if null
        return view('doctor.profile.edit-personal', compact('user', 'userDetail', 'doctorDetail'));
    }

    public function updateDoctorPersonal(Request $request)
    {
        $user = Auth::user();
        $userDetail = $user->userDetail ?? new UserDetail(['user_id' => $user->id]);
        $doctorDetail = $user->doctorDetail ?? new DoctorDetail(['user_id' => $user->id]);

        $request->validate([
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:Male,Female,Other',
            'date_of_birth' => 'nullable|date',
            'address' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:50',
            'specialization' => 'nullable|string|max:100',
        ]);

        $userDetail->fill($request->only(['phone', 'gender', 'date_of_birth', 'address']));
        $userDetail->save();

        $doctorDetail->fill($request->only(['license_number', 'specialization']));
        $doctorDetail->save();

        return redirect()->route('doctor.profile')->with('success', 'Personal details updated successfully.');
    }

    public function updateAvailability(Request $request)
    {
        $user = Auth::user();
        $request->validate([
            'day' => 'required|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        $availability = DoctorAvailability::updateOrCreate(
            ['user_id' => $user->id, 'day' => $request->day],
            ['start_time' => $request->start_time, 'end_time' => $request->end_time]
        );

        return redirect()->route('doctor.profile')->with('success', 'Availability updated successfully.');
    }

}