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
Schedule::call(function () {
    $jobs = App\Models\JobListing::all()->filter(function ($job) {
        return $job->shouldBeSearchable();
    });
    $jobs->searchable();
    Log::info('Daily Algolia sync completed: '.$jobs->count().' jobs indexed');
})->dailyAt('00:00');