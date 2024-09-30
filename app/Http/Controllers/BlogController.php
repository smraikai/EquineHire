<?php

namespace App\Http\Controllers;

use Contentful\Delivery\Client as ContentfulClient;
use Contentful\Delivery\Query;
use App\Http\Controllers\SEOController;
use Contentful\RichText\Renderer;


class BlogController extends Controller
{
    public function index()
    {
        $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
        $query = new Query();
        $query->setContentType('blogPost');
        $entries = $client->getEntries($query);
        return view('blog.index', ['posts' => $entries]);
    }

    public function show($slug)
    {
        $client = new ContentfulClient(env('CONTENTFUL_ACCESS_TOKEN'), env('CONTENTFUL_SPACE_ID'));
        $query = new Query();
        $query->setContentType('blogPost')
            ->where('fields.slug', $slug);
        $entries = $client->getEntries($query);

        $renderer = new Renderer();

        if ($entries->count() === 0) {
            abort(404);
        }

        $post = $entries->getItems()[0];

        // Set SEO for the blog post
        $seoController = new SEOController();
        $seoController->setBlogPostSEO($post);

        return view('blog.show', compact('post', 'renderer'));
    }

}
