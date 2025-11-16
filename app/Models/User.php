<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'bio',
        'profile_image',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'post_user_likes')->withTimestamps();
    }
    public function following()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'followed_id')->withTimestamps();
    }

    // Users who follow the current user
    public function followers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'followed_id', 'follower_id')->withTimestamps();
    }

    public function isFollowing(User $user)
    {
        return $this->following->contains($user);
    }
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    public function badges()
    {
        return $this->belongsToMany(Badge::class)->withTimestamps();
    }

    public function hasBadge($slug)
    {
        return $this->badges->contains('slug', $slug);
    }

    public function awardBadge($slug)
    {
        $badge = Badge::where('slug', $slug)->first();

        if (!$badge) return false;

        if (!$this->hasBadge($slug)) {
            $this->badges()->attach($badge->id);
            session()->flash('badge_earned', $badge);
            return true;
        }

        return false;
    }

}
