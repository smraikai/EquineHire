<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Business;
use Contentful\Delivery\Client as ContentfulClient;
use Contentful\Delivery\Query;

class GenerateSitemap extends Command
{
    protected $signature = 'app:generate-sitemap';
    protected $description = 'Generate sitemaps for static pages, businesses, and blog posts';

    public function handle()
    {
        // Create sitemap for static pages
        $staticSitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/our-story')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/explore')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/subscription/plans')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        $staticSitemap->writeToFile(public_path('sitemap-static.xml'));

        // Create sitemap for businesses
        $businessSitemap = Sitemap::create();

        $businesses = Business::all();
        foreach ($businesses as $business) {
            $url = $business->state_slug && $business->slug
                ? route('jobs.index.show', ['state_slug' => $business->state_slug, 'slug' => $business->slug, 'id' => $business->id])
                : null;

            if ($url) {
                $businessSitemap->add(Url::create($url)
                    ->setLastModificationDate($business->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                    ->setPriority(0.8));
            }
        }

        $businessSitemap->writeToFile(public_path('sitemap-businesses.xml'));

        // Create sitemap for blog posts
        $blogSitemap = Sitemap::create();

        $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
        $query = new Query();
        $query->setContentType('blogPost');
        $entries = $client->getEntries($query);

        foreach ($entries as $entry) {
            $blogSitemap->add(Url::create("/blog/{$entry->get('slug')}")
                ->setLastModificationDate($entry->getSystemProperties()->getUpdatedAt())
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                ->setPriority(0.7));
        }

        $blogSitemap->writeToFile(public_path('sitemap-blog.xml'));

        // Create index sitemap
        $indexSitemap = Sitemap::create()
            ->add('/sitemap-static.xml')
            ->add('/sitemap-businesses.xml')
            ->add('/sitemap-blog.xml');

        $indexSitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemaps generated successfully: static pages, businesses, blog posts, and index sitemap.');
    }
}