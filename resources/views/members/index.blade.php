<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member List</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans antialiased">
    <div class="max-w-4xl mx-auto p-6">
        <header class="mb-6">
            <h1 class="text-3xl font-bold text-gray-800 border-b pb-2">Members</h1>
        </header>

        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            @if($members->isEmpty())
                <p class="p-6 text-gray-500 text-center">No members found.</p>
            @else
                <ul class="divide-y divide-gray-200">
                    @foreach($members as $member)
                        <li class="p-4 hover:bg-gray-50 flex justify-between items-center">
                            <span class="text-gray-800 font-medium">{{ $member->display_name }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</body>

</html>