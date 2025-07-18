@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold text-lime-500 mb-6">Orders</h1>

    @if($orders->count())
        <div class="bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-lime-100 text-lime-800 text-sm uppercase">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold">Order ID</th>
                        <th class="px-6 py-3 text-left font-semibold">User</th>
                        <th class="px-6 py-3 text-left font-semibold">Total</th>
                        <th class="px-6 py-3 text-left font-semibold">Status</th>
                        <th class="px-6 py-3 text-left font-semibold">Placed On</th>
                        <th class="px-6 py-3 text-left font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($orders as $order)
                        <tr>
                            <td class="px-6 py-4 text-sm">{{ $order->id }}</td>
                            <td class="px-6 py-4 text-sm">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="px-6 py-4 text-sm text-green-600 font-semibold">€{{ number_format($order->total_price, 2) }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.orders.show', $order) }}" 
                                   class="text-lime-600 hover:underline text-sm font-medium">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <p class="text-gray-600">No orders found.</p>
    @endif
</div>
@endsection
