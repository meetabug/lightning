<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Post;
use App\Presenters\PostPresenter;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowPostList extends Controller
{

    public function __invoke(Request $request)
    {
        $posts = Post::with('author')
            ->published()
            ->latest()
            ->paginate();

        return Inertia::render('Home', [
            'posts' => PostPresenter::collection($posts)
                ->preset('list')
                ->get(),
        ]);
    }
}
