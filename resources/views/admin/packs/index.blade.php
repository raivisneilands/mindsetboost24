@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">🎁 Product Packs</h1>
            <a href="{{ route('admin.packs.create') }}" class="mt-4 sm:mt-0 bg-emerald-500 text-white px-4 py-2 rounded-xl hover:bg-emerald-600 transition">
                + Create New Pack
            </a>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100/30 border border-green-300 text-green-800">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-800 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Products</th>
                        <th class="px-6 py-3 text-left">Discount</th>
                        <th class="px-6 py-3 text-left">Final Price</th>
                        <th class="px-6 py-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($packs as $pack)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-800 font-medium">{{ $pack->title }}</td>
                            <td class="px-6 py-4 text-gray-600">{{ $pack->products->count() }} products</td>
                            <td class="px-6 py-4 text-gray-600">{{ $pack->discount_percent }}%</td>
                            <td class="px-6 py-4 text-gray-800 font-semibold">€{{ number_format($pack->final_price, 2) }}</td>
                            <td class="px-6 py-4 flex justify-start gap-3">
                                <a href="{{ route('admin.packs.edit', $pack) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.packs.destroy', $pack) }}" method="POST" onsubmit="return confirm('Delete this pack?')">
                                    @csrf @method('DELETE')
                                    <button class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500 py-6">No product packs yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $packs->links() }}
        </div>
    </div>
</div>
@endsection