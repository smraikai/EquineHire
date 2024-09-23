<?php

namespace App\Jobs;

use App\Models\Employer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

class PostProcessing implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $employer;

    public function __construct(Employer $employer)
    {
        $this->employer = $employer;
    }

    public function handle()
    {
        // Cache::put("business_{$this->business->id}_processed", true, now()->addMinutes(5));
    }
}
