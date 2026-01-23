<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Blog\Database\Factories\PostFactory;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $guarded = [];
    protected $casts = [
        'meta_robot' => 'array',
        'meta_keyword' => 'array',
        'meta_description' => 'array',
    ];

   public function category()
   {
       return $this->belongsTo(PostCategory::class, 'category_id');
   }

   public function tag()
   {
       return $this->belongsToMany(PostTag::class, 'post_tag', 'post_id', 'tag_id');
   }


}
