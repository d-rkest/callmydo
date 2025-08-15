<?php

namespace App\Http\Controllers;

use App\Models\FirstAidGuide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FirstAidController extends Controller
{
    public function index()
    {
        try {
            $guides = FirstAidGuide::orderBy('name')->get();
            return view('give-first-aid', compact('guides'));
        } catch (\Exception $e) {
            Log::error('FirstAidController@index: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to load first aid page. Please try again later.');
        }
    }

    public function fetch(Request $request)
    {
        try {
            $searchTerm = $request->input('search');
            if (!$searchTerm || strlen($searchTerm) < 2) {
                return response()->json(['error' => 'Please enter a valid search term (min 2 characters).'], 400);
            }

            $guide = FirstAidGuide::where('name', 'like', "%{$searchTerm}%")->first();

            if (!$guide) {
                return response()->json(['error' => 'No first aid guide found for the search term.'], 404);
            }

            return response()->json([
                'name' => $guide->name,
                'category' => $guide->category,
                'steps' => $guide->steps,
                'video_url' => $guide->video_url,
            ]);
        } catch (\Exception $e) {
            Log::error('FirstAidController@fetch: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to fetch first aid details. Please try again.'], 500);
        }
    }
}