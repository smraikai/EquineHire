<?php

namespace App\Http\Controllers\Employer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Traits\HasStates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EmployerProfileController extends Controller
{

    use HasStates;

    public function index()
    {
        $user = auth()->user();
        $employer = $user->employer;

        return view('dashboard.employers.index', compact('employer'));
    }

    public function create()
    {

        $this->authorize('create', Employer::class);

        $employer = new Employer(); // Initialize an empty Employer model
        $states = $this->getStates();
        return view('dashboard.employers.create', compact('employer', 'states'));
    }

    public function edit(Request $request, Employer $employer)
    {
        $this->authorize('update', $employer);

        $states = $this->getStates();
        return view('dashboard.employers.edit', compact('employer', 'states'));
    }

    public function store(Request $request)
    {
        $this->authorize('create', Employer::class);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'street_address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'website' => ['nullable', 'url', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'logo_path' => 'nullable|string',
            'featured_image_path' => 'nullable|string',
        ], [
            'street_address.required' => 'Please select an address from the search dropdown.',
        ]);

        // Add validation check for required location fields
        if (!$request->state || !$request->latitude || !$request->longitude) {
            throw ValidationException::withMessages([
                'street_address' => ['Please enter an address using the address search field.']
            ]);
        }

        DB::beginTransaction();

        try {
            $employer = new Employer();
            $employer->user_id = auth()->id();

            if ($request->filled('logo_path')) {
                $employer->logo = $validatedData['logo_path'];
            }

            if ($request->filled('featured_image_path')) {
                $employer->featured_image = $validatedData['featured_image_path'];
            }

            $employer->fill($validatedData);
            $employer->save();

            DB::commit();
            return redirect()->route('employers.index', $employer)
                ->with('success', 'New employer profile created successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating employer profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while creating the employer profile.');
        }
    }

    public function update(Request $request, Employer $employer)
    {
        $this->authorize('update', $employer);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'street_address' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'website' => ['nullable', 'url', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'logo_path' => 'nullable|string',
            'featured_image_path' => 'nullable|string',
        ], [
            'street_address.required' => 'Please select an address from the search dropdown.',
        ]);

        // Add validation check for required location fields
        if (!$request->state || !$request->latitude || !$request->longitude) {
            throw ValidationException::withMessages([
                'street_address' => ['Please enter an address using the address search field.']
            ]);
        }

        DB::beginTransaction();

        try {
            // Convert latitude and longitude to floats
            $validatedData['latitude'] = (float) $validatedData['latitude'];
            $validatedData['longitude'] = (float) $validatedData['longitude'];

            if ($request->filled('logo_path')) {
                $employer->logo = $validatedData['logo_path'];
            }

            if ($request->filled('featured_image_path')) {
                $employer->featured_image = $validatedData['featured_image_path'];
            }

            $employer->update($validatedData);

            DB::commit();
            return redirect()->route('employers.index', $employer)
                ->with('success', 'Employer profile updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating employer profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the employer profile.');
        }
    }

}
