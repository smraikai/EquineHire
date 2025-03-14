<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DeactivateJobListingsWithoutSubscription extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'joblisting:deactivate-without-subscription {--dry-run : Show what would be deactivated without making changes}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deactivate all job listings for users without active subscriptions';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting job listing cleanup...');

        $isDryRun = $this->option('dry-run');
        if ($isDryRun) {
            $this->warn('DRY RUN MODE: No changes will be made');
        }

        // Get users without active subscriptions
        $users = User::whereDoesntHave('subscriptions', function ($query) {
            $query->where('stripe_status', 'active');
        })
            ->has('jobListings')
            ->with([
                'jobListings' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        $this->info("Found {$users->count()} users without active subscriptions who have job listings");

        $totalDeactivated = 0;
        $affectedUsers = 0;

        foreach ($users as $user) {
            $activeListings = $user->jobListings->where('is_active', true);

            if ($activeListings->isEmpty()) {
                continue;
            }

            $this->info("User ID: {$user->id} | Email: {$user->email} | Active listings: {$activeListings->count()}");
            $affectedUsers++;

            if (!$isDryRun) {
                foreach ($activeListings as $listing) {
                    $this->line("  - Deactivating listing ID: {$listing->id} | Title: {$listing->title}");
                    $listing->archive();
                    $totalDeactivated++;
                }
            } else {
                $totalDeactivated += $activeListings->count();
                foreach ($activeListings as $listing) {
                    $this->line("  - Would deactivate ID: {$listing->id} | Title: {$listing->title}");
                }
            }
        }

        $actionText = $isDryRun ? 'Would deactivate' : 'Deactivated';
        $this->info("{$actionText} {$totalDeactivated} job listings from {$affectedUsers} users");

        if (!$isDryRun && $totalDeactivated > 0) {
            Log::info("Batch deactivated {$totalDeactivated} job listings from {$affectedUsers} users without active subscriptions");
        }

        return Command::SUCCESS;
    }
}