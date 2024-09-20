<?php

namespace App\Http\Controllers;

use Contentful\Delivery\Client as ContentfulClient;
use Contentful\Delivery\Query;


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

        if ($entries->count() === 0) {
            abort(404);
        }

        $entry = $entries->getItems()[0];
        return view('blog.show', [
            'post' => $entry,
            'metaTitle' => $entry->get('metaTitle'),
            'metaDescription' => $entry->get('metaDescription'),
        ]);
    }


}
