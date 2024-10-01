<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Config;

class PlansComposer
{
    public function compose(View $view)
    {
        $plans = Config::get('subscriptions.plans.' . (app()->environment('production') ? 'production' : 'local'));
        $view->with('plans', $plans);
    }
}