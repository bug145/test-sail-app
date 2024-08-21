<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;

class PostController extends BaseController
{
    public function index()
    {
        $post = Post::all();
        return $this->sendResponse($post, 'All posts');
    }

    public function store(PostStoreRequest $request)
    {
        $validated = $request->validated();
        $post = Post::create($validated);
        return $this->sendResponse($post, 'Post created successfully');
    }

    public function update(Post $post, PostStoreRequest $request)
    {
        $post->update();
        $validated = $request->validated();
        $post = Post::create($validated);
        return $this->sendResponse($post, 'Update successful');
    }

    public function show(Post $post, PostStoreRequest $request)
    {
        return $this->sendResponse($post, '');
    }
}
