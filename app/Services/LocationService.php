<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;
use Stevebauman\Location\Facades\Location;
use Locale;

class LocationService
{
    /*
    |--------------------------------------------------------------------------
    | Configuration Constants
    |--------------------------------------------------------------------------
    */
    private const SESSION_KEY = 'user_location';
    private const DEFAULT_COUNTRY = 'US';
    private const EU_BASE = ['currency' => 'eur', 'symbol' => '€'];

    private const LOCATIONS = [
        // Non-EU Countries
        'US' => ['name' => 'United States', 'currency' => 'usd', 'symbol' => '$', 'flag' => '🇺🇸'],
        'GB' => ['name' => 'United Kingdom', 'currency' => 'gbp', 'symbol' => '£', 'flag' => '🇬🇧'],
        'CA' => ['name' => 'Canada', 'currency' => 'cad', 'symbol' => 'C$', 'flag' => '🇨🇦'],

        // EU Countries with base template
        'AT' => ['name' => 'Austria'] + self::EU_BASE,
        'BE' => ['name' => 'Belgium'] + self::EU_BASE,
        'BG' => ['name' => 'Bulgaria'] + self::EU_BASE,
        'HR' => ['name' => 'Croatia'] + self::EU_BASE,
        'CY' => ['name' => 'Cyprus'] + self::EU_BASE,
        'CZ' => ['name' => 'Czech Republic'] + self::EU_BASE,
        'DK' => ['name' => 'Denmark'] + self::EU_BASE,
        'EE' => ['name' => 'Estonia'] + self::EU_BASE,
        'FI' => ['name' => 'Finland'] + self::EU_BASE,
        'FR' => ['name' => 'France'] + self::EU_BASE,
        'DE' => ['name' => 'Germany'] + self::EU_BASE,
        'GR' => ['name' => 'Greece'] + self::EU_BASE,
        'HU' => ['name' => 'Hungary'] + self::EU_BASE,
        'IE' => ['name' => 'Ireland'] + self::EU_BASE,
        'IT' => ['name' => 'Italy'] + self::EU_BASE,
        'LV' => ['name' => 'Latvia'] + self::EU_BASE,
        'LT' => ['name' => 'Lithuania'] + self::EU_BASE,
        'LU' => ['name' => 'Luxembourg'] + self::EU_BASE,
        'MT' => ['name' => 'Malta'] + self::EU_BASE,
        'NL' => ['name' => 'Netherlands'] + self::EU_BASE,
        'PL' => ['name' => 'Poland'] + self::EU_BASE,
        'PT' => ['name' => 'Portugal'] + self::EU_BASE,
        'RO' => ['name' => 'Romania'] + self::EU_BASE,
        'SK' => ['name' => 'Slovakia'] + self::EU_BASE,
        'SI' => ['name' => 'Slovenia'] + self::EU_BASE,
        'ES' => ['name' => 'Spain'] + self::EU_BASE,
        'SE' => ['name' => 'Sweden'] + self::EU_BASE,
    ];

    /*
    |--------------------------------------------------------------------------
    | Primary Location Management
    |--------------------------------------------------------------------------
    */
    public function setLocation(string $country): void
    {
        $country = strtoupper($country);

        // Check if country is in EU but not specifically defined
        if (in_array($country, array_keys(self::LOCATIONS)) && !isset(self::LOCATIONS[$country])) {
            // Create a dynamic EU country entry
            $location = [
                'name' => $this->getCountryName($country),
                'currency' => 'eur',
                'symbol' => '€',
                'country' => $country,
                'flag' => $this->getCountryFlag($country)
            ];
        } else {
            $location = self::LOCATIONS[$country] ?? self::LOCATIONS[self::DEFAULT_COUNTRY];
            $location['country'] = $country;
            $location['flag'] = self::LOCATIONS[$country]['flag'] ?? self::LOCATIONS[self::DEFAULT_COUNTRY]['flag'];
        }

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

    public function getCountryFlag(string $country): string
    {
        // Convert country code to regional indicator symbols
        $flag = mb_convert_encoding(
            '&#' . (127462 + ord($country[0]) - ord('A')) . ';' .
            '&#' . (127462 + ord($country[1]) - ord('A')) . ';',
            'UTF-8',
            'HTML-ENTITIES'
        );
        return $flag ?: '🏳️';
    }

    private function getCountryName(string $country): string
    {
        // You might want to use a proper country names package here
        // This is just a basic example
        return Locale::getDisplayRegion('-' . $country, 'en') ?: $country;
    }
}