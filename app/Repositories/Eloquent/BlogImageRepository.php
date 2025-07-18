<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogImage;
use App\Repositories\BlogImageRepositoryInterface;
use Illuminate\Support\Facades\File;

class BlogImageRepository implements BlogImageRepositoryInterface
{
    public function storeImages(array $images, int $blogId)
    {
        foreach ($images as $image) {
            $path = $image->store('uploads/blogs', 'public');
            BlogImage::create([
                'blog_id' => $blogId,
                'image_path' => $path,
            ]);
        }
    }

    public function deleteImageById(BlogImage $blogImage)
    {

        $imagePath = public_path('storage/' . $blogImage->image_path);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        return $blogImage->delete();
    }
}
