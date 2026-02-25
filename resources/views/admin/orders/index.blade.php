@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h1 class="text-3xl font-extrabold text-gray-800">Orders</h1>
        </div>

        {{-- Table --}}
        @if($orders->count())
            <div class="overflow-x-auto">
                <table class="min-w-full table-auto rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-800 text-sm uppercase tracking-wider">
                        <tr>
                            <th class="px-6 py-3 text-left">Order ID</th>
                            <th class="px-6 py-3 text-left">User</th>
                            <th class="px-6 py-3 text-left">Total</th>
                            <th class="px-6 py-3 text-left">Status</th>
                            <th class="px-6 py-3 text-left">Placed On</th>
                            <th class="px-6 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            @php
                                $statusColors = [
                                    'completed' => 'bg-green-100 text-green-800',
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                ];
                            @endphp
                            <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-medium text-gray-800">{{ $order->id }}</td>
                                <td class="px-6 py-3 text-gray-700">{{ $order->user->name ?? 'Guest' }}</td>
                                <td class="px-6 py-3 text-green-600 font-semibold">€{{ number_format($order->total_price, 2) }}</td>
                                <td class="px-6 py-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                                <td class="px-6 py-3">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="text-emerald-600 hover:text-emerald-800 font-medium">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $orders->links() }}
            </div>
        @else
            <p class="text-gray-500 text-center py-6">No orders found.</p>
        @endif
    </div>
</div>
@endsection