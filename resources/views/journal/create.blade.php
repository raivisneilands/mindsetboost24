@extends('layouts.app')

@section('title', 'Create Entry | Mindset Boost 24')

@section('content')
<div class="max-w-6xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-emerald-700">New Journal Entry</h1>

    <form action="{{ route('journal.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <input type="text" name="title" placeholder="Entry Title" class="w-full px-4 py-2 border border-emerald-300 rounded shadow-sm focus:ring focus:ring-emerald-200" />

        <input id="body" type="hidden" name="body">
        <trix-editor input="body" class="trix-content border border-emerald-300 rounded shadow-sm"></trix-editor>

        {{-- <div>
            <label class="block mb-1 font-medium text-gray-700">Upload Images (optional):</label>
            <input type="file" name="images[]" multiple class="w-full" />
        </div> --}}

        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded shadow">
            Save Entry
        </button>
    </form>
</div>
@endsection
