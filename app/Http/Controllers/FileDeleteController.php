<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Business;
use App\Models\BusinessImageDraft;
use App\Models\BusinessPhoto;
use App\Models\BusinessPhotoDraft;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileDeleteController extends Controller
{
    public function deleteAdditionalPhoto(Request $request)
    {
        $filePath = $request->getContent();
        if (Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
            return response('File deleted', 200);
        }
        return response('File not found', 404);
    }

    private function extractKeyFromUrl($url)
    {
        $parsedUrl = parse_url($url);
        return ltrim($parsedUrl['path'], '/');
    }

}
