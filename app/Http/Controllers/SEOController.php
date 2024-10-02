<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\JobListing;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Contentful\Delivery\Resource\Entry;
use Contentful\RichText\Renderer;

use Illuminate\Support\Facades\Log;

class SEOController extends Controller
{
    public function setJobListingSEO(JobListing $job_listing)
    {
        $title = "{$job_listing->title} at {$job_listing->employer->name}";
        $description = substr(strip_tags($job_listing->description), 0, 160);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('article:published_time', $job_listing->created_at->toW3CString(), 'property');
        SEOMeta::addMeta('article:section', $job_listing->category->name, 'property');
        SEOMeta::addKeyword([$job_listing->job_type, $job_listing->city, $job_listing->state]);

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(route('jobs.show', [$job_listing->slug, $job_listing->id]));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'en_US');
        OpenGraph::addProperty('site_name', config('app.name'));

        if ($job_listing->employer->logo) {
            OpenGraph::addImage($this->getS3Url($job_listing->employer->logo));
        }

        $this->setJobListingSchema($job_listing);
    }

    public function setEmployerSEO(Employer $employer)
    {
        $title = "{$employer->name} - Company Profile";
        $description = substr(strip_tags($employer->description), 0, 160);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('profile:username', $employer->name, 'property');

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(route('employers.show', $employer));
        OpenGraph::addProperty('type', 'profile');
        OpenGraph::addProperty('profile:username', $employer->name);
        OpenGraph::addProperty('locale', 'en_US');
        OpenGraph::addProperty('site_name', config('app.name'));

        if ($employer->logo) {
            OpenGraph::addImage($this->getS3Url($employer->logo));
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl(route('employers.show', $employer));

        $this->setEmployerSchema($employer);

    }

    public function setBlogPostSEO(Entry $post)
    {
        $renderer = new Renderer();
        $title = ($post->get('metaTitle') ?? $post->get('title'));
        $description = $post->get('metaDescription') ??
            substr(strip_tags($renderer->render($post->get('body'))), 0, 160);

        SEOMeta::setTitle($title);
        SEOMeta::setDescription($description);
        SEOMeta::addMeta('article:published_time', $post->getSystemProperties()->getCreatedAt()->format('c'), 'property');

        OpenGraph::setTitle($title);
        OpenGraph::setDescription($description);
        OpenGraph::setUrl(route('blog.show', $post->get('slug')));
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'en_US');
        OpenGraph::addProperty('site_name', config('app.name'));

        if ($post->has('featuredImage')) {
            OpenGraph::addImage($post->get('featuredImage')->getFile()->getUrl());
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl(route('blog.show', $post->get('slug')));

        $this->setBlogPostSchema($post);

    }

    ////////////////////////////////////////////////////////
    // Schema
    ////////////////////////////////////////////////////////

    private function setJobListingSchema(JobListing $job_listing)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'JobPosting',
            'title' => "{$job_listing->title} at {$job_listing->employer->name}",
            'description' => substr(strip_tags($job_listing->description), 0, 160),
            'datePosted' => $job_listing->created_at->toW3CString(),
            'validThrough' => $job_listing->created_at->addDays(30)->toW3CString(),
            'hiringOrganization' => [
                '@type' => 'Organization',
                'name' => $job_listing->employer->name,
                'sameAs' => $job_listing->employer->website,
                'logo' => $job_listing->employer->logo ? $this->getS3Url($job_listing->employer->logo) : null,
            ],
            'jobLocation' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $job_listing->city,
                    'addressRegion' => $job_listing->state,
                    'addressCountry' => 'US',
                ],
            ],
            'employmentType' => $this->mapJobType($job_listing->job_type),
            'jobLocationType' => $job_listing->remote_position ? 'REMOTE' : 'ONSITE',
            'experienceRequirements' => $job_listing->experience_required,
            'applicantLocationRequirements' => [
                '@type' => 'Country',
                'name' => 'United States',
            ],
        ];

        if ($job_listing->salary_type === 'hourly') {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'USD',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'value' => $job_listing->hourly_rate_min,
                    'unitText' => 'HOUR',
                ],
            ];
        } elseif ($job_listing->salary_type === 'salary') {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'USD',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'value' => $job_listing->salary_range_min,
                    'unitText' => 'YEAR',
                ],
            ];
        } else {
            $schema['baseSalary'] = [
                '@type' => 'MonetaryAmount',
                'currency' => 'USD',
                'value' => [
                    '@type' => 'QuantitativeValue',
                    'value' => 0,
                    'unitText' => 'YEAR',
                ],
            ];
        }

        $this->outputSchema($schema);
    }

    private function setEmployerSchema(Employer $employer)
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $employer->name,
            'description' => substr(strip_tags($employer->description), 0, 160),
            'url' => $employer->website,
            'logo' => $employer->logo ? $this->getS3Url($employer->logo) : null,
            'location' => [
                '@type' => 'Place',
                'address' => [
                    '@type' => 'PostalAddress',
                    'addressLocality' => $employer->city,
                    'addressRegion' => $employer->state,
                ],
            ],
        ];

        $this->outputSchema($schema);
    }

    private function setBlogPostSchema(Entry $post)
    {
        $renderer = new Renderer();
        $description = $post->get('metaDescription') ??
            substr(strip_tags($renderer->render($post->get('body'))), 0, 160);

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $post->get('title'),
            'description' => $description,
            'datePublished' => $post->getSystemProperties()->getCreatedAt()->format('c'),
            'dateModified' => $post->getSystemProperties()->getUpdatedAt()->format('c'),
            'author' => [
                '@type' => 'Organization',
                'name' => 'EquineHire',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'EquineHire',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://equinehire-static-assets.s3.amazonaws.com/favicon.jpg',
                ],
            ],
        ];

        if ($post->has('featuredImage')) {
            $schema['image'] = $post->get('featuredImage')->getFile()->getUrl();
        }

        $this->outputSchema($schema);
    }


    ////////////////////////////////////////////////////////
    // Helpers
    ////////////////////////////////////////////////////////
    private function outputSchema($schema)
    {
        $jsonLd = json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        echo '<script type="application/ld+json">' . $jsonLd . '</script>';
    }

    private function mapJobType($jobType)
    {
        $mapping = [
            'full-time' => 'FULL_TIME',
            'part-time' => 'PART_TIME',
            'contract' => 'CONTRACTOR',
            'temp' => 'TEMPORARY',
            'freelance' => 'FREELANCE',
            'working-student' => 'WORKING_STUDENT',
            'internship' => 'INTERN',
            'externship' => 'EXTERNSHIP',
            'seasonal' => 'SEASONAL',
        ];

        return $mapping[strtolower($jobType)] ?? $jobType;
    }
    private function getS3Url($path)
    {
        $baseUrl = rtrim(config('filesystems.disks.s3.url'), '/');
        $path = ltrim($path, '/');
        return $baseUrl . '/' . $path;
    }
}