<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostStoreRequest;
use App\Models\Post;
use Illuminate\Support\Facades\DB;

class PostController extends BaseController
{
    public function index()
    {
        $post = Post::all()->loadMissing('categories:id,name');
        return $this->sendResponse($post, 'All posts');
    }

    public function store(PostStoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->guard('sanctum')->ID();

        DB::beginTransaction();
        $post = Post::create($data);

        $post->categories()->attach($data['categories']);

        DB::commit();

        return $this->sendResponse($post->loadMissing('categories:id,name'), 'Post created successfully');
    }

    public function update(Post $post, PostStoreRequest $request)
    {
        if ($post->user_id != auth()->guard('sanctum')->ID()) {
            return $this->sendError([], 'Only author can update this post');
        }

        DB::beginTransaction();
        $data = $request->validated();
        $post->categories()->sync($data['categories']);
        $post->update($data);

        DB::commit();
        return $this->sendResponse($post, 'Update successful');
    }

    public function show(Post $post)
    {
        $post = $post
            ->loadMissing('categories:id,name')
            ->loadMissing('user:id,name');

        return $this->sendResponse($post, '');
    }

    public function destroy(Post $post)
    {
        if ($post->user_id != auth()->guard('sanctum')->ID()) {
            return $this->sendError([], 'Only author can delete this post');
        }

        $post->categories()->detach([]);
        Post::destroy($post->id);

        return $this->sendResponse($post, 'Successfully deleted post');
    }
}
