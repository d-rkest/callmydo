<a href="{{ route('dashboard') }}" class="bg-yellow-600 opacity-90 rounded-full m-2 px-4 py-2 font-bold text-gray-700 hover:text-gray-800 hover:bg-yellow-600 flex items-center {{ request()->is('/') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
</a>
<a href="{{ route('appointment.index') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('appointment') ? 'active' : '' }}">
    <i class="fas fa-calendar-check mr-2"></i> Book Appointment
</a>
<a href="{{ route('medical-report') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('medical-report') ? 'active' : '' }}">
    <i class="fas fa-file-medical mr-2"></i> Medical Report
</a>
<a href="{{ route('buy-prescription', 1) }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('buy-prescription') ? 'active' : '' }}">
    <i class="fas fa-prescription-bottle mr-2"></i> Buy Prescription
</a>
<div class="px-4">
    <a href="{{ route('my-order', 1) }}" class="bg-blue-800 opacity-90 rounded-full m-2 py-2 pl-6 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('my-order') ? 'active' : '' }}">
        My Order <i class="fas fa-shopping-cart mr-2 ml-6"></i>
    </a>
</div>
<a href="{{ route('call-ambulance') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('call-ambulance') ? 'active' : '' }}">
    <i class="fas fa-ambulance mr-2"></i> Call Ambulance
</a>
<a href="{{ route('locate-medical-center') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('locate-medical-center') ? 'active' : '' }}">
    <i class="fas fa-map-marker-alt mr-2"></i> Locate Medical Center
</a>
<a href="{{ route('medical-history') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('medical-history') ? 'active' : '' }}">
    <i class="fas fa-history mr-2"></i> Medical History
</a>
<a href="{{ route('settings.index') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('settings') ? 'active' : '' }}">
    <i class="fas fa-cog mr-2"></i> Settings
</a>
{{-- <a href="{{ route('profile') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('profile') ? 'active' : '' }}">
    <i class="fas fa-user mr-2"></i> Profile
</a> --}}