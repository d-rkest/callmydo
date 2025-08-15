<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Appointment;
use App\Models\MedicalReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicalHistoryController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        
        // Fetch call history (using 'calls' table)
        $callHistory = Call::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($call) {
                return [
                    'date' => $call->created_at->toDateString(),
                    'time' => $call->created_at->toTimeString() . ' WAT',
                    'doctor' => $call->doctor ? $call->doctor->name : 'N/A',
                    'status' => $call->status,
                    'notes' => 'N/A', // Add logic if notes are stored elsewhere
                ];
            });

        // Fetch appointment history (using 'appointments' table)
        $appointmentHistory = Appointment::where('user_id', $userId)
            ->orderBy('appointment_date', 'desc')
            ->orderBy('appointment_time', 'desc')
            ->get()
            ->map(function ($appointment) {
                return [
                    'date' => $appointment->appointment_date,
                    'time' => $appointment->appointment_time . ' WAT',
                    'doctor' => $appointment->doctor ? $appointment->doctor->name : 'N/A',
                    'status' => $appointment->status,
                    'reason' => $appointment->reason ?? 'N/A',
                ];
            });

        // Fetch medical reports (using 'medical_reports' table)
        $medicalReports = MedicalReport::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($report) {
                return [
                    'type' => $report->report_type,
                    'date' => $report->created_at->toDateString(),
                    'doctor' => $report->doctor->name ?? 'N/A',
                ];
            });

        return view('medical-history', compact('callHistory', 'appointmentHistory', 'medicalReports'));
    }
}