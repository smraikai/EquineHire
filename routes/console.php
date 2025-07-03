<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\JobListing;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('app:generate-sitemap')->daily();
Schedule::command('jobs:remove-expired-boosts')->daily();

// Daily cleanup: Archive jobs for users without active subscriptions
Schedule::call(function () {
    $orphanedJobs = App\Models\JobListing::where('is_active', true)
        ->with('user.subscriptions')
        ->get()
        ->filter(function($job) {
            return !$job->user || !$job->user->hasActiveSubscription();
        });

    if ($orphanedJobs->count() > 0) {
        $orphanedJobs->each(function($job) {
            $job->archive();
        });
        Log::info("Daily cleanup: Archived {$orphanedJobs->count()} orphaned jobs");
    } else {
        Log::info('Daily cleanup: No orphaned jobs found');
    }
})->dailyAt('23:30');

// Daily Algolia sync: Re-index all searchable jobs (runs after cleanup)
Schedule::call(function () {
    $jobs = App\Models\JobListing::all()->filter(function ($job) {
        return $job->shouldBeSearchable();
    });
    $jobs->searchable();
    Log::info('Daily Algolia sync completed: '.$jobs->count().' jobs indexed');
})->dailyAt('23:45');