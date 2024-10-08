<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use App\Models\JobApplication;

class NewJobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobApplication;

    public function __construct(JobApplication $jobApplication)
    {
        $this->jobApplication = $jobApplication;
    }

    public function envelope(): Envelope
    {
        $jobTitle = $this->jobApplication->jobListing->title;

        return new Envelope(
            subject: "New Applicant for {$jobTitle} from EquineHire",
            from: new Address(config('mail.from.address'), config('mail.from.name')),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-job-application',
        );
    }

    public function attachments(): array
    {
        return [];
    }

    public function withMetadata($metadata)
    {
        $metadata['message_stream'] = 'outbound';
        return $this;
    }
}