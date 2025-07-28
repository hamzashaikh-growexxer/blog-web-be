<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *     schema="Blog",
 *     title="Blog",
 *     type="object",
 *     required={"id", "title", "content"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="My First Blog"),
 *     @OA\Property(property="content", type="string", example="This is the content of the blog."),
 *     @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/BlogImage")),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2023-07-01T12:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2023-07-01T12:00:00Z")
 * )
 */
class Blog extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'title',
        'content',
    ];

    public function images()
    {
        return $this->hasMany(BlogImage::class);
    }
}
