<?php

namespace App\Repositories\Eloquent;

use App\Models\BlogImage;
use App\Repositories\BlogImageRepositoryInterface;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function deleteImageById(int $id)
    {
        $image = BlogImage::findOrFail($id);
        $imagePath = public_path('storage/' . $image->image_path);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        return $image->delete();
    }

    public function deleteImagesByBlogId(int $blogId)
    {
        $images = BlogImage::where('blog_id', $blogId)->get();
        foreach ($images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }
    }
}
