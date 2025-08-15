<div id="call-notification-modal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden flex items-center justify-center" aria-hidden="true">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md text-center">
        <h3 class="text-lg font-bold text-red-800 mt-4">Incoming Call</h3>
        <p class="text-sm text-gray-600 mt-2">A patient is requesting a call. Accept or decline?</p>
        <audio id="ringtone" src="{{ url('sounds/telephone-ring-02.mp3') }}" loop></audio>
        <div class="mt-4 space-x-4">
            <button id="accept-call" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Accept</button>
            <button id="decline-call" class="bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">Decline</button>
        </div>
    </div>
</div>