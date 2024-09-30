<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use League\Csv\Reader;
use League\Csv\Statement;
use App\Models\JobListing;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class GenerateJobRedirects extends Command
{
    protected $signature = 'jobs:generate-redirects';
    protected $description = 'Generate a redirect list based on CSV and database job listings';

    public function handle()
    {
        $csvPath = public_path('jobs.csv');
        $redirects = [];

        // Read CSV
        $csv = Reader::createFromPath($csvPath, 'r');
        $csv->setHeaderOffset(0);
        $records = Statement::create()->process($csv);

        // Process CSV records
        foreach ($records as $record) {
            $oldSlug = $record['Slug']; // Use the 'Slug' column from CSV for old URL
            $newJob = $this->findMatchingJob($record);

            if ($newJob) {
                $redirects[] = $this->formatRedirect($oldSlug, $newJob->slug, $newJob->id);
            } else {
                $this->warn("No match found for job: {$record['Title']}");
            }
        }

        // Save redirects to file
        $this->saveRedirects($redirects);

        $this->info('Redirect list generated successfully.');
    }

    private function findMatchingJob($record)
    {
        $postModifiedDate = Carbon::parse($record['Post Modified Date']);

        return JobListing::where('title', $record['Title'])
            ->where(function ($query) use ($postModifiedDate) {
                $query->whereDate('created_at', $postModifiedDate->toDateString())
                    ->orWhereDate('updated_at', $postModifiedDate->toDateString());
            })
            ->first();
    }

    private function formatRedirect($oldSlug, $newSlug, $id)
    {
        return "Redirect 301 /jobs/{$oldSlug} /jobs/{$newSlug}-{$id}";
    }

    private function saveRedirects($redirects)
    {
        $content = implode("\n", $redirects);
        Storage::disk('local')->put('job_redirects.txt', $content);
    }
}