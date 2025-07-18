<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Models\BlogImage;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\BlogImageRepositoryInterface;

class BlogController extends Controller
{
    protected $blogRepo;
    protected $blogImageRepo;

    public function __construct(
        BlogRepositoryInterface $blogRepo,
        BlogImageRepositoryInterface $blogImageRepo
    ) {
        $this->blogRepo = $blogRepo;
        $this->blogImageRepo = $blogImageRepo;
    }

    public function index()
    {

        $blogs = $this->blogRepo->all();

        return response()->json([
            'status' => true,
            'message' => 'All blogs fetched successfully.',
            'data' => $blogs
        ]);
    }

    public function store(BlogRequest $request)
    {

        $blog = $this->blogRepo->create($request->validated());

        if ($request->hasFile('images')) {
            $this->blogImageRepo->storeImages($request->file('images'), $blog->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog created successfully.',
            'data' => $blog->load('images'),
        ]);
    }

    public function show(Blog $blog)
    {
        return response()->json([
            'status' => true,
            'message' => 'Blog fetched successfully.',
            'data' => $blog->load('images'),
        ]);
    }

    public function update(BlogRequest $request, Blog $blog)
    {

        $this->blogRepo->update($blog, $request->validated());

        if ($request->hasFile('images')) {
            $this->blogImageRepo->storeImages($request->file('images'), $blog->id);
        }

        return response()->json([
            'status' => true,
            'message' => 'Blog updated successfully.',
            'data' => $blog->load('images'),
        ]);
    }

    public function destroy(Blog $blog)
    {

        foreach ($blog->images as $image) {
            $this->blogImageRepo->deleteImageById($image);
        }
        $this->blogRepo->delete($blog);

        return response()->noContent();
    }

    public function destroyImage(BlogImage $blogImage)
    {

        $this->blogImageRepo->deleteImageById($blogImage);

        return response()->noContent();
    }
}
