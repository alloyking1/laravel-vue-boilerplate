<?php

namespace Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Blog\Database\Factories\PostTagFactory;

class PostTag extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ['title','description'];

    // protected static function newFactory(): PostTagFactory
    // {
    //     // return PostTagFactory::new();
    // }
}
