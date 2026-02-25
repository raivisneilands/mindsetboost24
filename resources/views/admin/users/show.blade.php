@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">User #{{ $user->id }} Details</h1>

        {{-- User Info --}}
        <div class="mb-6 bg-gray-50 rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Profile</h2>
            <p><span class="font-medium">Name:</span> {{ $user->name }}</p>
            <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
            <p><span class="font-medium">Username:</span> {{ $user->username }}</p>
            <p><span class="font-medium">Registered:</span> {{ $user->created_at->format('d M Y') }}</p>
        </div>

        {{-- Orders --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Orders</h2>
            @if($user->orders->count())
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2 text-left">Order ID</th>
                                <th class="px-4 py-2 text-left">Total</th>
                                <th class="px-4 py-2 text-left">Status</th>
                                <th class="px-4 py-2 text-left">Placed On</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders as $order)
                                <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ $order->id }}</td>
                                    <td class="px-4 py-2 text-green-600 font-semibold">€{{ number_format($order->total_price, 2) }}</td>
                                    <td class="px-4 py-2">{{ ucfirst($order->status) }}</td>
                                    <td class="px-4 py-2">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No orders placed.</p>
            @endif
        </div>

        {{-- Download Logs --}}
        <div class="mb-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Download Logs</h2>
            @if($user->downloads->count())
                <div class="overflow-x-auto border rounded-lg">
                    <table class="min-w-full table-auto">
                        <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2 text-left">Product</th>
                                <th class="px-4 py-2 text-left">Order ID</th>
                                <th class="px-4 py-2 text-left">IP Address</th>
                                <th class="px-4 py-2 text-left">Downloaded At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->downloads as $log)
                                <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                                    <td class="px-4 py-2">{{ $log->product->title ?? 'N/A' }}</td>
                                    <td class="px-4 py-2">{{ $log->order_id }}</td>
                                    <td class="px-4 py-2">{{ preg_replace('/(\d+)$/', 'xxx', $log->ip_address) }}</td>
                                    <td class="px-4 py-2">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-gray-500">No downloads yet.</p>
            @endif
        </div>

        <a href="{{ route('admin.users.index') }}" class="inline-block bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-xl shadow">
            Back to Users
        </a>
    </div>
</div>
@endsection