<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\JobApplication;
use App\Mail\NewJobApplicationMail;
use Illuminate\Support\Facades\Mail;

class ResendNewJobApplicationEmails extends Command
{
    protected $signature = 'emails:resend-job-applications';
    protected $description = 'Resend new job application emails for applications from the past two weeks';

    public function handle()
    {
        $twoWeeksAgo = now()->subWeeks(2);
        $recentApplications = JobApplication::where('created_at', '>=', $twoWeeksAgo)->get();

        $this->info("Found {$recentApplications->count()} job applications from the past two weeks.");

        foreach ($recentApplications as $application) {
            $jobListing = $application->jobListing;
            $recipient = $jobListing->email_link ?? $jobListing->user->email;

            Mail::to($recipient)->send(new NewJobApplicationMail($application));
            $this->info("Resent email for job application ID: {$application->id} to {$recipient}");
        }

        $this->info('Job application emails resent successfully.');
    }
}