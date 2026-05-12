<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Dashboard</title>

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

        .table-row:hover {
            background: rgba(255, 255, 255, 0.06);
            transition: 0.3s;
        }
    </style>
</head>

<body class="min-h-screen text-white">

    <div class="max-w-7xl mx-auto p-8">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-5">

            <div>
                <h1 class="text-5xl font-extrabold tracking-wide">
                    Members Dashboard
                </h1>

                <p class="text-slate-300 mt-2">
                    Manage all members with search, edit and delete actions.
                </p>
            </div>

            <a href="{{ route('members.create') }}"
                class="bg-gradient-to-r from-cyan-500 to-blue-600 hover:scale-105 duration-300 px-6 py-3 rounded-2xl shadow-lg font-semibold">
                + Add Member
            </a>

        </div>

        <!-- Success Alert -->
        @if(session('success'))
            <div class="bg-emerald-500/20 border border-emerald-400 text-emerald-200 px-5 py-4 rounded-2xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search Box -->
        <div class="glass rounded-3xl p-5 mb-8 shadow-2xl">

            <form method="GET" action="{{ route('members.index') }}"
                class="flex flex-col md:flex-row gap-4">

                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search by name or email..."
                    class="flex-1 bg-slate-900/50 border border-slate-600 text-white px-5 py-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-cyan-400">

                <button
                    class="bg-cyan-500 hover:bg-cyan-600 duration-300 px-6 py-3 rounded-xl font-semibold shadow-lg">
                    Search
                </button>

            </form>

        </div>

        <!-- Members Table -->
        <div class="glass rounded-3xl overflow-hidden shadow-2xl">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-white/10 text-cyan-300 uppercase text-sm tracking-wider">

                        <tr>
                            <th class="p-5 text-left">ID</th>
                            <th class="p-5 text-left">Member</th>
                            <th class="p-5 text-left">Email</th>
                            <th class="p-5 text-left">Role</th>
                            <th class="p-5 text-center">Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($members as $member)

                            <tr class="table-row border-b border-white/10">

                                <td class="p-5 font-semibold">
                                    #{{ $member->id }}
                                </td>

                                <td class="p-5">

                                    <div class="flex items-center gap-4">

                                        <div
                                            class="w-12 h-12 rounded-full bg-gradient-to-r from-cyan-400 to-blue-500 flex items-center justify-center text-lg font-bold">
                                            {{ strtoupper(substr($member->display_name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <h2 class="font-bold text-lg">
                                                {{ $member->display_name }}
                                            </h2>

                                            <p class="text-slate-400 text-sm">
                                                Member Profile
                                            </p>
                                        </div>

                                    </div>

                                </td>

                                <td class="p-5 text-slate-300">
                                    {{ $member->email }}
                                </td>

                                <td class="p-5">

                                    @if($member->role == 'admin')

                                        <span
                                            class="bg-purple-500/20 text-purple-300 px-4 py-1 rounded-full text-sm font-semibold border border-purple-400">
                                            Admin
                                        </span>

                                    @else

                                        <span
                                            class="bg-green-500/20 text-green-300 px-4 py-1 rounded-full text-sm font-semibold border border-green-400">
                                            User
                                        </span>

                                    @endif

                                </td>

                                <td class="p-5">

                                    <div class="flex justify-center gap-3">

                                        <a href="{{ route('members.edit', $member->id) }}"
                                            class="bg-amber-400 hover:bg-amber-500 text-black px-4 py-2 rounded-xl font-semibold duration-300 shadow-md">
                                            Edit
                                        </a>

                                        <form action="{{ route('members.destroy', $member->id) }}"
                                            method="POST">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Delete this member?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl font-semibold duration-300 shadow-md">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="text-center py-16">

                                    <div class="flex flex-col items-center">

                                        <div class="text-6xl mb-4">
                                            😢
                                        </div>

                                        <h2 class="text-2xl font-bold text-slate-300">
                                            No Members Found
                                        </h2>

                                        <p class="text-slate-500 mt-2">
                                            Try searching something else.
                                        </p>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <!-- Pagination -->
        <div class="mt-8 flex justify-center">
            {{ $members->links() }}
        </div>

    </div>

</body>

</html>