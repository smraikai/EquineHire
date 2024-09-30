<?php

namespace App\Services;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use App\Models\JobListing;

class SeoService
{
    public function setJobListingSeo(JobListing $jobListing): void
    {
        $title = $this->generateMetaTitle(
            $jobListing->title,
            $jobListing->employer->name,
            $jobListing->location
        );
        $description = $this->generateMetaDescription($jobListing->description);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword(['equine', 'job', 'hire', $jobListing->title, $jobListing->employer->name]);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(url()->current());
        OpenGraph::addProperty('type', 'job');
        OpenGraph::addProperty('locale', 'en_US');

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl(url()->current());
    }

    private function generateMetaTitle(string $title, string $employerName, ?string $location): string
    {
        $locationPart = $location ? " – {$location}" : "";
        return "{$title} at {$employerName}{$locationPart} | EquineHire";
    }

    private function generateMetaDescription(string $description): string
    {
        $cleanDescription = strip_tags($description);
        return \Str::limit($cleanDescription, 160);
    }
}