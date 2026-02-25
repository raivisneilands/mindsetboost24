@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-700 via-emerald-500 to-emerald-300 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto bg-white rounded-3xl shadow-lg p-6 sm:p-8">

        {{-- Header --}}
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Download Logs</h1>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-3 text-left">User</th>
                        <th class="px-6 py-3 text-left">Product</th>
                        <th class="px-6 py-3 text-left">Order ID</th>
                        <th class="px-6 py-3 text-left">IP Address</th>
                        <th class="px-6 py-3 text-left">Downloaded At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($logs as $log)
                        <tr class="border-t border-gray-200 hover:bg-gray-50 transition">
                            <td class="px-6 py-3 font-medium text-gray-800">{{ $log->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-3 text-gray-700">{{ $log->product->title ?? 'N/A' }}</td>
                            <td class="px-6 py-3">
                                <span class="inline-block bg-green-100 text-green-700 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $log->order_id }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $ip = $log->ip_address;
                                    $maskedIp = preg_replace('/(\d+)$/', 'xxx', $ip); 
                                @endphp
                                <span class="inline-block bg-gray-100 text-gray-800 text-xs font-semibold px-2 py-1 rounded">
                                    {{ $maskedIp }}
                                </span>
                            </td>
                            <td class="px-6 py-3 text-gray-600">{{ $log->created_at->format('d.m.Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-6 py-4 text-gray-500">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $logs->links() }}
        </div>
    </div>
</div>
@endsection