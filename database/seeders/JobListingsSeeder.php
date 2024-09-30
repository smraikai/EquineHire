<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\JobListing;
use App\Models\Employer;
use App\Models\JobListingCategory;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use League\Csv\Reader;
use League\Csv\Statement;
use Carbon\Carbon;

class JobListingsSeeder extends Seeder
{
    public function run()
    {
        $csvPath = public_path('jobs.csv');

        try {
            $csv = Reader::createFromPath($csvPath, 'r');
            $csv->setHeaderOffset(0);

            $headers = $csv->getHeader();
            Log::info("CSV Headers: " . implode(', ', $headers));

            $stmt = Statement::create();
            $records = $stmt->process($csv);

            $totalRows = iterator_count($records);
            Log::info("Total rows in CSV: " . $totalRows);

            $validRows = 0;
            $invalidRows = 0;

            $categories = JobListingCategory::pluck('id', 'name')->toArray();
            $adminUser = $this->getAdminUser();

            $uniqueCategories = [];
            foreach ($records as $record) {
                $uniqueCategories[$record['Job Categories']] = true;
            }

            $cutoffDate = Carbon::create(2024, 3, 1);

            foreach ($records as $offset => $record) {
                try {
                    // Log the first few rows to see their structure
                    if ($offset < 5) {
                        Log::info("Row " . ($offset + 2) . ": " . json_encode($record));
                    }

                    if (empty($record['Title']) || empty($record['Content'])) {
                        $invalidRows++;
                        Log::warning("Row " . ($offset + 2) . " is missing essential data. Skipping.");
                        continue;
                    }

                    $createdAt = $this->parseDate($record['Date'] ?? null);

                    // Skip jobs created before March 2024
                    if ($createdAt->lt($cutoffDate)) {
                        Log::info("Skipping job from " . $createdAt->toDateString() . ": " . $record['Title']);
                        continue;
                    }

                    $employer = $this->getOrCreateEmployer(
                        $record['company_details_company_name'] ?? null,
                        $record['company_details_company_website'] ?? null,
                        $record['Image Featured'] ?? null
                    );

                    $categoryName = $record['Job Categories'] ?? '';
                    $categoryId = $this->getCategoryId($categoryName, $categories);

                    $slug = $this->generateUniqueSlug($record['Title']);
                    $createdAt = $this->parseDate($record['Date'] ?? null);

                    JobListing::create([
                        'user_id' => $adminUser->id,
                        'employer_id' => $employer ? $employer->id : null,
                        'category_id' => $categoryId,
                        'title' => $record['Title'],
                        'slug' => $slug,
                        'description' => $record['Content'] ?? null,
                        'remote_position' => $this->parseBoolean($record['job_details_job_is_remote'] ?? ''),
                        'city' => $this->nullIfEmpty($record['job_details_job_city']),
                        'state' => $this->nullIfEmpty($record['job_details_job_state']),
                        'job_type' => $this->nullIfEmpty($record['job_details_job_type']),
                        'experience_required' => $this->nullIfEmpty($record['job_details_job_experience']),
                        'salary_type' => $this->getSalaryType($record['job_details_job_salary_type'] ?? null),
                        'hourly_rate_min' => $this->parseSalaryValue($record['job_details_job_salary_hourly'] ?? '', 'min'),
                        'hourly_rate_max' => $this->parseSalaryValue($record['job_details_job_salary_hourly'] ?? '', 'max'),
                        'salary_range_min' => $this->parseSalaryValue($record['job_details_job_salary'] ?? '', 'min'),
                        'salary_range_max' => $this->parseSalaryValue($record['job_details_job_salary'] ?? '', 'max'),
                        'application_type' => $this->nullIfEmpty($record['job_details_job_application_email_or_website']),
                        'application_link' => $this->nullIfEmpty($record['job_details_job_link']),
                        'email_link' => $this->nullIfEmpty($record['job_details_job_email']),
                        'is_active' => true,
                        'is_boosted' => $this->isJobBoosted($record['job_boosts'] ?? ''),
                        'created_at' => $createdAt,
                        'updated_at' => $createdAt,
                    ]);
                    $validRows++;
                    Log::info("Successfully imported job: " . $record['Title']);

                } catch (\Exception $e) {
                    $invalidRows++;
                    Log::error("Error importing job at row " . ($offset + 2) . ": " . $e->getMessage());
                    continue;
                }
            }

            Log::info("Import summary: Total rows: $totalRows, Valid rows: $validRows, Invalid rows: $invalidRows");

        } catch (\Exception $e) {
            Log::error("Error reading CSV file: " . $e->getMessage());
        }
    }

