<a href="{{ route('doctor.dashboard') }}" class="bg-yellow-600 opacity-90 rounded-full m-2 px-4 py-2 font-bold text-gray-700 hover:text-gray-800 hover:bg-yellow-600 flex items-center {{ request()->is('doctor/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
</a>
<a href="{{ route('schedule.appointment') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('doctor/appointment') ? 'active' : '' }}">
    <i class="fas fa-calendar-days mr-2"></i> Appointments
</a>
<a href="{{ route('schedule.index') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('schedule') ? 'active' : '' }}">
    <i class="fas fa-calendar-day mr-2"></i> My Schedule
</a>
<a href="{{ route('analyze-medical-report') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('analyze-medical-report') ? 'active' : '' }}">
    <i class="fas fa-file-medical-alt mr-2"></i> Analyze Medical Report
</a>
<div class="px-4">
    <a href="{{ route('analyzed-reports') }}" class="bg-blue-800 opacity-90 rounded-full m-2 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('analyzed-reports') ? 'active' : '' }}">
        <i class="fas fa-arrow-right mr-2 ml-6"></i> Analyzed Reports
    </a>
</div>
<a href="{{ route('self-help') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('self-help') ? 'active' : '' }}">
    <i class="fas fa-book-medical mr-2"></i> Self Help
</a>
{{-- <a href="{{ route('notification') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('notification') ? 'active' : '' }}">
    <i class="fas fa-bell mr-2"></i> Notification
</a> --}}
<a href="{{ route('doctor.my-wallet') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('doctor/my-wallet') ? 'active' : '' }}">
    <i class="fas fa-wallet mr-2"></i> My Wallet
</a>
<a href="{{ route('settings.index') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('settings') ? 'active' : '' }}">
    <i class="fas fa-cog mr-2"></i> Settings
</a>