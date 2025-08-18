@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto py-10 px-4">
    <h1 class="text-3xl font-bold text-emerald-500 mb-8">Download Logs</h1>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full table-auto border-collapse">
            <thead>
                <tr class="bg-emerald-100 text-left text-gray-700 text-sm uppercase tracking-wider">
                    <th class="px-6 py-3 border-b">User</th>
                    <th class="px-6 py-3 border-b">Product</th>
                    <th class="px-6 py-3 border-b">Order ID</th>
                    <th class="px-6 py-3 border-b">IP Address</th>
                    <th class="px-6 py-3 border-b">Downloaded At</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-600">
                @forelse ($logs as $log)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 border-b">{{ $log->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-b">{{ $log->product->title ?? 'N/A' }}</td>
                        <td class="px-6 py-4 border-b">{{ $log->order_id }}</td>
                        <td class="px-6 py-4 border-b">
                            @php
                                $ip = $log->ip_address;
                                $maskedIp = preg_replace('/(\d+)$/', 'xxx', $ip); 
                            @endphp
                            {{ $maskedIp }}
                        </td>
                        <td class="px-6 py-4 border-b">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center px-6 py-4 text-gray-500">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
</div>
@endsection
