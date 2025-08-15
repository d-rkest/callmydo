<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('role', 'doctor')->with('doctorDetail')->get();
        return view('admin.doctors', compact('doctors'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'phone' => 'required|string|max:20',
                'specialization' => 'required|string|max:255',
                'license_number' => 'required|string|unique:doctor_details,license_number',
                'address' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                'profile_photo' => 'nullable|image|max:2048', // Max 2MB
                'password' => 'required|string|min:8', // Validate password
            ]);

            // Create user record
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'doctor', // Set role to doctor
                'status' => $request->status,
            ];
            $user = User::create($userData);

            // Create doctor details record
            $doctorData = [
                'user_id' => $user->id,
                'phone' => $request->phone,
                'specialization' => $request->specialization,
                'license_number' => $request->license_number,
                'address' => $request->address,
            ];
            if ($request->hasFile('profile_photo')) {
                $doctorData['profile_photo_path'] = $request->file('profile_photo')->store('doctors/photos', 'public');
            }
            $doctorDetail = DoctorDetail::create($doctorData);

            return redirect()->route('admin.doctors')->with('success', 'Doctor added successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors')->with('error', 'Failed to add doctor. Please try again or contact support.');
        }
    }

    public function edit($id)
    {
        try {
            $doctor = User::where('role', 'doctor')->with('doctorDetail')->findOrFail($id);
            return view('admin.edit-doctor', compact('doctor'));
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors')->with('error', 'Doctor not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->role !== 'doctor') {
                throw new \Exception('This is not a doctor account.');
            }

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|string|max:20',
                'specialization' => 'required|string|max:255',
                'license_number' => 'required|string|unique:doctor_details,license_number,' . ($user->doctorDetail ? $user->doctorDetail->id : 'NULL'),
                'address' => 'required|string|max:255',
                'status' => 'required|in:active,inactive',
                'profile_photo' => 'nullable|image|max:2048',
                'password' => 'nullable|string|min:8', // Optional password update
            ]);

            // Update user record
            $userData = $request->only(['name', 'email', 'status']);
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            // Update or create doctor details
            $doctorData = $request->only(['phone', 'specialization', 'license_number', 'address']);
            if ($request->hasFile('profile_photo')) {
                if ($user->doctorDetail && $user->doctorDetail->profile_photo_path) {
                    Storage::disk('public')->delete($user->doctorDetail->profile_photo_path);
                }
                $doctorData['profile_photo_path'] = $request->file('profile_photo')->store('doctors/photos', 'public');
            }
            $user->doctorDetail()->updateOrCreate(['user_id' => $user->id], $doctorData);

            return redirect()->route('admin.doctors')->with('success', 'Doctor updated successfully.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors')->with('error', 'Failed to update doctor. Please try again or contact support.');
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->role !== 'doctor') {
                throw new \Exception('This is not a doctor account.');
            }

            if ($user->doctorDetail && $user->doctorDetail->profile_photo_path) {
                Storage::disk('public')->delete($user->doctorDetail->profile_photo_path);
            }

            $user->doctorDetail()->delete();
            $user->delete();

            return redirect()->route('admin.doctors')->with('success', 'Doctor deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.doctors')->with('error', 'Failed to delete doctor. Please try again or contact support.');
        }
    }
}