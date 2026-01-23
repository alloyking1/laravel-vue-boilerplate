<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Blog\Services\PostService;
use Modules\Blog\Models\PostCategory;
use Modules\Blog\Models\PostTag;
use Modules\Blog\Enums\PostGradeEnum;
use Modules\Blog\Http\Requests\CreatePostRequest;


class PostController extends Controller
{
    
    public function index()
    {
        return Inertia::render('blog/index');
    }

    public function create(PostService $Service)
    {
        return Inertia::render('blog/createBlog',[
            'categories' =>  PostCategory::all(),
            'tags' =>  PostTag::all(),
            'postGradeEnum' =>  PostGradeEnum::cases(),
        ]);
        
    }

    public function store(CreatePostRequest $request, PostService $Service)
    {
        $result = $Service->updateOrCreate($request, $request->id ?? null);
        return redirect()->back()->with('success', 'Post created successfully');
    }

    // public function delete($id, PostService $Service)
    // {
    //     $result = $Service->delete($id);
    //     return redirect()->back()->with('success', 'Tag deleted successfully');
    // }
}
