@foreach($posts as $post)
    <div class="fade-in bg-white shadow-sm rounded-xl p-5 mb-6">
        <!-- Post Header -->
        <div class="flex items-center gap-3 mb-4">
            <a href="{{ route('profile.show', $post->user->username) }}" class="flex-shrink-0">
                @if($post->user->profile_image)
                    <img src="{{ asset('storage/' . $post->user->profile_image) }}" class="w-10 h-10 rounded-full object-cover border-2 border-emerald-300">
                @else
                    <div class="w-10 h-10 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center font-bold border-2 border-emerald-300">
                        {{ strtoupper(substr($post->user->username, 0, 1)) }}
                    </div>
                @endif
            </a>
            <div>
                <a href="{{ route('profile.show', $post->user->username) }}" class="font-semibold text-emerald-700 hover:underline">
                    {{ $post->user->username }}
                </a>
                <div class="text-sm text-gray-500">{{ $post->created_at->diffForHumans() }}</div>
            </div>
        </div>

        <!-- Post Content -->
        @if($post->content)
            <p class="text-gray-800 text-sm mb-3 leading-relaxed whitespace-pre-line">{{ $post->content }}</p>
        @endif

        @if($post->image)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $post->image) }}" class="w-full rounded border border-gray-200">
            </div>
        @endif

        <!-- Post Footer -->
        <div class="border-t pt-3 mt-3">
            <div class="text-gray-600 text-sm">
                <div class="flex items-center justify-between">
                    <!-- Like Button -->
                    @php
                        $liked = auth()->check() ? $post->isLikedBy(auth()->user()) : false;
                    @endphp
                    <button class="like-btn flex items-center text-red-500 hover:text-red-600 transition" 
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $liked ? 'true' : 'false' }}">
                        <svg id="like-icon-{{ $post->id }}" xmlns="http://www.w3.org/2000/svg" 
                            class="h-5 w-5 transition-all duration-150"
                            viewBox="0 0 20 20" 
                            fill="{{ $liked ? 'currentColor' : 'none' }}" 
                            stroke="currentColor" stroke-width="1.5">
                            <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
                        </svg>
                        <span class="ml-1" id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
                    </button>
                </div>

                <!-- Comment Toggle -->
                <div x-data="{ showComments: false }" class="w-full mt-4">
                    <button @click="showComments = !showComments"
                            class="flex items-center gap-1 text-sm text-gray-600 hover:text-emerald-600 transition font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                            </svg>
                        <span>Comments ({{ $post->comments->count() }})</span>
                    </button>

                    <!-- Comments Section -->
                    <div x-show="showComments" x-transition class="mt-4 space-y-4 border-t pt-4">
                        @foreach($post->comments as $comment)
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 flex-shrink-0">
                                    @if($comment->user->profile_image)
                                        <img src="{{ asset('storage/' . $comment->user->profile_image) }}"
                                            class="w-8 h-8 rounded-full object-cover border border-gray-300">
                                    @else
                                        <div class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center font-bold border border-emerald-300 text-xs">
                                            {{ strtoupper(substr($comment->user->username, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 w-full">
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-semibold text-gray-800">{{ $comment->user->username }}</span>
                                        <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">{{ $comment->body }}</p>
                                </div>
                            </div>
                        @endforeach

                        @auth
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="pt-2">
                                @csrf
                                <textarea name="body"
                                        rows="2"
                                        class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 resize-none"
                                        placeholder="Write a comment..."></textarea>
                                <div class="mt-2 text-right">
                                    <button type="submit"
                                            class="inline-block px-4 py-1.5 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700 transition">
                                        Post Comment
                                    </button>
                                </div>
                            </form>
                        @else
                            <p class="text-xs text-gray-500">You must be logged in to comment.</p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

    </div>
@endforeach

<script>
document.querySelectorAll('.like-btn').forEach(button => {
    button.addEventListener('click', async () => {
        const postId = button.dataset.postId;
        const icon = document.getElementById(`like-icon-${postId}`);
        const countSpan = document.getElementById(`like-count-${postId}`);

        // Disable button while processing (optional)
        button.disabled = true;

        try {
            const response = await fetch(`/posts/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) throw new Error('Network error');

            const data = await response.json();

            // Update count
            countSpan.textContent = data.likes;

            // Update icon fill & data-liked attribute
            if (data.liked) {
                icon.setAttribute('fill', 'currentColor');
                button.dataset.liked = 'true';
            } else {
                icon.setAttribute('fill', 'none');
                button.dataset.liked = 'false';
            }

        } catch (error) {
            console.error('Like toggle failed:', error);
        } finally {
            button.disabled = false;
        }
    });
});
</script>



