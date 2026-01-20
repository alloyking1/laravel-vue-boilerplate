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

    public function store(Request $request, PostService $Service)
    {
        dd($request->all());   
        $validated = $request->validate([
            'title' => 'string|required|max:255',
            'slug' => 'string|required|max:255',
            'excerpt' => 'string|required|max:255',
            'min_to_read' => 'string|required|max:255',
            'category' => 'integer|required|max:255',
            'tag' => 'array|required',
            'is_published' => 'boolean|required',
            'meta_description' => 'string|required|max:255',
            'meta_keywords' => 'string|required|max:255',
            'meta_robots' => 'string|required|max:255',
            'grade' => 'string|required|max:255',
            'body' => 'string|required'
        ]);
        $result = $Service->updateOrCreate($request, $request->id ?? null);
        return redirect()->back()->with('success', 'Post created successfully');
    }

    // public function delete($id, PostService $Service)
    // {
    //     $result = $Service->delete($id);
    //     return redirect()->back()->with('success', 'Tag deleted successfully');
    // }
}
