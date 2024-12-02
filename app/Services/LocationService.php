<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;

class LocationService
{
    /*
    |--------------------------------------------------------------------------
    | Configuration Constants
    |--------------------------------------------------------------------------
    */
    private const SESSION_KEY = 'user_location';
    private const DEFAULT_COUNTRY = 'US';

    private const LOCATIONS = [
        'US' => ['name' => 'United States', 'currency' => 'usd', 'symbol' => '$', 'flag' => '🇺🇸'],
        'GB' => ['name' => 'United Kingdom', 'currency' => 'gbp', 'symbol' => '£', 'flag' => '🇬🇧'],
        'EU' => ['name' => 'European Union', 'currency' => 'eur', 'symbol' => '€', 'flag' => '🇪🇺'],
        'CA' => ['name' => 'Canada', 'currency' => 'cad', 'symbol' => 'C$', 'flag' => '🇨🇦'],
    ];

    /*
    |--------------------------------------------------------------------------
    | Primary Location Management
    |--------------------------------------------------------------------------
    */
    public function setLocation(string $country): void
    {
        $country = strtoupper($country);
        $location = self::LOCATIONS[$country] ?? self::LOCATIONS[self::DEFAULT_COUNTRY];
        $location['country'] = $country;
        $location['flag'] = self::LOCATIONS[$country]['flag'] ?? self::LOCATIONS[self::DEFAULT_COUNTRY]['flag'];

        session([self::SESSION_KEY => $location]);
    }

    public function getLocation(): array
    {
        $defaultLocation = self::LOCATIONS[self::DEFAULT_COUNTRY];
        $defaultLocation['country'] = self::DEFAULT_COUNTRY;
        return session(self::SESSION_KEY, $defaultLocation);
    }

    public function detectAndSetLocation(?string $ip = null): void
    {
        // Get IP (defaults to current request IP)
        $position = Location::get($ip);

        if ($position) {
            $country = strtoupper($position->countryCode);
            // Only set if it's a supported country, otherwise use default
            if (isset(self::LOCATIONS[$country])) {
                $this->setLocation($country);
            } else {
                $this->setLocation(self::DEFAULT_COUNTRY);
            }
        } else {
            $this->setLocation(self::DEFAULT_COUNTRY);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Location Property Getters
    |--------------------------------------------------------------------------
    */
    public function getFlag(): string
    {
        $location = $this->getLocation();
        return $location['flag'] ?? '🏳️';  // Returns a neutral flag as fallback
    }

    public function getCurrency(): string
    {
        return $this->getLocation()['currency'];
    }

    public function getDisplayName(): string
    {
        return $this->getLocation()['name'];
    }

    public function getCurrencySymbol(): string
    {
        return $this->getLocation()['symbol'];
    }
}