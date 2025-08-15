<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MedicalReportController extends Controller
{
    public function index()
    {
        $reports = MedicalReport::where('user_id', Auth::id())->get();
        return view('medical-report.index', compact('reports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|string',
            'report_file' => 'required|file|mimes:pdf,jpg,png|max:2048', // Max 2MB
        ]);

        $filePath = $request->file('report_file')->store('medical_reports', 'public');
        MedicalReport::create([
            'user_id' => Auth::id(),
            'report_type' => $request->report_type,
            'file_path' => $filePath,
            'status' => 'pending',
        ]);

        return redirect()->route('medical-report')->with('success', 'Report submitted successfully.');
    }

    public function show($id)
    {
        $report = MedicalReport::findOrFail($id);
        if ($report->user_id !== Auth::id()) {
            abort(403);
        }
        return view('medical-report.show', compact('report'));
    }
}