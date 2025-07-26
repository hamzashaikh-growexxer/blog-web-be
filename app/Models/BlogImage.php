<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="BlogImage",
 *     title="BlogImage",
 *     required={"id", "blog_id", "image_path"},
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="blog_id", type="integer", example=1),
 *     @OA\Property(property="image_path", type="string", example="uploads/blogs/image1.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-07-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-07-01T12:00:00Z")
 * )
 */
class BlogImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'blog_id',
        'image_path',
    ];


    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
}
