@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">Users</h1>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Name</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Username</th>
                        <th class="px-6 py-3 text-left">Registered On</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3">{{ $user->name }}</td>
                            <td class="px-6 py-3">{{ $user->email }}</td>
                            <td class="px-6 py-3">{{ $user->username }}</td>
                            <td class="px-6 py-3">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-3 space-x-2">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-500 hover:underline">View</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-yellow-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection