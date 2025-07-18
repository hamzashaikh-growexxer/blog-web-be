<?php

namespace App\Repositories;

use App\Models\Blog;

interface BlogRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(Blog $blog, array $data);
    public function delete(Blog $blog);
}
