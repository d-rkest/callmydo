<div id="call-waiting-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center" aria-hidden="true">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
        <img src="{{ url('images/connect.png') }}" alt="Doctors Connecting" class="w-full h-48 object-cover rounded-t-lg">
        <h3 class="text-lg font-bold text-blue-800 mt-4">Connecting<span class="animate-waver">...</span></h3>
        <p class="text-sm text-gray-600 mt-2">Please wait while we connect you to a doctor.</p>
        <button id="end-call" class="mt-4 bg-red-600 text-white p-3 rounded-full hover:bg-red-700">End Call</button>
    </div>
</div>