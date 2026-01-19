<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Blog\Services\PostService;
use Modules\Blog\Models\PostCategory;
use Modules\Blog\Models\PostTag;


class PostController extends Controller
{
    
    public function index()
    {
        return Inertia::render('blog/index');
    }

    public function create(Request $request, PostService $Service)
    {
        return Inertia::render('blog/createBlog',[
            'categories' =>  PostCategory::all(),
            'tags' =>  PostTag::all()
        ]);
        
    }

    // public function store(Request $request, PostCategoryService $Service)
    // {
    //     $validated = $request->validate([
    //         'title' => 'string|required|max:255'
    //     ]);
    //     $result = $Service->updateOrCreate($request, $request->id ?? null);
    //     return redirect()->back()->with('success', 'Category created successfully');
    // }

    // public function delete($id, PostCategoryService $Service)
    // {
    //     $result = $Service->delete($id);
    //     return redirect()->back()->with('success', 'Tag deleted successfully');
    // }
}
