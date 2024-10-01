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
        'price' => 50,
        'interval' => MONTH,
        'features' => array_merge(['1 Concurrent Job Post'], $commonFeatures),
    ],
    'pro' => [
        'name' => 'Pro Plan',
        'price' => 120,
        'interval' => QUARTER,
        'features' => array_merge(['Up to 5 Concurrent Job Posts'], $commonFeatures),
    ],
    'unlimited' => [
        'name' => 'Unlimited Plan',
        'price' => 400,
        'interval' => YEAR,
        'features' => array_merge(['Unlimited Job Posts'], $commonFeatures),
    ],
];

return [
    'plans' => [
        'local' => [
            'basic' => array_merge($planStructure['basic'], ['id' => 'price_1Q1VoTJ1n13AUOzGHcpzCML2']),
            'pro' => array_merge($planStructure['pro'], ['id' => 'price_1Q1VtQJ1n13AUOzGPkYoZaPr']),
            'unlimited' => array_merge($planStructure['unlimited'], ['id' => 'price_1Q1VtkJ1n13AUOzGGouum0z4']),
        ],
        'production' => [
            'basic' => array_merge($planStructure['basic'], ['id' => 'price_1Q4tNUJ1n13AUOzGuRB5WZ27']),
            'pro' => array_merge($planStructure['pro'], ['id' => 'price_1Q4tNSJ1n13AUOzGmjvb0Bps']),
            'unlimited' => array_merge($planStructure['unlimited'], ['id' => 'price_1Q4tNRJ1n13AUOzGjSUIaim4']),
        ],
    ],
];