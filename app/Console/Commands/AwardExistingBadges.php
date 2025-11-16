<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\DownloadLog;

class AwardExistingBadges extends Command
{
    protected $signature = 'badges:award-existing';
    protected $description = 'Award badges based on existing posts and downloads in the database';

    public function handle()
    {
        $this->info("Awarding badges to existing users...");

        User::chunk(50, function ($users) {
            foreach ($users as $user) {

                // Count posts
                $postCount = $user->posts()->count();

                if ($postCount >= 1) {
                    $user->awardBadge('first-steps');
                }

                if ($postCount >= 5) {
                    $user->awardBadge('active-member');
                }

                // Count downloads
                $downloadCount = DownloadLog::where('user_id', $user->id)->count();

                if ($downloadCount >= 1) {
                    $user->awardBadge('explorer');
                }
            }
        });

        $this->info("Done! Badges awarded based on existing data.");
    }
}
