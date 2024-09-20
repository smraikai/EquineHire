<?php

namespace App\Observers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\FileUploadController;
use App\Jobs\PostProcessing;

class BusinessObserver
{
    protected $request;
    protected $fileUploadController;
    protected static $handling = false;

    public function __construct(Request $request, FileUploadController $fileUploadController)
    {
        $this->request = $request;
        $this->fileUploadController = $fileUploadController;
    }

    public function saved(Business $business)
    {
        if (self::$handling)
            return;
        self::$handling = true;

        $jobChain = [
            new PostProcessing($business)
        ];

        Bus::chain($jobChain)->dispatch();

        self::$handling = false;
    }
}
