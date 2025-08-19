@extends('layouts.app')

@section('title', 'Checkout')
@section('navbar-title', 'Checkout')

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
                <a href="{{ route('buy-prescription', 1) }}" class="text-blue-600 hover:text-blue-800">Buy Prescription</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Checkout</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Checkout</h2>

    <div class="md:ml-64 lg:ml-0 flex items-center justify-center min-h-[calc(100vh-20rem)]">
        <div class="max-w-md w-full bg-white shadow-2xl rounded-lg p-8 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Order Summary</h3>
            <div class="text-left space-y-4">
                <p><strong>Total Cost:</strong> ₦{{ '8,600' }}</p>
                <p><strong>Delivery Fee:</strong> 
                    <?php $deliveryOption = 'delivery'; // Example delivery option?>
                    @if ($deliveryOption === 'delivery')
                        ₦500
                    @else
                        Free
                    @endif
                </p>
                <p><strong>Grand Total:</strong> ₦{{ '9,100' }}</p>
            </div>
            <button id="payWithPaystack" class="mt-6 bg-green-600 text-white px-6 py-3 rounded-md hover:bg-green-700 transition duration-300">Pay with Paystack</button>
            <p class="text-sm text-gray-500 mt-4">Secure payment powered by Paystack</p>
        </div>
    </div>

    {{-- <script src="https://js.paystack.co/v1/inline.js"></script>
    <script>
        document.getElementById('payWithPaystack').addEventListener('click', function() {
            let handler = PaystackPop.setup({
                key: '{{ config('services.paystack.public_key') }}', // Replace with your Paystack public key
                email: '{{ auth()->user()->email }}',
                amount: {{ $grandTotal * 100 }}, // Amount in kobo (multiply by 100)
                currency: 'NGN',
                ref: 'REF_' + Math.floor((Math.random() * 1000000000) + 1), // Generate a reference
                callback: function(response) {
                    alert('Payment successful! Reference: ' + response.reference);
                    window.location.href = '{{ route('dashboard') }}';
                },
                onClose: function() {
                    alert('Transaction was not completed, window closed.');
                }
            });
            handler.openIframe();
        });
    </script> --}}
@endsection