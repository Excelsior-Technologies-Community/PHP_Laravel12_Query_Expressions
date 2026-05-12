<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Role Counts</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body {
            background: linear-gradient(to right, #0f172a, #1e293b);
        }

        .glass {
            background: rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(14px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .card-hover:hover {
            transform: translateY(-6px);
            transition: 0.3s;
        }
    </style>
</head>

<body class="min-h-screen text-white flex items-center justify-center p-6">

    <div class="max-w-5xl w-full">

        <!-- Header -->
        <div class="text-center mb-12">

            <h1
                class="text-5xl font-extrabold bg-gradient-to-r from-cyan-400 to-blue-500 bg-clip-text text-transparent">
                Member Role Analytics
            </h1>

            <p class="text-slate-300 mt-4 text-lg">
                Overview of all registered member roles
            </p>

        </div>

        <!-- Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

            <!-- Admin Card -->
            <div class="glass rounded-3xl p-8 shadow-2xl card-hover">

                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h2 class="text-2xl font-bold text-purple-300">
                            Admins
                        </h2>

                        <p class="text-slate-400 mt-1">
                            Total administrator accounts
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-purple-500/20 flex items-center justify-center text-3xl border border-purple-400">
                        👑
                    </div>

                </div>

                <h3 class="text-6xl font-extrabold text-white">
                    {{ $counts->admins ?? 0 }}
                </h3>

                <div class="mt-6 h-2 rounded-full bg-slate-700 overflow-hidden">

                    <div class="h-full bg-gradient-to-r from-purple-400 to-pink-500 w-3/4 rounded-full">
                    </div>

                </div>

            </div>

            <!-- User Card -->
            <div class="glass rounded-3xl p-8 shadow-2xl card-hover">

                <div class="flex items-center justify-between mb-6">

                    <div>
                        <h2 class="text-2xl font-bold text-green-300">
                            Users
                        </h2>

                        <p class="text-slate-400 mt-1">
                            Total normal user accounts
                        </p>
                    </div>

                    <div
                        class="w-16 h-16 rounded-2xl bg-green-500/20 flex items-center justify-center text-3xl border border-green-400">
                        👥
                    </div>

                </div>

                <h3 class="text-6xl font-extrabold text-white">
                    {{ $counts->users ?? 0 }}
                </h3>

                <div class="mt-6 h-2 rounded-full bg-slate-700 overflow-hidden">

                    <div class="h-full bg-gradient-to-r from-green-400 to-emerald-500 w-4/5 rounded-full">
                    </div>

                </div>

            </div>

        </div>

        <!-- Bottom Section -->
        <div class="glass rounded-3xl mt-10 p-6 shadow-xl">

            <div class="flex flex-col md:flex-row items-center justify-between gap-5">

                <div>
                    <h2 class="text-2xl font-bold text-cyan-300">
                        Dashboard Summary
                    </h2>

                    <p class="text-slate-400 mt-2">
                        Total Members:
                        <span class="text-white font-bold">
                            {{ ($counts->admins ?? 0) + ($counts->users ?? 0) }}
                        </span>
                    </p>
                </div>

                <a href="{{ route('members.index') }}"
                    class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 duration-300 px-8 py-3 rounded-2xl font-bold shadow-lg">
                    Back to Members
                </a>

            </div>

        </div>

    </div>

</body>

</html>