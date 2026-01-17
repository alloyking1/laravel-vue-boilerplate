<?php

namespace Modules\Blog\Services;

use Modules\Blog\Models\PostCategory;

class PostCategoryService
{
    public function updateOrCreate($payload, $id = null)
    {
        return PostCategory::updateOrCreate([
            'id' => $id
        ], [
            'title' => $payload->title
        ]);
    }

    public function allCategories(){
        return PostCategory::all();
    }

    public function delete($id){
        return PostCategory::find($id)->delete();
    }
}