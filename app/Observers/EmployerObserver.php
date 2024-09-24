<?php

namespace App\Observers;

use App\Models\Employer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use App\Http\Controllers\LogoUploadController;
use App\Jobs\PostProcessing;

class EmployerObserver
{
    protected $request;
    protected $fileUploadController;
    protected static $handling = false;

    public function __construct(Request $request, LogoUploadController $logoUploadController)
    {
        $this->request = $request;
        $this->logoUploadController = $logoUploadController;
    }

    public function saved(Employer $employer)
    {
    }
}
