@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow-md rounded-lg mt-8 p-6 border border-emerald-200">
    <h2 class="text-2xl font-bold text-emerald-700 mb-6">Edit Your Profile</h2>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-emerald-100 text-emerald-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="username" class="block text-sm font-semibold text-emerald-700 mb-1">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}"
                   class="w-full border border-emerald-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-emerald-400 focus:border-emerald-500">
        </div>

        <div>
            <label for="bio" class="block text-sm font-semibold text-emerald-700 mb-1">Bio</label>
            <textarea name="bio" rows="4"
                      class="w-full border border-emerald-300 rounded px-4 py-2 focus:outline-none focus:ring focus:ring-emerald-400 focus:border-emerald-500">{{ old('bio', $user->bio) }}</textarea>
        </div>

        <div x-data="{ preview: null }" class="space-y-2">
            <label for="profile_image" class="block text-sm font-semibold text-emerald-700 mb-1">Profile Image</label>

            <!-- Old Image -->
            @if($user->profile_image && !old('profile_image'))
                <img src="{{ asset('storage/' . $user->profile_image) }}"
                    alt="Current Profile"
                    class="w-24 h-24 rounded-full object-cover border border-emerald-300">
            @endif

            <!-- Preview -->
            <template x-if="preview">
                <img :src="preview"
                    alt="Image Preview"
                    class="w-24 h-24 rounded-full object-cover border border-emerald-400 shadow">
            </template>

            <!-- File Input -->
            <input type="file" name="profile_image"
                class="block w-full text-sm text-gray-700 border border-emerald-300 rounded px-3 py-2 bg-white file:bg-emerald-100 file:text-emerald-700 file:border-none file:rounded file:px-4 file:py-1.5 hover:file:bg-emerald-200"
                @change="const file = $event.target.files[0]; preview = file ? URL.createObjectURL(file) : null">
        </div>


        <div>
            <button type="submit"
                    class="w-full bg-emerald-600 text-white font-semibold py-2 px-4 rounded hover:bg-emerald-700 transition">
                Update Profile
            </button>
        </div>
    </form>
</div>
@endsection
