<?php

namespace App\Console\Commands;

use App\Models\JobListing;
use Illuminate\Console\Command;

class UpdateJobListingCoordinates extends Command
{
    protected $signature = 'joblisting:update-coordinates';
    protected $description = 'Update job listing coordinates based on state';

    // US States coordinates (approximate center points)
    protected const STATE_COORDINATES = [
        'Alabama' => ['lat' => 32.7794, 'lng' => -86.8287],
        'Alaska' => ['lat' => 64.0685, 'lng' => -152.2782],
        'Arizona' => ['lat' => 34.2744, 'lng' => -111.6602],
        'Arkansas' => ['lat' => 34.8938, 'lng' => -92.4426],
        'California' => ['lat' => 37.1841, 'lng' => -119.4696],
        'Colorado' => ['lat' => 38.9972, 'lng' => -105.5478],
        'Connecticut' => ['lat' => 41.6219, 'lng' => -72.7273],
        'Delaware' => ['lat' => 38.9896, 'lng' => -75.5050],
        'Florida' => ['lat' => 28.6305, 'lng' => -82.4497],
        'Georgia' => ['lat' => 32.6415, 'lng' => -83.4426],
        'Hawaii' => ['lat' => 20.2927, 'lng' => -156.3737],
        'Idaho' => ['lat' => 44.3509, 'lng' => -114.6130],
        'Illinois' => ['lat' => 40.0417, 'lng' => -89.1965],
        'Indiana' => ['lat' => 39.8942, 'lng' => -86.2816],
        'Iowa' => ['lat' => 42.0751, 'lng' => -93.4960],
        'Kansas' => ['lat' => 38.4937, 'lng' => -98.3804],
        'Kentucky' => ['lat' => 37.5347, 'lng' => -85.3021],
        'Louisiana' => ['lat' => 31.0689, 'lng' => -91.9968],
        'Maine' => ['lat' => 45.3695, 'lng' => -69.2428],
        'Maryland' => ['lat' => 39.0550, 'lng' => -76.7909],
        'Massachusetts' => ['lat' => 42.2596, 'lng' => -71.8083],
        'Michigan' => ['lat' => 44.3467, 'lng' => -85.4102],
        'Minnesota' => ['lat' => 46.2807, 'lng' => -94.3053],
        'Mississippi' => ['lat' => 32.7364, 'lng' => -89.6678],
        'Missouri' => ['lat' => 38.3566, 'lng' => -92.4580],
        'Montana' => ['lat' => 47.0527, 'lng' => -109.6333],
        'Nebraska' => ['lat' => 41.5378, 'lng' => -99.7951],
        'Nevada' => ['lat' => 39.3289, 'lng' => -116.6312],
        'New Hampshire' => ['lat' => 43.6805, 'lng' => -71.5811],
        'New Jersey' => ['lat' => 40.1907, 'lng' => -74.6728],
        'New Mexico' => ['lat' => 34.4071, 'lng' => -106.1126],
        'New York' => ['lat' => 42.9538, 'lng' => -75.5268],
        'North Carolina' => ['lat' => 35.5557, 'lng' => -79.3877],
        'North Dakota' => ['lat' => 47.4501, 'lng' => -100.4659],
        'Ohio' => ['lat' => 40.2862, 'lng' => -82.7937],
        'Oklahoma' => ['lat' => 35.5889, 'lng' => -97.4943],
        'Oregon' => ['lat' => 43.9336, 'lng' => -120.5583],
        'Pennsylvania' => ['lat' => 40.8781, 'lng' => -77.7996],
        'Rhode Island' => ['lat' => 41.6762, 'lng' => -71.5562],
        'South Carolina' => ['lat' => 33.9169, 'lng' => -80.8964],
        'South Dakota' => ['lat' => 44.4443, 'lng' => -100.2263],
        'Tennessee' => ['lat' => 35.8580, 'lng' => -86.3505],
        'Texas' => ['lat' => 31.4757, 'lng' => -99.3312],
        'Utah' => ['lat' => 39.3055, 'lng' => -111.6703],
        'Vermont' => ['lat' => 44.0687, 'lng' => -72.6658],
        'Virginia' => ['lat' => 37.5215, 'lng' => -78.8537],
        'Washington' => ['lat' => 47.3826, 'lng' => -120.4472],
        'West Virginia' => ['lat' => 38.6409, 'lng' => -80.6227],
        'Wisconsin' => ['lat' => 44.6243, 'lng' => -89.9941],
        'Wyoming' => ['lat' => 42.9957, 'lng' => -107.5512],
    ];

    public function handle()
    {
        // First, let's check total records
        $total = JobListing::count();
        $this->info("Total job listings: {$total}");

        // Check records with null coordinates
        $nullCoords = JobListing::whereNull('latitude')
            ->whereNull('longitude')
            ->count();
        $this->info("Listings with null coordinates: {$nullCoords}");

        // Check records with states
        $withState = JobListing::whereNotNull('state')->count();
        $this->info("Listings with states: {$withState}");

        // Check US records
        $usRecords = JobListing::where('country', 'United States')->count();
        $this->info("US listings: {$usRecords}");

        // Now the full query - only check for US listings
        $jobListings = JobListing::where('country', 'United States')
            ->get();

        $this->info("Found {$jobListings->count()} job listings to process");

        $count = 0;
        foreach ($jobListings as $listing) {
            $state = ucwords(strtolower(trim($listing->state)));

            $this->info("Processing listing ID: {$listing->id}, State: {$state}");

            if (isset(self::STATE_COORDINATES[$state])) {
                try {
                    $result = $listing->update([
                        'latitude' => self::STATE_COORDINATES[$state]['lat'],
                        'longitude' => self::STATE_COORDINATES[$state]['lng'],
                    ]);

                    if ($result) {
                        $count++;
                        $this->info("Successfully updated listing ID: {$listing->id}");
                    } else {
                        $this->error("Failed to update listing ID: {$listing->id}");
                    }
                } catch (\Exception $e) {
                    $this->error("Error updating listing ID: {$listing->id}: " . $e->getMessage());
                }
            } else {
                $this->warn("Could not find coordinates for state: {$state}");
            }
        }

        $this->info("Updated coordinates for {$count} job listings.");
    }
}