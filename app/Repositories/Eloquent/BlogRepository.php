<?php

namespace App\Repositories\Eloquent;

use App\Models\Blog;
use App\Repositories\BlogRepositoryInterface;

class BlogRepository implements BlogRepositoryInterface
{
    public function all()
    {
        return Blog::with('images')->get();
    }

    public function find($id)
    {
        return Blog::with('images')->findOrFail($id);
    }

    public function create(array $data)
    {
        return Blog::create($data);
    }

    public function update(Blog $blog, array $data)
    {
        $blog->update($data);
        return $blog;
    }

    public function delete(Blog $blog)
    {
        return $blog->delete();
    }
}
