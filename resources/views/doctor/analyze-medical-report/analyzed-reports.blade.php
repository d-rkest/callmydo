@extends('layouts.app')

@section('title', 'Analyzed Reports')
@section('navbar-title', 'Analyzed Reports')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('analyze-medical-report') }}" class="text-blue-600 hover:text-blue-800">Analyze Medical Report</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Analyzed Reports</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Analyzed Reports</h2>

    <div class="md:ml-64 lg:ml-0 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
        <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Analyzed Reports</h3>
        <div class="overflow-x-auto">
            @if ($reports->isEmpty())
                <p class="text-center text-gray-500 py-4">No records found.</p>
            @else
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b">Title</th>
                            <th class="p-2 border-b">User</th>
                            <th class="p-2 border-b">Date Analyzed</th>
                            <th class="p-2 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="border-b">
                                <td class="p-2">{{ $report->report_type }} - {{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="p-2">{{ $report->user->name }}</td>
                                <td class="p-2">{{ $report->updated_at->format('Y-m-d') }}</td>
                                <td class="p-2"><a href="#" class="text-blue-600 hover:text-blue-800 view-analyzed-report" data-report-id="{{ $report->id }}">View</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{-- {{ $reports->links() }} --}}
            @endif
        </div>
    </div>

    <!-- Analyzed Report Modal -->
    <div id="analyzed-report-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden" aria-hidden="true">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-2xl mx-auto mt-20">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Analyzed Report Details</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <p><strong>Title:</strong> <span id="modal-title"></span></p>
                <p><strong>User:</strong> <span id="modal-user"></span></p>
                <p><strong>Date Analyzed:</strong> <span id="modal-date"></span></p>
                <p><strong>Findings:</strong> <span id="modal-findings"></span></p>
                <p><strong>Diagnosis:</strong> <span id="modal-diagnosis"></span></p>
                <p><strong>Doctor:</strong> <span id="modal-doctor">{{ Auth::user()->name }}</span></p>
                <p><strong>Treatment Plan:</strong> <span id="modal-treatment-plan"></span></p>
                <p><strong>Notes:</strong> <span id="modal-notes"></span></p>
                <p><strong>Medications:</strong> <span id="modal-medications"></span></p>
            </div>
            <button id="close-modal" class="mt-4 bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Close</button>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Analyzed Report Modal
        document.querySelectorAll('.view-analyzed-report').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const reportId = this.getAttribute('data-report-id');
                const reportsData = @json($reports->keyBy('id')->toArray());
                const report = reportsData[reportId] || {};
                
                // Ensure all fields are handled safely
                document.getElementById('modal-title').textContent = report.report_type ? `${report.report_type} - ${report.created_at ? new Date(report.created_at).toLocaleDateString() : 'N/A'}` : 'N/A';
                document.getElementById('modal-user').textContent = report.user?.name || 'N/A';
                document.getElementById('modal-date').textContent = report.updated_at ? new Date(report.updated_at).toLocaleDateString() : 'N/A';
                document.getElementById('modal-findings').textContent = report.findings || 'N/A';
                document.getElementById('modal-diagnosis').textContent = report.diagnosis || 'N/A';
                // document.getElementById('modal-doctor').textContent = report.doctor?.name || 'N/A';
                document.getElementById('modal-treatment-plan').textContent = report.treatment_plan || 'N/A';
                document.getElementById('modal-notes').textContent = report.notes || 'N/A';
                document.getElementById('modal-medications').textContent = report.medications ? report.medications.map(m => `${m.name} (${m.pivot.dosage})`).join(', ') : 'N/A';

                document.getElementById('analyzed-report-modal').classList.remove('hidden');
            });
        });

        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('analyzed-report-modal').classList.add('hidden');
        });

        // Close modal on outside click
        document.getElementById('analyzed-report-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });
    });
</script>