<?php

namespace App\Http\Controllers\Post;

use App\Http\Requests\PostRequest;
use App\Post;
use App\Presenters\PostPresenter;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $posts = $this->user()
            ->posts()
            ->published()
            ->latest()
            ->paginate();

        return Inertia::render('Post/List', [
           'type' => 'published',
           'typeText' => '文章',
           'posts' => PostPresenter::collection($posts)
                ->preset('list')
                ->get(),
        ]);
    }

    public function drafts()
    {
        $posts = $this->user()
            ->posts()
            ->unpublished()
            ->latest()
            ->paginate();

        return Inertia::render('Post/List', [
            'type' => 'drafts',
            'typeText' => '草稿',
            'posts' => PostPresenter::collection($posts)
                ->preset('list')
                ->get(),
        ]);
    }


    public function create()
    {
        return Inertia::render('Post/Form', [
            'post' => PostPresenter::make(Post::make())->get(),
        ]);
    }


    public function store(PostRequest $request)
    {
        $post = $this->user()
            ->posts()
            ->create($request->validated());

        return redirect("/posts/{$post->id}")->with('success', '文章新增成功');
    }


    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return Inertia::render('Post/Form', [
            'post' => PostPresenter::make($post)->with(fn (Post $post) => [
                'content' => $post->content,
            ])->get(),
        ]);
    }


    public function update(PostRequest $request, Post $post)
    {
        $this->authorize('update', $post);

        $post->update($request->validated());

        return redirect("/posts/{$post->id}")->with('success', '文章更新成功');
    }


    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect('/posts')->with('success','文章删除成功');
    }
}
