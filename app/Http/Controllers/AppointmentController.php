<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\DoctorReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        $appointments = Appointment::where('user_id', $userId)->with('doctor')->get();
        $upcoming = $this->getUpcomingAppointment($userId);

        return view('appointment.index', compact('appointments', 'upcoming'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'appointment_date' => 'required|date|after_or_equal:' . now()->toDateString(),
                'appointment_time' => 'required',
                'comment' => 'nullable|string|max:500',
            ]);

            $startTime = Carbon::createFromFormat('Y-m-d H:i', $request->appointment_date . ' ' . $request->appointment_time, 'Africa/Lagos');
            $endTime = $startTime->copy()->addMinutes(10);

            $conflicting = Appointment::where(function ($query) use ($startTime, $endTime) {
                $query->where('appointment_date', $startTime->toDateString())
                      ->whereBetween('appointment_time', [$startTime->toTimeString(), $endTime->toTimeString()]);
            })->where('user_id', Auth::id())->exists();

            if ($conflicting) {
                return response()->json(['success' => false, 'message' => 'An appointment already exists at this time.'], 422);
            }

            $appointment = Appointment::create([
                'user_id' => Auth::id(),
                'appointment_date' => $startTime->toDateString(),
                'appointment_time' => $startTime->toTimeString(),
                'reason' => $request->comment,
                'status' => 'pending',
            ]);

            return response()->json(['success' => true, 'message' => 'Appointment booked successfully! You will receive a confirmation soon.']);
        } catch (\Exception $e) {
            Log::error('Appointment booking failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred. Please try again.'], 500);
        }
    }

    public function storeRoomUrl(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id',
            'room_url' => 'required|url',
        ]);

        $appointment = Appointment::findOrFail($request->appointment_id);
        if ($appointment->user_id !== Auth::id() && !$appointment->doctor_id) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $appointment->update(['room_url' => $request->room_url]);
        return response()->json(['success' => true]);
    }
    
    public function show($id)
    {
        $appointment = Appointment::with('doctor')->findOrFail($id);
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
        return view('appointment.show', compact('appointment'));
    }

    public function videoCall($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->user_id !== Auth::id() && !$appointment->doctor_id) {
            abort(403);
        }

        $roomUrl = $appointment->room_url;
        if (!$roomUrl) {
            Log::warning('No room URL found for appointment', ['appointment_id' => $id]);
            abort(500, 'Video call not set up. Please contact support.');
        }

        return view('appointment.video-call', compact('appointment', 'roomUrl'));
    }

    public function review($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->user_id !== Auth::id()) {
            abort(403);
        }
        return view('appointment.review', compact('appointment'));
    }

    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::findOrFail($id);
        DoctorReview::create([
            'appointment_id' => $appointment->id,
            'doctor_id' => $appointment->doctor_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('appointment.index')->with('success', 'Review submitted successfully!');
    }

    protected function getUpcomingAppointment($userId)
    {
        $now = Carbon::now('Africa/Lagos');
        $tenMinutesFromNow = $now->copy()->addMinutes(10);
        return Appointment::where('user_id', $userId)
            ->where('appointment_date', $now->toDateString())
            ->whereBetween('appointment_time', [$now->toTimeString(), $tenMinutesFromNow->toTimeString()])
            ->where('status', 'scheduled')
            ->with('doctor')
            ->first();
    }
}