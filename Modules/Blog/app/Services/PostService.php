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
            'title' => $payload->title
        ]);
    }

    // public function allTags(){
    //     return PostTag::all();
    // }

    // public function delete($id){
    //     return PostTag::find($id)->delete();
    // }
}       