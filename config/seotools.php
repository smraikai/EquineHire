<?php
/**
 * @see https://github.com/artesaos/seotools
 */

return [
    'meta' => [
        /*
         * The default configurations to be used by the meta generator.
         */
        'defaults' => [
            'title' => "EquineHire", // set false to total remove
            'titleBefore' => false, // Put defaults.title before page title, like 'It's Over 9000! - Dashboard'
            'description' => 'Find equine jobs near you on EquineHire.', // set false to total remove
            'separator' => ' - ',
            'keywords' => [],
            'canonical' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'robots' => false, // Set to 'all', 'none' or any combination of index/noindex and follow/nofollow
        ],
        /*
         * Webmaster tags are always added.
         */
        'webmaster_tags' => [
            'google' => null,
            'bing' => null,
            'alexa' => null,
            'pinterest' => null,
            'yandex' => null,
            'norton' => null,
        ],

        'add_notranslate_class' => false,
    ],
    'opengraph' => [
        /*
         * The default configurations to be used by the opengraph generator.
         */
        'defaults' => [
            'title' => 'EquineHire', // set false to total remove
            'description' => 'Find equine jobs near you on EquineHire.', // set false to total remove
            'url' => 'current', // Set null for using Url::current(), set false to total remove
            'type' => 'website',
            'site_name' => 'EquineHire',
            'images' => ['https://equinehire-static-assets.s3.amazonaws.com/socialshare.jpg'],
        ],
    ],
    'twitter' => [
        /*
         * The default values to be used by the twitter cards generator.
         */
        'defaults' => [
            'card' => 'summary_large_image',
            'site' => '@EquineHire',
        ],
    ],
    'json-ld' => [
        /*
         * The default configurations to be used by the json-ld generator.
         */
        'defaults' => [
            'title' => 'EquineHire', // set false to total remove
            'description' => 'Find equine services near you on EquineHire, the best Equine Job', // set false to total remove
            'url' => 'current', // Set to null or 'full' to use Url::full(), set to 'current' to use Url::current(), set false to total remove
            'type' => 'WebPage',
            'images' => ['https://equinehire-static-assets.s3.amazonaws.com/socialshare.jpg'],
        ],
    ],
];