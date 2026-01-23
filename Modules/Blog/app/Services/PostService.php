<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\Post;

class PostService
{
    //modify to use DTO later
    public function updateOrCreate($payload, $id = null)
    {
        $createPost = Post::updateOrCreate([
            'id' => $id
        ], [
            'title' => $payload->title,
            'slug' => $payload->slug,
            'excerpt' => $payload->excerpt,
            'minute_read' => $payload->min_to_read,
            'category_id' => $payload->category,
            'published' => $payload->is_published,
            'meta_description' => $payload->meta_description,
            'meta_keyword' => $payload->meta_keyword,
            'meta_robot' => $payload->meta_robot,
            'grade' => $payload->grade,
            'content' => $payload->body
        ]);

        $createPost->tag()->sync($payload->tag);
        return $createPost;
    }

    // public function allPost(){
    //     return PostTag::all();
    // }

    // public function delete($id){
    //     return PostTag::find($id)->delete();
    // }

}       