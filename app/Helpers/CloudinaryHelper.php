<?php

namespace App\Helpers;

use Cloudinary\Cloudinary;

class CloudinaryHelper
{
    public static function upload($filePath)
    {
        $cloudinary = new Cloudinary([
            'cloud' => [
                'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                'api_key'    => env('CLOUDINARY_API_KEY'),
                'api_secret' => env('CLOUDINARY_API_SECRET'),
            ],
        ]);

        return $cloudinary->uploadApi()->upload($filePath);
    }
}
