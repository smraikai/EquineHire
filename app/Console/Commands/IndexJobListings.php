<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobListing;
use Algolia\AlgoliaSearch\SearchClient;

class IndexJobListings extends Command
{
    protected $signature = 'algolia:index-job-listings';
    protected $description = 'Index all job listings to Algolia';

    public function handle()
    {
        $this->info('Indexing job listings...');

        // Initialize Algolia client
        $client = SearchClient::create(
            config('services.algolia.app_id'),
            config('services.algolia.secret')
        );

        // Get or create the index
        $index = $client->initIndex('job_listings');

        // Fetch all job listings
        $jobListings = JobListing::all();

        // Prepare the records for Algolia
        $records = $jobListings->map(function ($jobListing) {
            return $jobListing->toSearchableArray();
        })->toArray();

        // Send records to Algolia
        $index->saveObjects($records);

        $this->info('All job listings have been indexed.');
    }
}