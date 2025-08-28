@extends('layouts.app')

@section('title', 'Edit Entry | Mindset Boost 24')

@section('content')
<div class="max-w-6xl mx-auto my-10 px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold text-emerald-700 mb-6">Edit Entry</h1>

    <form action="{{ route('journal.update', $journal) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <input type="text" name="title" value="{{ $journal->title }}" placeholder="Entry Title" class="w-full px-4 py-2 border border-emerald-300 rounded shadow-sm focus:ring focus:ring-emerald-200" />

        <input id="body" type="hidden" name="body" value="{{ $journal->body }}">
        <trix-editor input="body" class="trix-content border border-emerald-300 rounded shadow-sm"></trix-editor>

        <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2 rounded shadow">
            Update Entry
        </button>
    </form>
</div>
@endsection
