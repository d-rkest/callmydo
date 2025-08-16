<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>404 - Not Found - Call My Doctor</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.8s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white rounded-lg shadow-lg p-8 max-w-md text-center fade-in" style="animation-delay: 0.2s;">
        <div class="mb-6">
            <div class="inline-block h-16 w-16 text-blue-500 animate-pulse">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-full w-full">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-gray-800 mb-4">404 - Page Not Found</h1>
        <p class="text-gray-600 mb-6">Uh-oh! The page you’re looking for seems to have taken a wrong turn. It might be missing or moved elsewhere.</p>
        <a href="/" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-300 animate-bounce" style="animation-iteration-count: 1;">Go Back to Homepage</a>
        <p class="text-sm text-gray-500 mt-4">Need help? Contact <a href="mailto:support@callmydoctor.ng" class="text-blue-500 hover:underline">support@callmydoctor.ng</a>.</p>
    </div>
</body>
</html>