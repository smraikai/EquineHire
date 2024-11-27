<?php

const MONTH = 'month';
const QUARTER = 'quarter';
const YEAR = 'year';

$commonFeatures = [
    'Employer Profile with Images',
    'Dedicated support',
    'Featured in our newsletter',
    'Shared on social media',
    'Cancel Any Time'
];

$planStructure = [
    'basic' => [
        'name' => 'Basic Plan',
        'prices' => [
            'usd' => 50,
            'gbp' => 40,
            'eur' => 45,
            'cad' => 70,
        ],
        'stripe_prices' => [
            'local' => [
                'usd' => 'price_1Q1VoTJ1n13AUOzGHcpzCML2',
                'gbp' => 'price_1QP1vnJ1n13AUOzGhb3sUHWX',
                'eur' => 'price_1QP1vnJ1n13AUOzGDIXRqIFQ',
                'cad' => 'price_1QP1vnJ1n13AUOzGMiY7I6S7',
            ],
            'production' => [
                'usd' => 'price_1Q4tNUJ1n13AUOzGuRB5WZ27',
                'gbp' => 'price_1QPr0TJ1n13AUOzG7FsoDtkX',
                'eur' => 'price_1QPr0sJ1n13AUOzGObklfjLQ',
                'cad' => 'price_1QPr1bJ1n13AUOzGjUmKSZuK',
            ]
        ],
        'interval' => MONTH,
        'features' => array_merge(['1 Concurrent Job Post'], $commonFeatures),
    ],
    'pro' => [
        'name' => 'Pro Plan',
        'prices' => [
            'usd' => 120,
            'gbp' => 95,
            'eur' => 110,
            'cad' => 165,
        ],
        'stripe_prices' => [
            'local' => [
                'usd' => 'price_1Q1VtQJ1n13AUOzGPkYoZaPr',
                'gbp' => 'price_1QPq8TJ1n13AUOzGT4Bb4jSA',
                'eur' => 'price_1QPq8fJ1n13AUOzGZQWSpprQ',
                'cad' => 'price_1QPq8sJ1n13AUOzGJqib9JLv',
            ],
            'production' => [
                'usd' => 'price_1Q4tNSJ1n13AUOzGmjvb0Bps',
                'gbp' => 'price_1QPr7hJ1n13AUOzG1un1yLgQ',
                'eur' => 'price_1QPr7vJ1n13AUOzGtxYzKFHT',
                'cad' => 'price_1QPr8GJ1n13AUOzGK3Ei4Jdi',
            ]
        ],
        'interval' => QUARTER,
        'features' => array_merge(['Up to 5 Concurrent Job Posts'], $commonFeatures),
    ],
    'unlimited' => [
        'name' => 'Unlimited Plan',
        'prices' => [
            'usd' => 400,
            'gbp' => 320,
            'eur' => 370,
            'cad' => 550,
        ],
        'stripe_prices' => [
            'local' => [
                'usd' => 'price_1Q1VtkJ1n13AUOzGGouum0z4',
                'gbp' => 'price_1QPqY9J1n13AUOzGHxM1AL5n',
                'eur' => 'price_1QPqYOJ1n13AUOzGJJiXpJnV',
                'cad' => 'price_1QPqYqJ1n13AUOzGeZLjmXnc',
            ],
            'production' => [
                'usd' => 'price_1Q4tNRJ1n13AUOzGjSUIaim4',
                'gbp' => 'price_1QPrIFJ1n13AUOzGFdS48Qu7',
                'eur' => 'price_1QPrISJ1n13AUOzGa40FMXYn',
                'cad' => 'price_1QPrItJ1n13AUOzGkluquCDJ',
            ]
        ],
        'interval' => YEAR,
        'features' => array_merge(['Unlimited Job Posts'], $commonFeatures),
    ],
];

return [
    'plans' => [
        'local' => [
            'basic' => array_merge($planStructure['basic'], [
                'id' => fn() => $planStructure['basic']['stripe_prices']['local'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
            'pro' => array_merge($planStructure['pro'], [
                'id' => fn() => $planStructure['pro']['stripe_prices']['local'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
            'unlimited' => array_merge($planStructure['unlimited'], [
                'id' => fn() => $planStructure['unlimited']['stripe_prices']['local'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
        ],
        'production' => [
            'basic' => array_merge($planStructure['basic'], [
                'id' => fn() => $planStructure['basic']['stripe_prices']['production'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
            'pro' => array_merge($planStructure['pro'], [
                'id' => fn() => $planStructure['pro']['stripe_prices']['production'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
            'unlimited' => array_merge($planStructure['unlimited'], [
                'id' => fn() => $planStructure['unlimited']['stripe_prices']['production'][app(App\Services\LocationService::class)->getCurrency()]
            ]),
        ],
    ],
];