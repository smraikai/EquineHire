<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Http\Requests\UpdateBusinessRequest;

// Models
use App\Models\Business;
use App\Models\BusinessImageDraft;
use App\Models\BusinessCategory;
use App\Models\BusinessDiscipline;

// Illumination
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function index()
    {
        $businesses = Business::all();
        $users = User::all();

        return view('admin.index', compact('businesses', 'users'));
    }

    public function showBusiness(Business $business)
    {
        return view('admin.businesses.show', compact('business'));
    }

    public function showUser(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    // Add more admin-related methods as needed

    public function edit(Business $business)
    {

        $categories = BusinessCategory::all();
        $disciplines = BusinessDiscipline::all();
        return view('admin.businesses.edit', compact('business', 'categories', 'disciplines'));
    }

    public function update(Business $business, UpdateBusinessRequest $request)
    {

        // Log all received data, careful with sensitive data
        Log::info('Received data:', $request->all());

        // Validate the incoming request
        $validatedData = $request->validated();

        // Update slug if 'name' or 'state' has changed
        if ($business->name !== $validatedData['name']) {
            $business->slug = Str::slug($validatedData['name']);
        }
        if ($business->state !== $validatedData['state']) {
            $business->state_slug = Str::slug($validatedData['state']);
        }

        // Update post status to 'Published' (consider making this conditional)
        $validatedData['post_status'] = 'Published';

        // Mass assign all validated data
        $business->fill($validatedData);

        // Save the updated business details to the database
        $business->save();

        // Handle categories after saving the business
        if (! empty($validatedData['categories'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $categoryIds = explode(',', $validatedData['categories'][0]);
            $categoryIds = array_map('intval', $categoryIds);
            $categoryIds = array_filter($categoryIds);

            // Sync the categories to the business
            $business->categories()->sync($categoryIds);
        } else {
            $business->categories()->detach();
        }

        // Handle discipline after saving the business
        if (! empty($validatedData['disciplines'][0])) {
            // Split the first element (expecting a string of comma-separated integers)
            $disciplineIds = explode(',', $validatedData['disciplines'][0]);
            $disciplineIds = array_map('intval', $disciplineIds);
            $disciplineIds = array_filter($disciplineIds);

            // Sync the disciplines to the business
            $business->disciplines()->sync($disciplineIds);
        } else {
            $business->disciplines()->detach();
        }
        // Redirect to the updated business directory page with success message
        return redirect()->route('businesses.directory.show', [
            'state_slug' => $business->state_slug,
            'id' => $business->id,
            'slug' => $business->slug,
        ])->with('success', 'Business listing updated successfully.');
    }

    public function destroy(Business $business)
    {
        // Delete the business listing
        $business->delete();

        // Return to the admin index page with a success message
        return redirect()->route('admin.index')
            ->with('success', 'Business listing deleted successfully.');
    }

}
