<?php

namespace App\Repositories;

use App\Models\BlogImage;
use Illuminate\Http\UploadedFile;

interface BlogImageRepositoryInterface
{
    public function storeImages(array $images, int $blogId);
    public function deleteImageById(BlogImage $blogImage);
}
