<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\PostTag;

class PostTagService
{
    public function updateOrCreate($payload, $id = null)
    {
        return PostTag::updateOrCreate([
            'id' => $id
        ], [
            'title' => $payload->title
        ]);
    }

    public function allTags(){
        return PostTag::all();
    }

    public function delete($id){
        return PostTag::find($id)->delete();
    }
}