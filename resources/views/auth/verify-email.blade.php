@extends('layouts.guest')

@section('title', 'Call My Doctor - Verify Email')

@section('content')
    <section class="min-h-screen flex items-center justify-center relative pt-16 hero-background">
        <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-md mx-auto bg-white p-6 rounded-lg shadow-lg text-center">
                <h2 class="text-2xl font-semibold text-blue-900 mb-6">Verify Your Email</h2>

                @if (session('status') == 'verification-link-sent')
                    <div class="mb-4 text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                @if (session('resent'))
                    <div class="mb-4 text-sm text-green-600">
                        A new verification link has been sent to your email address.
                    </div>
                @endif

                <p class="mb-4 text-sm text-gray-600">
                    Before proceeding, please check your email for a verification link. If you did not receive the email,
                    <form method="POST" action="{{ route('verification.send') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 underline focus:outline-none">
                            click here to request another
                        </button>
                    </form>.
                </p>

                <!-- Back to Login Link -->
                <p class="mt-4 text-sm text-gray-600">
                    Already verified? <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800">Login here</a>.
                </p>
            </div>
        </div>
    </section>
@endsection