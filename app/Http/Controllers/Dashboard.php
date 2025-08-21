<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;
use App\Models\MedicalReport;

class Dashboard extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        switch ($user->role) {
            case 'admin':
                return redirect()->intended(route('admin.dashboard', absolute: false));
            case 'doctor':
                return redirect()->intended(route('doctor.dashboard', absolute: false));
            case 'user':
            default:
                return redirect()->intended(route('dashboard', absolute: false));
        }
    }

    public function doctorDashboard()
    {
        if (Auth::user()->role !== 'doctor') {
            abort(403, 'Unauthorized access to doctor dashboard.');
        }

        $doctorId = Auth::id();
        $newAppointments = Appointment::where('doctor_id', null)
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('status', 'pending')
            ->count();

        $scheduleCount = Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', '>=', now()->toDateString())
            ->whereIn('status', ['scheduled', 'completed'])
            ->count();

        $medicalReports = MedicalReport::where('doctor_id', $doctorId)
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $appointments = Appointment::where('doctor_id', null)
            ->where('appointment_date', '>=', now()->toDateString())
            ->where('status', 'pending')
            ->with('user')
            ->get();

        $reports = MedicalReport::where('doctor_id', $doctorId)
            ->where('created_at', '>=', now()->subDays(30))
            ->with('user')
            ->get();

        return view('doctor.dashboard', compact('newAppointments', 'scheduleCount', 'medicalReports', 'appointments', 'reports'));
    }
    
    public function userDashboard()
    {
        $userId = Auth::id();
        $appointments = Appointment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->where('appointment_date', '>=', now()->toDateString())
            // ->where('status', 'expired')
            ->with('user')
            ->get();

        return view('dashboard', compact('appointments'));
    }
    
    public function adminDashboard()
    {
        $userId = Auth::id();

        return view('admin.dashboard');
    }
}