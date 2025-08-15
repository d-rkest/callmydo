<a href="{{ route('admin.dashboard') }}" class="bg-yellow-600 opacity-90 rounded-full m-2 px-4 py-2 font-bold text-gray-700 hover:text-gray-800 hover:bg-yellow-600 flex items-center {{ request()->is('admin/dashboard') ? 'active' : '' }}">
    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
</a>
<a href="{{ route('admin.users') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/users') ? 'active' : '' }}">
    <i class="fas fa-users-cog mr-2"></i> Manage Users
</a>
<a href="{{ route('admin.app-settings') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/app-settings') ? 'active' : '' }}">
    <i class="fas fa-cogs mr-2"></i> App Settings
</a>
<a href="{{ route('admin.doctors') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/doctors') ? 'active' : '' }}">
    <i class="fas fa-user-md mr-2"></i> Manage Doctors
</a>
<a href="{{ route('admin.analytics') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/analytics') ? 'active' : '' }}">
    <i class="fas fa-chart-line mr-2"></i> Analytics
</a>
<a href="{{ route('admin.logs') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/logs') ? 'active' : '' }}">
    <i class="fas fa-history mr-2"></i> Logs
</a>
<a href="{{ route('admin.support-center') }}" class="bg-blue-800 opacity-90 rounded-full m-2 px-4 py-2 text-gray-200 hover:text-gray-700 hover:bg-white flex items-center {{ request()->is('admin/support-center') ? 'active' : '' }}">
    <i class="fas fa-headset mr-2"></i> Support Center
</a>