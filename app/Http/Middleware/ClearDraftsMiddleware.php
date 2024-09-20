<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ClearDraftsMiddleware
{
    public function handle($request, Closure $next)
    {
        $business = $request->route('business');

        if ($business) {
            $businessId = $business->id;

            // Clear draft entries from business_photos_drafts table
            DB::table('business_photos_drafts')->where('business_id', $businessId)->delete();

            // Clear 'logo' and 'featured_image' in business_image_drafts table instead of deleting entries
            DB::table('business_image_drafts')
                ->where('business_id', $businessId)
                ->update(['logo' => null, 'featured_image' => null]);
        }

        return $next($request);
    }
}
