<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
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
            ->get()
            ->first();

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

    public function update(UserStoreRequest $request)
    {
        $user = auth()
            ->guard('sanctum')
            ->user();

        $data = $request->validated();

        if ($request->hasFile('avatar')) {
            unset($data['avatar']);
            $file = $request->file('avatar');

            if ($file->isValid()) {
                $path = $request->file('avatar')->store("avatars", 'minio');
                $user->update(["avatar" => $path]);
            }
        }

        $user->update($data);
        $user = $user
            ->withCount('posts')
            ->withCount('comments')
            ->get()
            ->first();


        return $this->sendResponse($user, 'User info');
    }

    public function destroy()
    {
        $user = auth()
            ->guard('sanctum')
            ->user();

        $user->delete();


        return $this->sendResponse([], 'User successfully deleted');
    }
}
