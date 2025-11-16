<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Badge;

class BadgeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Remove all existing badges first
        DB::table('badge_user')->delete(); // clear pivot table first to avoid foreign key issues
        DB::table('badges')->delete();

        $badges = [
            [
                'slug' => 'first-post',
                'name' => 'First Post',
                'description' => 'Created your first post.',
                'icon' => '📝',
            ],
            [
                'slug' => 'active-contributor',
                'name' => 'Active Contributor',
                'description' => 'Posted 5 times.',
                'icon' => '✍️',
            ],            
            [
                'slug' => 'writer',
                'name' => 'Writer',
                'description' => 'Posted 10 times.',
                'icon' => '🖋️',
            ],
            [
                'slug' => 'storyteller',
                'name' => 'Storyteller',
                'description' => 'Posted 20 times.',
                'icon' => '📖',
            ],
            [
                'slug' => 'community-voice',
                'name' => 'Community Voice',
                'description' => 'Posted 50 times.',
                'icon' => '🎤',
            ],
            [
                'slug' => 'first-download',
                'name' => 'First Download',
                'description' => 'Download 1 product.',
                'icon' => '📥',
            ],
            [
                'slug' => 'explorer',
                'name' => 'Explorer',
                'description' => 'Download 5 products.',
                'icon' => '🧭',
            ],
            [
                'slug' => 'collector',
                'name' => 'Collector',
                'description' => 'Download 10 products.',
                'icon' => '🗂️',
            ],
            [
                'slug' => 'power-user',
                'name' => 'Power User',
                'description' => 'Download 20 products.',
                'icon' => '⚡',
            ],
            [
                'slug' => 'mindset-master',
                'name' => 'Mindset Master',
                'description' => 'Download 50 products.',
                'icon' => '🏆',
            ],
        ];

        foreach ($badges as $badge) {
            Badge::create($badge);
        }
    }
}
