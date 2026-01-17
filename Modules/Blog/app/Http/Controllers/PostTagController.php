<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Modules\Blog\Services\PostTagService;


class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(Request $request, PostTagService $tagService)
    {
        $tags = $tagService->allTags();
        return Inertia::render('tag/createTag',[
            'tags' => $tags
        ]);
    }

    public function store(Request $request, PostTagService $tagService)
    {
        $validated = $request->validate([
            'title' => 'string|required|max:255'
        ]);
        $result = $tagService->updateOrCreate($request, $request->id ?? null);
        return redirect()->back()->with('success', 'Tag created successfully');
    }

    public function delete($id, PostTagService $tagService)
    {
        $result = $tagService->delete($id);
        return redirect()->back()->with('success', 'Tag deleted successfully');
    }


}
