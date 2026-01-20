<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Post;

class PostService
{
    // Service methods for Post management would go here
    public function updateOrCreate($payload, $id = null)
    {
        return Post::updateOrCreate([
            'id' => $id
        ], [
            'title' => $payload->title,
            'slug' => $payload->slug,
            'excerpt' => $payload->excerpt,
            'min_to_read' => $payload->min_to_read,
            'category' => $payload->category,
            // 'tag' => $payload->tag,
            'is_published' => $payload->is_published,
            'meta_description' => $payload->meta_description,
            'meta_keywords' => $payload->meta_keywords,
            'meta_robots' => $payload->meta_robots,
            'grade' => $payload->grade,
            'body' => $payload->body
        ]);
    }

    // public function allPost(){
    //     return PostTag::all();
    // }

    // public function delete($id){
    //     return PostTag::find($id)->delete();
    // }


    public function addTags($payload){

    }
}       