<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Member</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(to right, #0f172a, #1e293b);
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center p-6">

    <div class="w-full max-w-2xl">

        <div class="glass rounded-3xl shadow-2xl overflow-hidden">

            <!-- Header -->
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-8 text-center">

                <h1 class="text-4xl font-extrabold text-white">
                    Create Member
                </h1>

                <p class="text-cyan-100 mt-2">
                    Add a new member to your dashboard
                </p>

            </div>

            <!-- Form -->
            <div class="p-8">

                <form action="{{ route('members.store') }}" method="POST">

                    @csrf

                    <!-- Name -->
                    <div class="mb-6">

                        <label class="block text-slate-200 mb-2 font-semibold">
                            Full Name
                        </label>

                        <input type="text"
                            name="name"
                            placeholder="Enter member name"
                            class="w-full bg-slate-900/50 border border-slate-600 text-white px-5 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-400">

                    </div>

                    <!-- Email -->
                    <div class="mb-6">

                        <label class="block text-slate-200 mb-2 font-semibold">
                            Email Address
                        </label>

                        <input type="email"
                            name="email"
                            placeholder="Enter email address"
                            class="w-full bg-slate-900/50 border border-slate-600 text-white px-5 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-400">

                    </div>

                    <!-- Role -->
                    <div class="mb-8">

                        <label class="block text-slate-200 mb-2 font-semibold">
                            Select Role
                        </label>

                        <select name="role"
                            class="w-full bg-slate-900/50 border border-slate-600 text-white px-5 py-4 rounded-2xl focus:outline-none focus:ring-2 focus:ring-cyan-400">

                            <option value="user">User</option>
                            <option value="admin">Admin</option>

                        </select>

                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center justify-between">

                        <a href="{{ route('members.index') }}"
                            class="bg-slate-700 hover:bg-slate-600 text-white px-6 py-3 rounded-2xl duration-300 font-semibold">
                            Back
                        </a>

                        <button
                            class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 duration-300 text-white px-8 py-3 rounded-2xl shadow-lg font-bold">
                            Save Member
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</body>

</html>