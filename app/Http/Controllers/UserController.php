<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends BaseController
{
    public function index()
    {
        $user = auth()
            ->guard('sanctum')
            ->user()
            ->withCount('posts')
            ->withCount('comments')
            ->get();

        return $this->sendResponse($user, 'User info');
    }

    public function show(User $user)
    {
        $user = $user
            ->withCount('posts')
            ->withCount('comments')
            ->get()
            ->first()
            ->makeHidden(['email_verified_at', 'updated_at', 'email']);

        return $this->sendResponse($user, 'User info');
    }

    public function update()
    {
        $user = auth()
            ->guard('sanctum')
            ->user();

        return $this->sendResponse($user, 'User info');
    }
}
