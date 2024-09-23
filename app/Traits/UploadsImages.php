<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait UploadsImages
{
    /**
     * Handle multiple image uploads.
     *
     * @param array $images
     * @param string $path
     * @return array
     */
    public function uploadMultipleImages(array $images, $path = 'images/tour'): array
    {
        $imagePaths = [];

        foreach ($images as $image) {
            if ($image instanceof UploadedFile) {
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path($path), $imageName);
                $imagePaths[] = $imageName;
            }
        }

        return $imagePaths;
    }

    /**
     * Handle a single image upload.
     *
     * @param UploadedFile $image
     * @param string $path
     * @return string
     */
    public function uploadSingleImage(UploadedFile $image, $path = 'images/tour'): string
    {
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path($path), $imageName);
        return $imageName;
    }
}
