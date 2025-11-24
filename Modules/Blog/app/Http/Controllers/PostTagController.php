<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;


class PostTagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(Request $request)
    {
        return Inertia::render('tag/createTag');
    }
}
