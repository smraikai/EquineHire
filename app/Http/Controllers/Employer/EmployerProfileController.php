<?php

namespace App\Http\Controllers\Employer;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Employer;
use App\Traits\HasStates;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'website' => ['nullable', 'url', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'logo_path' => 'nullable|string',
            'featured_image_path' => 'nullable|string',
        ]);

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
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'website' => ['nullable', 'url', 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/'],
            'logo_path' => 'nullable|string',
            'featured_image_path' => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            if ($request->filled('logo_path')) {
                $employer->logo = $validatedData['logo_path'];
            }

            if ($request->filled('featured_image_path')) {
                $employer->featured_image = $validatedData['featured_image_path'];
            }

            $employer->update($validatedData);

            DB::commit();
            return redirect()->route('employers.index', $employer)->with('success', 'Employer profile updated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating employer profile: ' . $e->getMessage());
            return back()->with('error', 'An error occurred while updating the employer profile.');
        }
    }

}
