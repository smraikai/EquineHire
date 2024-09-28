<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $listId = config('services.emailoctopus.list_id');
        $apiKey = config('services.emailoctopus.api_key');

        try {
            $response = Http::post("https://emailoctopus.com/api/1.6/lists/{$listId}/contacts", [
                'api_key' => $apiKey,
                'email_address' => $request->email,
                'status' => 'SUBSCRIBED'
            ]);

            if ($response->successful() && isset($response['id'])) {
                return response()->json(['message' => 'Subscribed successfully'], 200);
            } else {
                return response()->json(['error' => $response['error']['message'] ?? 'Subscription failed'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Please try again.'], 500);
        }
    }
}