<?php

namespace App\Services;

use App\Models\JobListing;

class SeoService
{
    public function generateMetaTitle(string $title, string $companyName, ?string $location): string
    {
        $locationPart = $location ? " – {$location}" : "";
        return "{$title} at {$companyName}{$locationPart} | EquineHire";
    }

    public function generateMetaDescription(string $description): string
    {
        // Strip any HTML tags and trim to 160 characters
        $cleanDescription = strip_tags($description);
        return \Str::limit($cleanDescription, 160);
    }
}