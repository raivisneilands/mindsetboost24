<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class ProfileController extends Controller
{
    public function show($username)
    {
        $user = User::where('username', $username)->with('posts')->firstOrFail();
        return view('profile.show', compact('user'));
    }
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . Auth::id(),
            'bio' => 'nullable|string|max:1000',
            'profile_image' => 'nullable|image|max:2048',
        ]);

        $user = Auth::user();
        $user->username = $request->username;
        $user->bio = $request->bio;

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        $user->save();

        return redirect()->route('profile.show', auth()->user()->username)->with('success', 'Profile updated successfully.');
    }
    // This is for the follow functionality
    public function toggle(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->id === $user->id) {
            return response()->json(['error' => 'Cannot follow yourself'], 403);
        }

        $following = false;

        if ($authUser->isFollowing($user)) {
            $authUser->following()->detach($user->id);
        } else {
            $authUser->following()->attach($user->id);
            $following = true;
        }

        return response()->json([
            'following' => $following,
            'count' => $user->followers()->count(),
        ]);
    }


}
