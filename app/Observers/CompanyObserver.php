<?php

namespace App\Observers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\FileUploadController;
use App\Jobs\PostProcessing;

class CompanyObserver
{
    protected $request;
    protected $fileUploadController;
    protected static $handling = false;

    public function __construct(Request $request, FileUploadController $fileUploadController)
    {
        $this->request = $request;
        $this->fileUploadController = $fileUploadController;
    }

    public function saved(Company $company)
    {
        if (self::$handling)
            return;
        self::$handling = true;

        $jobChain = [
            new PostProcessing($company)
        ];

        Bus::chain($jobChain)->dispatch();

        self::$handling = false;
    }
}
