<?php

namespace App\Http\Controllers;

use App\Models\MedicalReport;
use App\Models\Medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalyzeMedicalReportController extends Controller
{
    public function index()
    {
        $reports = MedicalReport::where('status', 'pending')->get();
        return view('doctor.analyze-medical-report.index', compact('reports'));
    }

    public function show($id)
    {
        $report = MedicalReport::findOrFail($id);
        if ($report->status !== 'pending') {
            abort(403);
        }
        $user = $report->user;
        $medications = Medication::all();
        return view('doctor.analyze-medical-report.show', compact('report', 'user', 'medications'));
    }

    public function storeFeedback(Request $request, $id)
    {
        $report = MedicalReport::findOrFail($id);
        if ($report->status !== 'pending') {
            abort(403);
        }

        $request->validate([
            'findings' => 'nullable|string',
            'diagnosis' => 'nullable|string',
            'cause' => 'nullable|string',
            'remedy' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
            'notes' => 'nullable|string',
            'medications' => 'nullable|array',
            'medications.*.drug' => 'required_with:medications|string|exists:medications,name',
            'medications.*.dosage' => 'required_with:medications|string',
        ]);

        $report->update([
            'doctor_id' => Auth::id(),
            'status' => 'analyzed',
            'findings' => $request->findings,
            'diagnosis' => $request->diagnosis,
            'cause' => $request->cause,
            'remedy' => $request->remedy,
            'treatment_plan' => $request->treatment_plan,
            'notes' => $request->notes,
        ]);

        if ($request->has('medications')) {
            $medicationData = [];
            foreach ($request->medications as $med) {
                $medication = Medication::where('name', $med['drug'])->first();
                if ($medication) {
                    $medicationData[] = [
                        'medical_report_id' => $report->id,
                        'medication_id' => $medication->id,
                        'dosage' => $med['dosage'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            }
            DB::table('report_medications')->insert($medicationData);
        }

        return redirect()->route('analyze-medical-report')->with('success', 'Feedback submitted successfully.');
    }

    public function analyzedReports()
    {
        $reports = MedicalReport::where('doctor_id', Auth::id())->where('status', 'analyzed')->get();
        return view('doctor.analyze-medical-report.analyzed-reports', compact('reports'));
    }
}