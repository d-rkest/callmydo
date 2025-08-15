<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class ScheduleController extends Controller
{
    public function index()
    {
        $doctorId = Auth::id();
        $appointments = Appointment::where('doctor_id', $doctorId)->with('user')->get();
        $upcoming = $this->getUpcomingAppointment($doctorId);

        return view('doctor.schedule.index', compact('appointments', 'upcoming'));
    }

    public function appointments()
    {
        $doctorId = Auth::id();
        $appointments = Appointment::where('doctor_id', $doctorId)->with('user')->get();
        $upcoming = $this->getUpcomingAppointment($doctorId);

        return view('doctor.schedule.appointment', compact('appointments', 'upcoming'));
    }

    public function show($id)
    {
        $appointment = Appointment::with('user')->findOrFail($id);
        return view('doctor.schedule.show', compact('appointment'));
    }

    public function accept(Request $request, $id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== null) {
            return redirect()->back()->withErrors(['message' => 'Appointment already assigned.']);
        }

        $apiKey = env('DAILY_API_KEY');
        $roomName = 'appointment-' . $appointment->id . '-' . Carbon::now()->timestamp;
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.daily.co/v1/rooms', [
            'name' => $roomName,
            'properties' => [
                'enable_screenshare' => true,
                'enable_chat' => true,
                'start_video_off' => false,
                'start_audio_off' => false,
                'enable_knocking' => false,
            ]
        ])->json();

        if (isset($response['url'])) {
            $roomUrl = $response['url'];
            $appointment->update([
                'doctor_id' => Auth::id(),
                'status' => 'scheduled',
                'room_url' => $roomUrl
            ]);
            return redirect()->back()->with('success', 'Appointment accepted successfully!');
        } else {
            Log::error('Failed to create Daily.co room during appointment acceptance', ['response' => $response, 'appointment_id' => $appointment->id]);
            return redirect()->back()->withErrors(['message' => 'Appointment accepted, but video call setup failed. Please contact support.']);
        }
    }

    public function feedback($id)
    {
        $appointment = Appointment::findOrFail($id);
        if ($appointment->doctor_id !== Auth::id()) {
            abort(403);
        }
        return view('appointment.feedback', compact('appointment'));
    }

    public function storeFeedback(Request $request, $id)
    {
        $request->validate([
            'findings' => 'nullable|string|max:1000',
            'diagnosis' => 'nullable|string|max:1000',
            'recommendations' => 'nullable|string|max:1000',
        ]);

        $appointment = Appointment::findOrFail($id);
        $appointment->update([
            'findings' => $request->findings,
            'diagnosis' => $request->diagnosis,
            'recommendations' => $request->recommendations,
        ]);
        return redirect()->route('schedule.index')->with('success', 'Feedback submitted successfully!');
    }

    public function history()
    {
        $doctorId = Auth::id();
        $history = Appointment::where('doctor_id', $doctorId)
            ->where('status', 'scheduled')
            ->orWhere('status', 'expired')
            ->with('user')
            ->get();

        return view('doctor.schedule.history', compact('history'));
    }

    protected function getUpcomingAppointment($doctorId)
    {
        $now = Carbon::now('Africa/Lagos');
        $tenMinutesFromNow = $now->copy()->addMinutes(10);
        return Appointment::where('doctor_id', $doctorId)
            ->where('appointment_date', $now->toDateString())
            ->whereBetween('appointment_time', [$now->toTimeString(), $tenMinutesFromNow->toTimeString()])
            ->where('status', 'scheduled')
            ->with('user')
            ->first();
    }
}