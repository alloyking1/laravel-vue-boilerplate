<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Blog\Services\PostCategoryService;
use Inertia\Inertia;
use Inertia\Response;

class PostCategoryController extends Controller
{
    public function create(Request $request, PostCategoryService $Service)
    {
        $category = $Service->allCategories();
        return Inertia::render('category/createCategory',[
            'category' => $category
        ]);
    }

    public function store(Request $request, PostCategoryService $Service)
    {
        $validated = $request->validate([
            'title' => 'string|required|max:255'
        ]);
        $result = $Service->updateOrCreate($request, $request->id ?? null);
        return redirect()->back()->with('success', 'Category created successfully');
    }

    public function delete($id, PostCategoryService $Service)
    {
        $result = $Service->delete($id);
        return redirect()->back()->with('success', 'Tag deleted successfully');
    }
}
