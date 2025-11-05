@foreach($posts as $post)
<div class="fade-in bg-white shadow-sm rounded-xl p-5 mb-6" id="post-{{ $post->id }}">
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

        <!-- Likes -->
        @php $liked = auth()->check() ? $post->isLikedBy(auth()->user()) : false; @endphp
        <div class="flex items-center justify-between text-red-600 text-sm">
            <button class="like-btn flex items-center gap-1 transition font-medium" data-post-id="{{ $post->id }}" data-liked="{{ $liked ? 'true' : 'false' }}">
                <svg id="like-icon-{{ $post->id }}" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-all duration-150"
                     viewBox="0 0 20 20" fill="{{ $liked ? 'currentColor' : 'none' }}" stroke="currentColor" stroke-width="1.5">
                    <path d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 18.657l-6.828-6.829a4 4 0 010-5.656z" />
                </svg>
                <span id="like-count-{{ $post->id }}">{{ $post->likes->count() }}</span>
            </button>

            <button class="flex items-center gap-1 text-gray-600 hover:text-emerald-600 transition font-medium" data-toggle-comments="{{ $post->id }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                </svg>
                Comments ({{ $post->comments->count() }})
            </button>
        </div>

        <!-- Comments Section -->
        <div id="comments-{{ $post->id }}" class="mt-4 space-y-4 hidden">

            <!-- Existing Comments -->
            @foreach($post->comments as $comment)
                <div class="flex items-start gap-3" id="comment-{{ $comment->id }}">
                    <div class="w-8 h-8 flex-shrink-0">
                        @if($comment->user->profile_image)
                            <img src="{{ asset('storage/' . $comment->user->profile_image) }}" class="w-8 h-8 rounded-full object-cover border border-gray-300">
                        @else
                            <div class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center font-bold border border-emerald-300 text-xs">
                                {{ strtoupper(substr($comment->user->username, 0, 1)) }}
                            </div>
                        @endif
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 w-full relative">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-800">{{ $comment->user->username }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                @if($comment->user_id === auth()->id())
                                    <button data-id="{{ $comment->id }}" class="delete-comment text-red-500 text-xs hover:underline">Delete</button>
                                @endif
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">{{ $comment->body }}</p>
                    </div>
                </div>
            @endforeach

            <!-- Add Comment Form -->
            @auth
            <form class="comment-form flex flex-col mt-2" data-post-id="{{ $post->id }}">
                @csrf
                <textarea name="body" rows="2" placeholder="Write a comment..." class="w-full border border-gray-300 rounded-lg p-2 text-sm focus:ring-emerald-500 focus:border-emerald-500 resize-none"></textarea>
                <div class="mt-2 text-right">
                    <button type="submit" class="inline-block px-4 py-1.5 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700 transition">Post Comment</button>
                </div>
            </form>
            @else
                <p class="text-xs text-gray-500 mt-2">You must be logged in to comment.</p>
            @endauth
        </div>
    </div>
</div>
@endforeach

<script>
document.addEventListener('DOMContentLoaded', () => {

    // Toggle comment sections
    document.querySelectorAll('[data-toggle-comments]').forEach(button => {
        button.addEventListener('click', () => {
            const postId = button.dataset.toggleComments;
            const section = document.getElementById(`comments-${postId}`);
            section.classList.toggle('hidden');
        });
    });

    // Like buttons
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const postId = button.dataset.postId;
            const icon = document.getElementById(`like-icon-${postId}`);
            const countSpan = document.getElementById(`like-count-${postId}`);
            button.disabled = true;

            try {
                const res = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();
                countSpan.textContent = data.likes;
                icon.setAttribute('fill', data.liked ? 'currentColor' : 'none');
                button.dataset.liked = data.liked ? 'true' : 'false';
            } catch (e) { console.error(e); }
            finally { button.disabled = false; }
        });
    });

    // Post comments via AJAX
    document.querySelectorAll('.comment-form').forEach(form => {
        form.addEventListener('submit', async e => {
            e.preventDefault();
            const postId = form.dataset.postId;
            const textarea = form.querySelector('textarea[name="body"]');
            const body = textarea.value.trim();
            if (!body) return;

            const res = await fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ body })
            });

            const data = await res.json();
            if (res.ok) {
                const commentList = document.getElementById(`comments-${postId}`);
                const commentEl = document.createElement('div');
                commentEl.id = `comment-${data.id}`;
                commentEl.className = "flex items-start gap-3";
                commentEl.innerHTML = `
                    <div class="w-8 h-8 flex-shrink-0">
                        ${data.profile_image ? 
                            `<img src="${data.profile_image}" class="w-8 h-8 rounded-full object-cover border border-gray-300">` :
                            `<div class="w-8 h-8 rounded-full bg-emerald-200 text-emerald-800 flex items-center justify-center font-bold border border-emerald-300 text-xs">${data.user.charAt(0).toUpperCase()}</div>`
                        }
                    </div>
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 w-full relative">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-semibold text-gray-800">${data.user}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">${data.time}</span>
                                <button data-id="${data.id}" class="delete-comment text-red-500 text-xs hover:underline">Delete</button>
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 mt-1 whitespace-pre-line">${data.body}</p>
                    </div>
                `;
                commentList.prepend(commentEl);
                textarea.value = '';
            } else {
                console.error(data);
            }
        });
    });

    // Delete comments via AJAX
    document.addEventListener('click', async e => {
        if (e.target.classList.contains('delete-comment')) {
            const commentId = e.target.dataset.id;
            const commentEl = document.getElementById(`comment-${commentId}`);
            const postId = commentEl.closest('[id^="comments-"]').id.split('-')[1];

            const res = await fetch(`/posts/${postId}/comments/${commentId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });
            if (res.ok) commentEl.remove();
        }
    });

});
</script>
