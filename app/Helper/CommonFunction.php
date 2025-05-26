<?php
namespace App\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CommonFunction
{
    public static function uploadFileImg($file, $subFolder): string
    {
        try {
            // Get file extension
            $extension = $file->getClientOriginalExtension();
            // Generate unique filename
            $filename = Str::random(10) . now()->timestamp . '.' . $extension;
            // Define the upload path
            $uploadPath = public_path('assets/img/' . $subFolder);

            // Create directory if it doesn't exist
            if (!File::exists($uploadPath)) {
                if (!File::makeDirectory($uploadPath, 0755, true)) {
                    throw new \Exception('Failed to create directory: ' . $uploadPath);
                }
            }

            // Create full path for the file
            $path = 'assets/img/' . $subFolder . '/' . $filename;
            $file->move($uploadPath, $filename);
            return $path;
        } catch (\Exception $e) {
            \Log::error('File upload error: ' . $e->getMessage());
            throw $e;
        }
    }
}
