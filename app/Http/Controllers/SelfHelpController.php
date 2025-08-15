<?php

namespace App\Http\Controllers;

use App\Models\Illness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SelfHelpController extends Controller
{
    public function index()
    {
        try {
            $illnesses = Illness::orderBy('name')->get();
            return view('doctor.self-help', compact('illnesses'));
        } catch (\Exception $e) {
            Log::error('SelfHelpController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load self-help page.');
        }
    }

    public function fetch(Request $request)
    {
        try {
            $illness = Illness::find($request->illness_id);

            if (!$illness) {
                return response()->json(['error' => 'Illness not found.'], 404);
            }

            return response()->json([
                'name' => $illness->name,
                'category' => $illness->category,
                'symptoms' => $illness->symptoms,
                'local_remedy' => $illness->local_remedy,
                'otc_medications' => $illness->otc_medications,
            ]);
        } catch (\Exception $e) {
            Log::error('SelfHelpController@fetch: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch illness details.'], 500);
        }
    }
}