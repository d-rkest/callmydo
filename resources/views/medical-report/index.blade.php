@extends('layouts.app')

@section('title', 'Medical Report')
@section('navbar-title', 'Medical Report')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Medical Report</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Medical Report</h2>

    <div class="md:ml-64 lg:ml-0 grid grid-cols-1 sm:grid-cols-3 gap-6">
        <!-- Report Input Card (1 col) -->
        <div class="sm:col-span-1 bg-gradient-to-br from-blue-100 to-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-blue-800 mb-2 border-b-2 border-blue-300 pb-1">Submit Medical Report</h3>
            <form action="{{ route('medical-report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                    <select id="report_type" name="report_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="Blood Test">Blood Test</option>
                        <option value="X-Ray">X-Ray</option>
                        <option value="MRI">MRI</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div>
                    <label for="report_file" class="block text-sm font-medium text-gray-700">Upload Report</label>
                    <input type="file" id="report_file" name="report_file" accept=".pdf,.jpg,.png" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">Submit</button>
            </form>
        </div>

        <!-- Reports Table (2 cols) -->
        <div class="sm:col-span-2 bg-gradient-to-br from-green-100 to-white p-6 rounded-lg shadow-lg">
            <h3 class="text-lg font-bold text-green-800 mb-2 border-b-2 border-green-300 pb-1">Submitted Reports</h3>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-green-200">
                            <th class="p-2 border-b">Title</th>
                            <th class="p-2 border-b">Doctor</th>
                            <th class="p-2 border-b">Status</th>
                            <th class="p-2 border-b">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="border-b">
                                <td class="p-2">{{ $report->report_type }} - {{ $report->created_at->format('Y-m-d') }}</td>
                                <td class="p-2">{{ $report->doctor ? $report->doctor->name : '-' }}</td>
                                <td class="p-2">{{ $report->status }}</td>
                                <td class="p-2">
                                    @if ($report->status === 'analyzed')
                                        <a href="{{ route('medical-report.show', $report->id) }}" class="text-blue-600 text-sm hover:text-blue-800">View Feedback</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection