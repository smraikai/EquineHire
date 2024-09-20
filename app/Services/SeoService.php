<?php

namespace App\Services;

class SeoService
{
    public function generateMetaTitle(string $businessName, string $city, string $state): string
    {
        return "{$businessName} – {$city}, {$state} | EquineHire";
    }

    public function generateMetaDescription(string $description): string
    {
        // Strip any HTML tags and trim to 160 characters
        $cleanDescription = strip_tags($description);
        return \Str::limit($cleanDescription, 160);
    }
}
