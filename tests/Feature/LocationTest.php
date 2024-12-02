<?php

namespace Tests\Feature;

use Tests\TestCase;
use Stevebauman\Location\Facades\Location;
use Stevebauman\Location\Position;

class LocationTest extends TestCase
{
    public function test_location_detection_works()
    {
        // Test with a known US IP
        $position = Location::get('8.8.8.8'); // Google's DNS IP
        $this->assertEquals('US', $position->countryCode);

        // Test with fake location
        Location::fake([
            '127.0.0.1' => Position::make([
                'countryName' => 'United Kingdom',
                'countryCode' => 'GB',
            ])
        ]);

        $position = Location::get('127.0.0.1');
        $this->assertEquals('GB', $position->countryCode);
    }
}
