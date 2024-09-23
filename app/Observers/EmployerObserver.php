<?php

namespace App\Observers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\FileUploadController;
use App\Jobs\PostProcessing;

class EmployerObserver
{
    protected $request;
    protected $fileUploadController;
    protected static $handling = false;

    public function __construct(Request $request, FileUploadController $fileUploadController)
    {
        $this->request = $request;
        $this->fileUploadController = $fileUploadController;
    }

    public function saved(Employer $employer)
    {
        if (self::$handling)
            return;
        self::$handling = true;

        $jobChain = [
            new PostProcessing($employer)
        ];

        Bus::chain($jobChain)->dispatch();

        self::$handling = false;
    }
}