    private function parseDate($dateString)
    {
        if (empty($dateString)) {
            return now(); // Use current date if no date is provided
        }

        try {
            return Carbon::parse($dateString);
        } catch (\Exception $e) {
            Log::warning("Invalid date format: $dateString. Using current date.");
            return now();
        }
    }

    private function getSalaryType($salaryType)
    {
        if ($salaryType === null || trim($salaryType) === '') {
            return null; // Return null if salary type is not set
        }

        $salaryType = strtolower(trim($salaryType));

        if ($salaryType === 'hourly' || $salaryType === 'salary') {
            return $salaryType;
        }

        // Log a warning if an unexpected salary type is encountered
        Log::warning("Unexpected salary type: $salaryType. Setting to null.");
        return null; // Return null for unexpected salary types
    }

    private function getAdminUser()
    {
        return User::firstOrCreate(
            ['email' => 'admin@equinehire.com'],
            [
                'name' => 'Admin',
                'password' => bcrypt('password'), // You should change this password
            ]
        );
    }

    private function nullIfEmpty($value)
    {
        return (is_string($value) && trim($value) === '') ? null : $value;
    }

    private function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (JobListing::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }

    private function getOrCreateEmployer($name, $website, $logoUrl)
    {
        if (empty($name)) {
            return null;
        }
        $adminUser = $this->getAdminUser();
        $processedLogoUrl = $this->processImageUrl($logoUrl);

        $employer = Employer::firstOrCreate(
            ['name' => $name],
            [
                'website' => $website,
                'user_id' => $adminUser->id,
                'description' => ' ', // Just a single space
            ]
        );

        // Update the logo if it's not set or if we have a new one
        if (!$employer->logo || $processedLogoUrl) {
            $employer->logo = $processedLogoUrl;
            $employer->save();
        }

        return $employer;
    }

    private function processImageUrl($url)
    {
        if (empty($url)) {
            return null;
        }

        $path = parse_url($url, PHP_URL_PATH);
        $filename = basename($path);
        return '/eqh-old/' . $filename;
    }

    private function getCategoryId($categoryName, $categories)
    {
        // Trim the category name and decode HTML entities
        $categoryName = trim(html_entity_decode($categoryName, ENT_QUOTES | ENT_HTML5));

        // Direct mapping of category names to their expected IDs
        $categoryMapping = [
            'Groom Jobs' => 1,
            'Health & Veterinary Jobs' => 2,
            'Manager Jobs' => 3,
            'Office Jobs' => 4,
            'Rider Jobs' => 5,
            'Trainer Jobs' => 6,
            'Other Jobs' => 7,
        ];

        // Check if the category name exists in our mapping
        if (isset($categoryMapping[$categoryName])) {
            return $categoryMapping[$categoryName];
        }

        // If no exact match, try to find a partial match
        foreach ($categoryMapping as $key => $id) {
            if (stripos($categoryName, $key) !== false) {
                Log::info("Partial match found for category: '$categoryName'. Assigned to '$key'.");
                return $id;
            }
        }

        // If still no match, check for specific keywords
        $keywordMapping = [
            'groom' => 1,
            'health' => 2,
            'veterinary' => 2,
            'vet' => 2,
            'manager' => 3,
            'office' => 4,
            'rider' => 5,
            'trainer' => 6,
        ];

        foreach ($keywordMapping as $keyword => $id) {
            if (stripos($categoryName, $keyword) !== false) {
                Log::info("Keyword match found for category: '$categoryName'. Assigned to ID $id.");
                return $id;
            }
        }

        // If no match is found, log a warning and return the ID of 'Other Jobs' category
        Log::warning("Unrecognized job category: '$categoryName'. Assigning to 'Other Jobs'.");
        return 7; // ID for 'Other Jobs'
    }

    private function parseBoolean($value)
    {
        if (is_bool($value)) {
            return $value;
        }

        $value = strtolower(trim($value));
        return in_array($value, ['true', '1', 'yes', 'on'], true);
    }

    private function parseSalaryValue($salary, $type)
    {
        if (empty($salary)) {
            return null;
        }

        // Remove '$' and any spaces
        $salary = str_replace(['$', ' '], '', $salary);

        // Check if it's a range
        if (strpos($salary, '-') !== false) {
            list($min, $max) = explode('-', $salary);
            $min = str_replace(',', '', $min);
            $max = str_replace(',', '', $max);
            return $type === 'min' ? (float) $min : (float) $max;
        }

        // If it's a single value, return it for both min and max
        $salary = str_replace(',', '', $salary);
        return (float) $salary;
    }

    private function isJobBoosted($boostData)
    {
        return !empty($boostData) && $boostData !== 'a:1:{i:0;s:0:"";}';
    }
}