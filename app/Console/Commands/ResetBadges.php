<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ResetBadges extends Command
{
    protected $signature = 'badges:reset';
    protected $description = 'Remove all user badges';

    public function handle()
    {
        $count = DB::table('badge_user')->count();
        DB::table('badge_user')->truncate();

        $this->info("All {$count} user badges have been reset.");
    }
}
