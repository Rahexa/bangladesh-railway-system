<!DOCTYPE html>
<html>
<head>
    <title>Payment Canceled</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-yellow-600">Payment Canceled</h1>
        <p class="mt-2 text-gray-700">{{ $message }}</p>
        <a href="/" class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Back to Home</a>
    </div>
</body>
</html>