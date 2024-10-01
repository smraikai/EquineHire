<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobListing;

class RemoveExpiredJobBoosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:remove-expired-boosts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        JobListing::where('is_boosted', true)
            ->where('boost_expires_at', '<=', now())
            ->update(['is_boosted' => false, 'boost_expires_at' => null]);
    }
}
