<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Algolia\AlgoliaSearch\SearchClient;

class UpdateAlgoliaRanking extends Command
{
    protected $signature = 'algolia:update-ranking';
    protected $description = 'Update Algolia ranking to prioritize sticky posts';

    public function handle()
    {
        $client = SearchClient::create(
            config('scout.algolia.id'),
            config('scout.algolia.secret')
        );

        $index = $client->initIndex('job_listings');

        $index->setSettings([
            'customRanking' => [
                'desc(sticky_rank)',
                'desc(created_at)'
            ],
        ]);

        $this->info('Algolia ranking updated successfully.');
    }
}