<?php

namespace App\Http\Controllers;

use App\Services\LocationService;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    protected $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function update(Request $request)
    {
        $request->validate([
            'country' => 'required|string|size:2'
        ]);

        $this->locationService->setLocation($request->country);

        return response()->json([
            'success' => true,
            'location' => $this->locationService->getLocation()
        ]);
    }

    public function current()
    {
        return response()->json($this->locationService->getLocation());
    }
}