<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::with('user')->latest()->paginate(10);

        if ($request->ajax()) {
            return view('ascend._posts', compact('posts'))->render();
        }

        return view('ascend.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('journey_images', 'public');
        }

        $request->user()->posts()->create([
            'content' => $request->input('content'),
            'image' => $imagePath,
        ]);

        return redirect()->route('ascend.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        $post->delete();

        return redirect()->route('ascend.index');
    }
    // This is for the liking functionality
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($post->isLikedBy($user)) {
            $post->likes()->detach($user->id);
            $liked = false;
        } else {
            $post->likes()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'likes' => $post->likes()->count(),
            'liked' => $liked,
        ]);
    }
    public function storeComment(Request $request, Post $post)
    {
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return response()->json([
            'user' => $comment->user->username,
            'body' => $comment->body,
            'time' => $comment->created_at->diffForHumans(),
            'count' => $post->comments()->count(),
        ]);
    }
    public function indexComments(Post $post)
    {
        return response()->json([
            'comments' => $post->comments()->with('user')->latest()->get()->map(function ($comment) {
                return [
                    'user' => $comment->user->username,
                    'body' => $comment->body,
                    'time' => $comment->created_at->diffForHumans(),
                ];
            }),
            'count' => $post->comments()->count(),
        ]);
    }
}
