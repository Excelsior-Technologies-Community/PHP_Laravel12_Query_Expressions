<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Role Counts</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-2xl mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 border-b pb-2">Member Role Counts</h1>
        </header>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-600">Admins</h2>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $counts->admins ?? 0 }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-600">Users</h2>
                <p class="text-3xl font-bold text-gray-800 mt-2">{{ $counts->users ?? 0 }}</p>
            </div>
        </div>
    </div>
</body>

</html>