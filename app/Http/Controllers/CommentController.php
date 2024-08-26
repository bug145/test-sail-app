<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends BaseController
{
    public function index(Post $post)
    {
        $comments = $post
            ->comments()
            ->with('user:id,name')
            ->get(['id', 'content', 'user_id', 'created_at']);
        return $this->sendResponse($comments, 'All comments');
    }

    public function store(Post $post, CommentStoreRequest $request)
    {
        $data = $request->validated();

        $saved = $post->comments()->create([
            'content' => $data['content'],
            'user_id' => auth()->guard('sanctum')->ID(),
            'post_id' => $post->id,
        ]);

        return $this->sendResponse($saved, 'Comment created successfully');
    }

    public function update(Comment $comment, CommentStoreRequest $request)
    {
        if ($comment->user_id != auth()->guard('sanctum')->ID()) {
            return $this->sendError([], 'Only author can update this comment');
        }

        $data = $request->validated();
        $comment->update($data);

        return $this->sendResponse($comment, 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id != auth()->guard('sanctum')->ID()) {
            return $this->sendError([], 'Only author can delete this comment');
        }

        return $this->sendResponse($comment->delete(), 'Comment deleted successfully');
    }
}
