@extends('layouts.app')

@section('title', 'Fund Wallet')
@section('navbar-title', 'Fund Wallet')

@section('sidebar-menu')
    @component('components.doctor-menu') @endcomponent
@endsection

@section('content')
    <nav class="md:ml-64 lg:ml-0 text-sm font-medium text-gray-700 mb-4" aria-label="Breadcrumb">
        <ol class="list-none p-0 inline-flex">
            <li class="flex items-center">
                <a href="{{ route('doctor.dashboard') }}" class="text-blue-600 hover:text-blue-800">Doctor Dashboard</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <a href="{{ route('doctor.my-wallet') }}" class="text-blue-600 hover:text-blue-800">My Wallet</a>
                <span class="mx-2">/</span>
            </li>
            <li class="flex items-center">
                <span class="text-gray-500">Fund Wallet</span>
            </li>
        </ol>
    </nav>

    <h2 class="text-2xl md:ml-64 lg:ml-0 font-semibold mb-6">Fund Wallet</h2>

    <div class="md:ml-64 lg:ml-0 bg-white p-6 rounded-lg shadow">
        <form id="payment-form" method="POST" action="{{ route('doctor.process-payment') }}" class="max-w-md">
            @csrf
            <div class="mb-4">
                <label for="amount" class="block text-sm font-medium text-gray-700">Amount (NGN)</label>
                <input type="number" id="amount" name="amount" step="100" min="100" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div id="paystack-payment-button" class="mt-4">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">Pay with Card</button>
            </div>
        </form>
    </div>
@endsection

<script src="https://js.paystack.co/v1/inline.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const paymentForm = document.getElementById('payment-form');

        paymentForm.addEventListener('submit', function(event) {
            event.preventDefault();

            let handler = PaystackPop.setup({
                key: 'sk_test_a294110f874ebac9fde6a233115cc37f8391cdf1', // Replace with your Paystack public key
                email: '{{ auth()->user()->email }}', // Assuming authenticated user
                amount: document.getElementById('amount').value * 100, // Amount in kobo
                currency: 'NGN',
                callback: function(response) {
                    // Handle successful payment
                    fetch('/doctor/process-payment', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            reference: response.reference,
                            amount: document.getElementById('amount').value
                        })
                    }).then(response => response.json())
                      .then(data => {
                          if (data.success) {
                              alert('Payment successful! Wallet updated.');
                              window.location.href = '{{ route('doctor.my-wallet') }}';
                          } else {
                              alert('Payment failed. Please try again.');
                          }
                      });
                },
                onClose: function() {
                    alert('Payment window closed.');
                }
            });
            handler.openIframe();
        });
    });
</script>