<?php

use Stevebauman\Location\Facades\Location;

Route::get('/test-location/{ip?}', function ($ip = null) {
    $position = Location::get($ip ?? request()->ip());
    dd([
        'ip' => $ip ?? request()->ip(),
        'country' => $position?->countryCode,
        'full_data' => $position
    ]);
});