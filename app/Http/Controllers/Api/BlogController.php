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
        try {
            $blogs = $this->blogRepo->all();

            return response()->json([
                'status' => true,
                'message' => 'All blogs fetched successfully.',
                'data' => $blogs
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch blogs.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(BlogRequest $request)
    {
        try {
            $blog = $this->blogRepo->create($request->validated());

            if ($request->hasFile('images')) {
                $this->blogImageRepo->storeImages($request->file('images'), $blog->id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Blog created successfully.',
                'data' => $blog->load('images'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create blog.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show(Blog $blog)
    {
        try {
            return response()->json([
                'status' => true,
                'message' => 'Blog fetched successfully.',
                'data' => $blog->load('images'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to fetch blog.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        try {
            $this->blogRepo->update($blog, $request->validated());

            if ($request->hasFile('images')) {
                $this->blogImageRepo->storeImages($request->file('images'), $blog->id);
            }

            return response()->json([
                'status' => true,
                'message' => 'Blog updated successfully.',
                'data' => $blog->load('images'),
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update blog.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Blog $blog)
    {
        try {
            foreach ($blog->images as $image) {
                $this->blogImageRepo->deleteImageById($image);
            }
            $this->blogRepo->delete($blog);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete blog.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroyImage(BlogImage $blogImage)
    {
        try {
            $this->blogImageRepo->deleteImageById($blogImage);

            return response()->noContent();
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete image.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
