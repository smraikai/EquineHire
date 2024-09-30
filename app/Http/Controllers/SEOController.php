<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\JobListing;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;
use Contentful\Delivery\Resource\Entry;
use Contentful\RichText\Renderer;

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
            OpenGraph::addImage(asset('storage/' . $job_listing->employer->logo));
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl(route('jobs.show', [$job_listing->slug, $job_listing->id]));

        JsonLd::setType('JobPosting');
        JsonLd::setTitle($title);
        JsonLd::setDescription($description);
        JsonLd::addValue('datePosted', $job_listing->created_at->toW3CString());
        JsonLd::addValue('hiringOrganization', [
            '@type' => 'Organization',
            'name' => $job_listing->employer->name,
            'sameAs' => $job_listing->employer->website,
        ]);
        JsonLd::addValue('jobLocation', [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $job_listing->city,
                'addressRegion' => $job_listing->state,
            ],
        ]);
        JsonLd::addValue('employmentType', $job_listing->job_type);
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
            OpenGraph::addImage(asset('storage/' . $employer->logo));
        }

        TwitterCard::setTitle($title);
        TwitterCard::setDescription($description);
        TwitterCard::setUrl(route('employers.show', $employer));

        JsonLd::setType('Organization');
        JsonLd::setTitle($employer->name);
        JsonLd::setDescription($description);
        JsonLd::addValue('url', $employer->website);
        JsonLd::addValue('logo', asset('storage/' . $employer->logo));
        JsonLd::addValue('location', [
            '@type' => 'Place',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $employer->city,
                'addressRegion' => $employer->state,
            ],
        ]);
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

        JsonLd::setType('Article');
        JsonLd::setTitle($post->get('title'));
        JsonLd::setDescription($description);
        JsonLd::addValue('datePublished', $post->getSystemProperties()->getCreatedAt()->format('c'));
        JsonLd::addValue('dateModified', $post->getSystemProperties()->getUpdatedAt()->format('c'));
        JsonLd::addValue('author', [
            '@type' => 'Organization',
            'name' => 'EquineHire',
        ]);
        JsonLd::addValue('publisher', [
            '@type' => 'Organization',
            'name' => 'EquineHire',
            'logo' => [
                '@type' => 'ImageObject',
                'url' => 'https://equinehire-static-assets.s3.amazonaws.com/favicon.jpg',
            ],
        ]);

        if ($post->has('featuredImage')) {
            JsonLd::addValue('image', $post->get('featuredImage')->getFile()->getUrl());
        }
    }
}