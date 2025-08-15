<?php

namespace App\Http\Controllers;

use App\Events\DoctorCallEvent;
use App\Events\CallCanceledEvent;
use App\Models\Call;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Event;

class CallController extends Controller
{
    public function initiateCall(Request $request)
    {
        $call = Call::create([
            'user_id' => Auth::id(),
            'status' => 'calling',
        ]);

        // Broadcast the call to online doctors
        Broadcast::event(new DoctorCallEvent($call->id, Auth::id()));

        return response()->json(['success' => true, 'message' => 'Call initiated. Please wait for a doctor to accept.', 'call_id' => $call->id]);
    }

    public function cancelCall(Request $request)
    {
        $callId = $request->input('call_id');
        $call = Call::where('user_id', Auth::id())->where('status', 'calling')->find($callId);

        if ($call) {
            $call->update(['status' => 'canceled']);
            Broadcast::event(new \App\Events\CallCanceledEvent($callId));
            return response()->json(['success' => true, 'message' => 'Call canceled.']);
        }

        return response()->json(['success' => false, 'message' => 'No active call to cancel.'], 404);
    }

    public function acceptCall(Request $request, $callId)
    {
        $call = Call::findOrFail($callId);
        if ($call->status !== 'calling' || $call->doctor_id) {
            return response()->json(['success' => false, 'message' => 'Call is not available or already accepted.']);
        }

        $apiKey = env('DAILY_API_KEY');
        $roomName = 'call-' . $callId . '-' . now()->timestamp;
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
            $call->update([
                'doctor_id' => Auth::id(),
                'status' => 'scheduled',
                'room_url' => $roomUrl
            ]);

            // Notify user to join the call
            Broadcast::event(new \App\Events\CallAcceptedEvent($callId, $roomUrl, Auth::id()));

            return response()->json(['success' => true, 'room_url' => $roomUrl]);
        } else {
            Log::error('Failed to create Daily.co room during call acceptance', ['response' => $response, 'call_id' => $callId]);
            return response()->json(['success' => false, 'message' => 'Failed to set up video call.']);
        }
    }

    public function videoCall($callId)
    {
        $call = Call::findOrFail($callId);
        if ($call->user_id !== Auth::id() && $call->doctor_id !== Auth::id()) {
            abort(403);
        }

        $roomUrl = $call->room_url;
        if (!$roomUrl) {
            Log::warning('No room URL found for call', ['call_id' => $callId]);
            abort(500, 'Video call not set up. Please contact support.');
        }

        return view('call.video-call', compact('call', 'roomUrl'));
    }
    
}