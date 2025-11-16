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

                // ------------------------
                //     POSTING BADGES
                // ------------------------

                $postCount = $user->posts()->count();

                if ($postCount >= 1) {
                    $user->awardBadge('first-post');
                }

                if ($postCount >= 5) {
                    $user->awardBadge('active-contributor');
                }

                if ($postCount >= 10) {
                    $user->awardBadge('writer');
                }

                if ($postCount >= 20) {
                    $user->awardBadge('storyteller');
                }

                if ($postCount >= 50) {
                    $user->awardBadge('community-voice');
                }


                // ------------------------
                //   DOWNLOAD BADGES
                // ------------------------

                $downloadCount = DownloadLog::where('user_id', $user->id)->count();

                if ($downloadCount >= 1) {
                    $user->awardBadge('first-download');
                }

                if ($downloadCount >= 5) {
                    $user->awardBadge('explorer');
                }

                if ($downloadCount >= 10) {
                    $user->awardBadge('collector');
                }

                if ($downloadCount >= 20) {
                    $user->awardBadge('power-user');
                }

                if ($downloadCount >= 50) {
                    $user->awardBadge('mindset-master');
                }
            }
        });

        $this->info("Done! Badges awarded based on existing data.");
    }
}
