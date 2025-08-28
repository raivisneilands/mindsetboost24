@extends('layouts.app')

@section('title', 'Express Your Thoughts | Mindset Boost 24')
@section('meta_description', 'Keep track of your personal growth and reflections with your private journal on Mindset Boost 24. Your space for focus and self-improvement.')


@section('content')
<div class="max-w-6xl mx-auto px-4 my-10 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-10">
        <h1 class="text-2xl font-semibold text-emerald-700">Your Journal</h1>
        <a href="{{ route('journal.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded shadow">
            + New Entry
        </a>
    </div>

    @forelse ($entries as $entry)

        <div class="mb-6 p-6 bg-white rounded-lg shadow border border-emerald-100">
            <p class="text-sm text-gray-500 mb-2">
                Written on {{ $entry->created_at->format('F j, Y \a\t g:i A') }} <br/>
                @if ($entry->updated_at != $entry->created_at)
                    Last updated: {{ $entry->updated_at->format('F j, Y \a\t g:i A') }}    
                @endif
            </p>
            <h2 class="text-xl font-bold text-emerald-800 mb-2">{{ $entry->title }}</h2>
            <div class="prose max-w-none text-gray-800 trix-content">{!! $entry->body !!}</div>

            {{-- @if ($entry->images)
                <div class="flex flex-wrap gap-2 mt-4">
                    @foreach ($entry->images as $img)
                        <img src="{{ asset('storage/' . $img) }}" class="object-cover rounded border" />
                    @endforeach
                </div>
            @endif --}}

            <div class="mt-4 flex gap-3 text-sm">
                <a href="{{ route('journal.edit', $entry) }}" class="text-emerald-600 hover:underline font-medium">Edit</a>
                <form action="{{ route('journal.destroy', $entry) }}" method="POST" onsubmit="return confirm('Delete this entry?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline font-medium">Delete</button>
                </form>
            </div>
        </div>
    @empty
        <p class="text-gray-600">You haven’t written anything yet.</p>
    @endforelse

</div>
<script>
document.addEventListener("trix-attachment-add", function(event) {
    const attachment = event.attachment;

    if (attachment.file) {
        uploadImage(attachment);
    }

    function uploadImage(attachment) {
        const file = attachment.file;
        const form = new FormData();
        form.append("image", file);

        fetch("/trix-upload", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
            },
            body: form,
        })
        .then(response => response.json())
        .then(data => {
            attachment.setAttributes({
                url: data.url,
                href: data.url,
            });
        })
        .catch(error => {
            console.error("Upload failed:", error);
        });
    }
});
</script>

@endsection
