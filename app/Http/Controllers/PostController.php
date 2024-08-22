<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use App\Models\Category;

class PostController extends BaseController
{
    public function index()
    {
        $post = Post::all();
        return $this->sendResponse($post, 'All posts');
    }

    public function store(PostStoreRequest $request)
    {
        $userId = auth()->user()->id;

        $data = $request->validated();
        $data['user_id'] = $userId;

        // $categories = Category::whereIn('id', $data['categories'])->get();
        // return $categories;
        // TODO: Добавить категории поста
        $post = Post::create($data);
        return $this->sendResponse($post, 'Post created successfully');
    }

    public function update(Post $post, PostStoreRequest $request)
    {
        $post->update();
        $validated = $request->validated();
        $post = Post::create($validated);
        return $this->sendResponse($post, 'Update successful');
    }

    public function show(Post $post)
    {
        return $this->sendResponse($post, '');
    }
}
