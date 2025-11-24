<?php

namespace Modules\Blog\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class BlogController extends Controller
{
    public function index()
    {
        return Inertia::render('blog/index');
    }

    public function create()
    {
        return Inertia::render('blog/createBlog');
    }

    public function store(Request $request) {

    }
}
