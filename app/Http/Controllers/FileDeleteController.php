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
    public function deleteLogo(Request $request)
    {
        $request->validate([
            'business_id' => 'required|integer|exists:businesses,id',
        ]);

        $business = Business::findOrFail($request->input('business_id'));

        if ($business->logo) {
            $originalKey = $this->extractKeyFromUrl($business->logo);
            $webpKey = $this->getWebpPath($originalKey);

            Storage::disk('public')->delete($originalKey);
            Storage::disk('public')->delete($webpKey);

            $business->logo = null;
            $business->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Logo deleted successfully',
        ]);
    }
    public function deleteFeaturedImage(Request $request)
    {
        $request->validate([
            'business_id' => 'required|integer|exists:businesses,id',
        ]);

        $business = Business::findOrFail($request->input('business_id'));

        if ($business->featured_image) {
            $originalKey = $this->extractKeyFromUrl($business->featured_image);
            $webpKey = $this->getWebpPath($originalKey);

            Storage::disk('public')->delete($originalKey);
            Storage::disk('public')->delete($webpKey);

            $business->featured_image = null;
            $business->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Featured image deleted successfully',
        ]);
    }

    public function deleteAdditionalPhoto(Request $request)
    {
        $request->validate([
            'business_id' => 'required|integer|exists:businesses,id',
            'file_path' => 'required|string',
        ]);

        $businessId = $request->input('business_id');
        $filePath = $request->input('file_path');

        DB::beginTransaction();

        try {
            $photo = BusinessPhoto::where('business_id', $businessId)
                ->where('path', $filePath)
                ->firstOrFail();

            $originalKey = $this->extractKeyFromUrl($filePath);
            $webpKey = $this->getWebpPath($originalKey);

            $deleteOriginal = Storage::disk('public')->delete($originalKey);
            $deleteWebp = Storage::disk('public')->delete($webpKey);

            if (! $deleteOriginal && ! $deleteWebp) {
                throw new \Exception("Failed to delete both original and WEBP versions of the file: " . $filePath);
            }

            $photo->delete();
            DB::commit();

            return response()->json(['success' => true, 'message' => 'Photo successfully deleted']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Exception during deletion: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to delete the photo'], 500);
        }
    }

    private function getWebpPath($originalPath)
    {
        $pathInfo = pathinfo($originalPath);
        return $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';
    }

    private function extractKeyFromUrl($url)
    {
        $parsedUrl = parse_url($url);
        return ltrim($parsedUrl['path'], '/');
    }

}
