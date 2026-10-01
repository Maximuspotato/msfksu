<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual Data Export</title>
    <!-- Tailwind CSS for basic styling -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Generate Oracle Reports</h2>
        
        <p class="text-gray-600 mb-6 text-sm">
            Click the button below to manually fetch the latest data from Oracle and overwrite the Product, Stock, and Planning Excel files.
        </p>

        <!-- Display Success Message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Display Error Message -->
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4" role="alert">
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Trigger Form -->
        <form action="{{ route('export.manual') }}" method="POST">
            @csrf
            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition duration-200 cursor-pointer">
                Run Export Now
            </button>
        </form>
    </div>

</body>
</html>