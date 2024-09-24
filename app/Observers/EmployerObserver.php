<?php

namespace App\Observers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\UploadController;
use App\Jobs\PostProcessing;

class EmployerObserver
{
    protected $request;
    protected $fileUploadController;
    protected static $handling = false;

    public function __construct(Request $request, UploadController $uploadController)
    {
        $this->request = $request;
        $this->uploadController = $uploadController;
    }

    public function saved(Employer $employer)
    {
    }
}
