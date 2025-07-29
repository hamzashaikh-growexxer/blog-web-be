<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Http\Requests\BlogRequest;
use App\Models\BlogImage;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\BlogImageRepositoryInterface;
/**
 * @OA\Info(
 *     title="Blog API",
 *     version="1.0.0",
 *     description="API documentation for the Blog system"
 * )
 */


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

    /**
     * @OA\Get(
     *     path="/api/blogs",
     *     summary="Get all blogs",
     *     operationId="getBlog",
     *     tags={"Blogs"},
     *     @OA\Response(
     *         response=200,
     *         description="List of blogs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="All blogs fetched successfully."),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Blog")
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {

        $blogs = $this->blogRepo->all();

        return response()->json([
            'status' => true,
            'message' => 'All blogs fetched successfully.',
            'data' => $blogs
        ]);
    }

   /**
     * @OA\Post(
     *     path="/api/blogs",
     *     summary="Create a new blog",
     *     operationId="storeBlog",
     *     tags={"Blogs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "content"},
     *                 @OA\Property(property="title", type="string", example="My Blog Title"),
     *                 @OA\Property(property="content", type="string", example="This is a blog post."),
     *                 @OA\Property(
     *                     property="images[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Blog created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Blog created successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Blog")
     *         )
     *     ),
     *      @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "title": {"The title field is required."},
     *                     "images.0": {"The images.0 must be an image."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */


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

    /**
     * @OA\Get(
     *     path="/api/blogs/{id}",
     *     summary="Get a single blog",
     *     operationId="showBlog",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Blog ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog fetched successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Blog fetched successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Blog")
     *         )
     *     )
     * )
     */

    public function show(Blog $blog)
    {
        return response()->json([
            'status' => true,
            'message' => 'Blog fetched successfully.',
            'data' => $blog->load('images'),
        ]);
    }
    /**
     * @OA\POST(
     *     path="/api/blogs/{id}",
     *     summary="Update an existing blog",
     *     operationId="updateBlog",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Blog ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"title", "content"},
     *                 @OA\Property(property="title", type="string", example="Updated Blog Title"),
     *                 @OA\Property(property="content", type="string", example="Updated blog content."),
     *                 @OA\Property(
     *                     property="images[]",
     *                     type="array",
     *                     @OA\Items(type="string", format="binary")
     *                 ),
     *                     @OA\Property(
     *                     property="_method",
     *                     type="string",
     *                     description="HTTP method override for method spoofing (use 'PUT' when sending POST)",
     *                     example="PUT"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Blog updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Blog updated successfully."),
     *             @OA\Property(property="data", ref="#/components/schemas/Blog")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={
     *                     "title": {"The title field is required."},
     *                     "images.0": {"The images.0 must be an image."}
     *                 }
     *             )
     *         )
     *     )
     * )
     */

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
    /**
     * @OA\Delete(
     *     path="/api/blogs/{id}",
     *     summary="Delete a blog",
     *     operationId="destroyBlog",
     *     tags={"Blogs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Blog ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Blog deleted successfully"
     *     )
     * )
     */


    public function destroy(Blog $blog)
    {

        foreach ($blog->images as $image) {
            $this->blogImageRepo->deleteImageById($image);
        }
        $this->blogRepo->delete($blog);

        return response()->noContent();
    }

    /**
     * @OA\Delete(
     *     path="/api/blog-images/{id}",
     *     summary="Delete a blog image",
     *     operationId="destroyBlogImage",
     *     tags={"BlogImages"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Blog Image ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Blog image deleted successfully"
     *     )
     * )
     */

    public function destroyImage(BlogImage $blogImage)
    {

        $this->blogImageRepo->deleteImageById($blogImage);

        return response()->noContent();
    }
}
