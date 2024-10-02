<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\JobListing;
use App\Models\Employer;
use Contentful\Delivery\Client as ContentfulClient;
use Contentful\Delivery\Query;
use App\Models\JobListingCategory;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Generate sitemaps for static pages, jobs, employers, and blog posts';

    public function handle()
    {
        $this->generateStaticSitemap();
        $this->generateJobSitemap();
        $this->generateEmployerSitemap();
        $this->generateBlogSitemap();
        $this->generateCategorySitemap(); // Add this line
        $this->generateIndexSitemap();

        $this->info('Sitemaps generated successfully: static pages, jobs, employers, blog posts, and index sitemap.');
    }

    private function generateStaticSitemap()
    {
        $staticSitemap = Sitemap::create();

        $staticRoutes = [
            '/' => ['priority' => 1.0, 'frequency' => Url::CHANGE_FREQUENCY_WEEKLY],
            '/privacy-policy' => ['priority' => 0.5, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            '/terms-of-service' => ['priority' => 0.5, 'frequency' => Url::CHANGE_FREQUENCY_YEARLY],
            '/blog' => ['priority' => 0.9, 'frequency' => Url::CHANGE_FREQUENCY_DAILY],
        ];

        foreach ($staticRoutes as $route => $settings) {
            $staticSitemap->add(
                Url::create($route)
                    ->setPriority($settings['priority'])
                    ->setChangeFrequency($settings['frequency'])
            );
        }

        $staticSitemap->writeToFile(public_path('sitemap-static.xml'));
    }

    private function generateJobSitemap()
    {
        $jobSitemap = Sitemap::create();

        JobListing::all()->each(function ($job) use ($jobSitemap) {
            $jobSitemap->add(
                Url::create(route('jobs.show', ['job_slug' => $job->slug, 'id' => $job->id]))
                    ->setLastModificationDate($job->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        $jobSitemap->writeToFile(public_path('sitemap-jobs.xml'));
    }

    private function generateEmployerSitemap()
    {
        $employerSitemap = Sitemap::create();

        Employer::all()->each(function ($employer) use ($employerSitemap) {
            $employerSitemap->add(
                Url::create(route('employers.show', $employer))
                    ->setLastModificationDate($employer->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.7)
            );
        });

        $employerSitemap->writeToFile(public_path('sitemap-employers.xml'));
    }

    private function generateBlogSitemap()
    {
        $blogSitemap = Sitemap::create();

        $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
        $query = new Query();
        $query->setContentType('blogPost');
        $entries = $client->getEntries($query);

        foreach ($entries as $entry) {
            $blogSitemap->add(
                Url::create(route('blog.show', ['slug' => $entry->get('slug')]))
                    ->setLastModificationDate($entry->getSystemProperties()->getUpdatedAt())
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.7)
            );
        }

        $blogSitemap->writeToFile(public_path('sitemap-blog.xml'));
    }

    private function generateCategorySitemap()
    {
        $categorySitemap = Sitemap::create();

        JobListingCategory::all()->each(function ($category) use ($categorySitemap) {
            $categorySitemap->add(
                Url::create(route('jobs.category', $category->slug))
                    ->setLastModificationDate($category->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8)
            );
        });

        $categorySitemap->writeToFile(public_path('sitemap-categories.xml'));
    }

    private function generateIndexSitemap()
    {
        $baseUrl = config('app.url');

        $indexSitemap = Sitemap::create()
            ->add(Url::create($baseUrl . '/sitemap-static.xml'))
            ->add(Url::create($baseUrl . '/sitemap-jobs.xml'))
            ->add(Url::create($baseUrl . '/sitemap-employers.xml'))
            ->add(Url::create($baseUrl . '/sitemap-blog.xml'))
            ->add(Url::create($baseUrl . '/sitemap-categories.xml')); // Add this line

        $indexSitemap->writeToFile(public_path('sitemap.xml'));
    }


}