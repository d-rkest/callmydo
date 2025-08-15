@extends('layouts.app')

@section('title', 'Call History')
@section('navbar-title', 'Call History')

@section('sidebar-menu')
    @component('components.user-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('schedule.index') }}" class="text-blue-600 hover:text-blue-800">Schedule</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">History</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Schedule History</h2>

    <div class="md:ml-64 lg:ml-0 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-green-200">
                    <th class="p-2 border-b">Date</th>
                    <th class="p-2 border-b">Time</th>
                    <th class="p-2 border-b">Doctor</th>
                    <th class="p-2 border-b">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $call)
                    <tr class="border-b">
                        <td class="p-2">{{ $call->created_at->toDateString() }}</td>
                        <td class="p-2">{{ $call->created_at->toTimeString() }}</td>
                        <td class="p-2">{{ $call->status === 'calling' ? '-' : ($call->doctor->name ?? '-') }}</td>
                        <td class="p-2">
                            @switch($call->status)
                                @case('calling')
                                    <span class="bg-red-100 p-1 px-3 rounded text-red-800">failed</span>
                                    @break
                                @case('accepted')
                                    <span class="bg-green-100 p-1 px-3 rounded text-green-800">accepted</span>
                                    @break
                                @default
                                    <span class="bg-yellow-100 p-1 px-3 rounded text-yellow-800">pending</span>
                            @endswitch                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection