@extends('layouts.app')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Download Logs</h1>

    <table class="w-full table-auto border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 px-4 py-2">User</th>
                <th class="border border-gray-300 px-4 py-2">Product</th>
                <th class="border border-gray-300 px-4 py-2">Order ID</th>
                <th class="border border-gray-300 px-4 py-2">IP Address</th>
                <th class="border border-gray-300 px-4 py-2">Downloaded At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($logs as $log)
                <tr>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->user->name ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->product->title ?? 'N/A' }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->order_id }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->ip_address }}</td>
                    <td class="border border-gray-300 px-4 py-2">{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
@endsection
