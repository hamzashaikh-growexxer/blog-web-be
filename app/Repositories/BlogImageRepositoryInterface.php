<?php

namespace App\Repositories;

use Illuminate\Http\UploadedFile;

interface BlogImageRepositoryInterface
{
    public function storeImages(array $images, int $blogId);
    public function deleteImageById(int $id);
    public function deleteImagesByBlogId(int $blogId);
}
